<?php

namespace Vendor\HetznerRobot\Http\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Vendor\HetznerRobot\Exceptions\ApiException;
use Vendor\HetznerRobot\Exceptions\AuthenticationException;
use Vendor\HetznerRobot\Exceptions\AuthorizationException;
use Vendor\HetznerRobot\Exceptions\ConflictException;
use Vendor\HetznerRobot\Exceptions\HetznerException;
use Vendor\HetznerRobot\Exceptions\NetworkException;
use Vendor\HetznerRobot\Exceptions\NotFoundException;
use Vendor\HetznerRobot\Exceptions\RateLimitException;
use Vendor\HetznerRobot\Exceptions\ServerException;
use Vendor\HetznerRobot\Exceptions\ValidationException;
use Vendor\HetznerRobot\Http\Middleware\RetryMiddleware;

class HetznerClient
{
    private string $username;

    private string $password;

    private string $baseUrl;

    private int $timeout;

    private int $maxRetries;

    private int $retryBackoff;

    private bool $loggingEnabled;

    private ?string $loggingChannel;

    private ?GuzzleClient $guzzleClient = null;

    private array $requestHooks = [];

    private array $responseHooks = [];

    private bool $async = false;

    private ?array $batchQueue = null;

    private array $lastRateLimit = [
        'limit' => null,
        'remaining' => null,
        'reset' => null,
        'max_request' => null,
        'interval' => null,
    ];

    public function __construct(string $username = '', string $password = '', array $config = [])
    {
        $this->username = $username ?: ($config['username'] ?? '');
        $this->password = $password ?: ($config['password'] ?? '');
        $this->baseUrl = $config['base_url'] ?? 'https://robot-ws.your-server.de';
        $this->timeout = (int) ($config['timeout'] ?? 30);
        $this->maxRetries = (int) ($config['retries'] ?? 3);
        $this->retryBackoff = (int) ($config['retry_backoff'] ?? 100);
        $this->loggingEnabled = (bool) ($config['logging']['enabled'] ?? false);
        $this->loggingChannel = $config['logging']['channel'] ?? null;
    }

    public function setGuzzleClient(GuzzleClient $client): self
    {
        $this->guzzleClient = $client;

        return $this;
    }

    public function setCredentials(string $username, string $password): self
    {
        $this->username = $username;
        $this->password = $password;
        $this->guzzleClient = null; // Rebuild client

        return $this;
    }

    public function authenticate(string $username, string $password): self
    {
        return $this->setCredentials($username, $password);
    }

    public function setAsync(bool $async): self
    {
        $this->async = $async;

        return $this;
    }

    public function startBatch(): void
    {
        $this->batchQueue = [];
    }

    /**
     * @return PromiseInterface[]|null
     */
    public function endBatch(): ?array
    {
        $queue = $this->batchQueue;
        $this->batchQueue = null;

        return $queue;
    }

    public function isBatching(): bool
    {
        return $this->batchQueue !== null;
    }

    public function addRequestHook(callable $hook): self
    {
        $this->requestHooks[] = $hook;

        return $this;
    }

    public function addResponseHook(callable $hook): self
    {
        $this->responseHooks[] = $hook;

        return $this;
    }

    public function getLastRateLimit(): array
    {
        return $this->lastRateLimit;
    }

    /**
     * Send HTTP Request.
     *
     * @return mixed Response array or PromiseInterface
     *
     * @throws HetznerException
     */
    public function request(string $method, string $uri, array $options = [])
    {
        if ($this->async || $this->isBatching()) {
            $promise = $this->requestAsync($method, $uri, $options);
            if ($this->isBatching()) {
                $this->batchQueue[] = $promise;
            }
            // Reset async mode
            $this->async = false;

            return $promise;
        }

        try {
            $response = $this->getGuzzleClient()->request($method, $uri, $options);
            $this->updateRateLimit($response);

            return $this->decodeResponse($response);
        } catch (\Throwable $e) {
            throw $this->mapException($e);
        }
    }

    /**
     * Send HTTP Request asynchronously.
     */
    public function requestAsync(string $method, string $uri, array $options = []): PromiseInterface
    {
        $promise = $this->getGuzzleClient()->requestAsync($method, $uri, $options);

        return $promise->then(
            function (ResponseInterface $response) {
                $this->updateRateLimit($response);

                return $this->decodeResponse($response);
            },
            function (\Throwable $reason) {
                throw $this->mapException($reason);
            }
        );
    }

    private function getGuzzleClient(): GuzzleClient
    {
        if ($this->guzzleClient === null) {
            $this->guzzleClient = $this->buildGuzzleClient();
        }

        return $this->guzzleClient;
    }

    private function buildGuzzleClient(): GuzzleClient
    {
        $stack = HandlerStack::create();

        // Add retry & backoff middleware
        $retry = new RetryMiddleware($this->maxRetries, $this->retryBackoff);
        $stack->push(Middleware::retry($retry->decider(), $retry->delay()));

        // Add custom request hooks middleware
        $stack->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                foreach ($this->requestHooks as $hook) {
                    $request = $hook($request) ?: $request;
                }

                return $handler($request, $options);
            };
        });

        // Add custom response hooks middleware
        $stack->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                return $handler($request, $options)->then(function (ResponseInterface $response) {
                    foreach ($this->responseHooks as $hook) {
                        $response = $hook($response) ?: $response;
                    }

                    return $response;
                });
            };
        });

        // Add logging middleware if enabled
        if ($this->loggingEnabled) {
            $stack->push(function (callable $handler) {
                return function (RequestInterface $request, array $options) use ($handler) {
                    $this->logRequest($request);

                    return $handler($request, $options)->then(
                        function (ResponseInterface $response) {
                            $this->logResponse($response);

                            return $response;
                        },
                        function (\Throwable $reason) {
                            $this->logError($reason);
                            throw $reason;
                        }
                    );
                };
            });
        }

        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => 'laravel-hetzner-robot/1.0.0',
        ];

        $clientConfig = [
            'base_uri' => rtrim($this->baseUrl, '/').'/',
            'headers' => $headers,
            'timeout' => $this->timeout,
            'handler' => $stack,
        ];

        if ($this->username !== '' && $this->password !== '') {
            $clientConfig['auth'] = [$this->username, $this->password];
        }

        return new GuzzleClient($clientConfig);
    }

    private function updateRateLimit(ResponseInterface $response): void
    {
        $limit = $response->getHeaderLine('RateLimit-Limit');
        $remaining = $response->getHeaderLine('RateLimit-Remaining');
        $reset = $response->getHeaderLine('RateLimit-Reset');

        if ($limit !== '') {
            $this->lastRateLimit['limit'] = (int) $limit;
        }
        if ($remaining !== '') {
            $this->lastRateLimit['remaining'] = (int) $remaining;
        }
        if ($reset !== '') {
            $this->lastRateLimit['reset'] = (int) $reset;
        }
    }

    /**
     * Decode JSON response body.
     */
    private function decodeResponse(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        if ($body === '') {
            return [];
        }

        $decoded = json_decode($body, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Map Guzzle Exceptions to Hetzner Custom Exceptions.
     */
    public function mapException(\Throwable $e): HetznerException
    {
        if ($e instanceof HetznerException) {
            return $e;
        }

        if ($e instanceof ConnectException) {
            return new NetworkException('Connection error: '.$e->getMessage(), 0, $e);
        }

        if ($e instanceof RequestException && $e->getResponse() !== null) {
            $response = $e->getResponse();
            $status = $response->getStatusCode();
            $body = $this->decodeResponse($response);
            $errorData = $body['error'] ?? [];

            $message = $errorData['message'] ?? $e->getMessage();
            $errorCode = $errorData['code'] ?? '';
            $details = $errorData;

            switch ($status) {
                case 401:
                    return new AuthenticationException($message, $status, $errorCode, $details, $e);
                case 403:
                    if ($errorCode === 'RATE_LIMIT_EXCEEDED') {
                        $maxRequest = $errorData['max_request'] ?? null;
                        $interval = $errorData['interval'] ?? null;
                        $this->lastRateLimit['max_request'] = $maxRequest;
                        $this->lastRateLimit['interval'] = $interval;

                        return new RateLimitException(
                            $message,
                            $status,
                            $errorCode,
                            $details,
                            $e
                        );
                    }

                    return new AuthorizationException($message, $status, $errorCode, $details, $e);
                case 404:
                    return new NotFoundException($message, $status, $errorCode, $details, $e);
                case 400:
                    if ($errorCode === 'INVALID_INPUT') {
                        return new ValidationException($message, $status, $errorCode, $details, $e);
                    }

                    return new ApiException($message, $status, $errorCode, $details, $e);
                case 409:
                    return new ConflictException($message, $status, $errorCode, $details, $e);
                default:
                    if ($status >= 500 && $status <= 599) {
                        return new ServerException($message, $status, $errorCode, $details, $e);
                    }

                    return new ApiException($message, $status, $errorCode, $details, $e);
            }
        }

        return new HetznerException('An unexpected error occurred: '.$e->getMessage(), 0, $e);
    }

    private function logRequest(RequestInterface $request): void
    {
        $message = sprintf(
            'Hetzner Robot API Request: %s %s',
            $request->getMethod(),
            $request->getUri()
        );
        $this->log('info', $message, [
            'headers' => $request->getHeaders(),
            'body' => (string) $request->getBody(),
        ]);
    }

    private function logResponse(ResponseInterface $response): void
    {
        $message = sprintf(
            'Hetzner Robot API Response: %d',
            $response->getStatusCode()
        );
        $this->log('info', $message, [
            'headers' => $response->getHeaders(),
            'body' => (string) $response->getBody(),
        ]);
    }

    private function logError(\Throwable $e): void
    {
        $message = sprintf(
            'Hetzner Robot API Error: %s',
            $e->getMessage()
        );
        $this->log('error', $message, [
            'exception' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function log(string $level, string $message, array $context = []): void
    {
        if (class_exists(Log::class)) {
            if ($this->loggingChannel) {
                Log::channel($this->loggingChannel)->$level($message, $context);
            } else {
                Log::$level($message, $context);
            }
        }
    }
}
