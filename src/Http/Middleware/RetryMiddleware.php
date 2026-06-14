<?php

namespace Vendor\HetznerRobot\Http\Middleware;

use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RetryMiddleware
{
    private int $maxRetries;

    private int $backoffMultiplier;

    public function __construct(int $maxRetries = 3, int $backoffMultiplier = 100)
    {
        $this->maxRetries = $maxRetries;
        $this->backoffMultiplier = $backoffMultiplier;
    }

    /**
     * Get the decider callback for Guzzle's retry middleware.
     */
    public function decider(): callable
    {
        return function (
            int $retries,
            RequestInterface $request,
            ?ResponseInterface $response = null,
            ?\Throwable $exception = null
        ): bool {
            if ($retries >= $this->maxRetries) {
                return false;
            }

            // Retry on connection exceptions (network issues)
            if ($exception instanceof ConnectException) {
                return true;
            }

            // Retry on server errors and rate limits
            if ($response !== null) {
                $status = $response->getStatusCode();
                if ($status === 429 || ($status >= 500 && $status <= 599)) {
                    return true;
                }

                // Check for rate limit error in 403 Forbidden
                if ($status === 403) {
                    $body = (string) $response->getBody();
                    $response->getBody()->seek(0);
                    $decoded = json_decode($body, true);
                    if (isset($decoded['error']['code']) && $decoded['error']['code'] === 'RATE_LIMIT_EXCEEDED') {
                        return true;
                    }
                }
            }

            return false;
        };
    }

    /**
     * Get the delay callback for Guzzle's retry middleware (returns delay in milliseconds).
     */
    public function delay(): callable
    {
        return function (int $retries, ?ResponseInterface $response = null): int {
            if ($response !== null) {
                $status = $response->getStatusCode();
                if ($status === 403 || $status === 429) {
                    $body = (string) $response->getBody();
                    $response->getBody()->seek(0);
                    $decoded = json_decode($body, true);

                    if (isset($decoded['error']['interval'])) {
                        return (int) $decoded['error']['interval'] * 1000;
                    }

                    $resetHeader = $response->getHeaderLine('RateLimit-Reset');
                    if ($resetHeader !== '') {
                        $resetTime = (int) $resetHeader;
                        $delaySeconds = max(1, $resetTime - time());

                        return $delaySeconds * 1000;
                    }
                }
            }

            // Exponential backoff
            return (int) (pow(2, $retries) * $this->backoffMultiplier);
        };
    }
}
