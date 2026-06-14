<?php

namespace Vendor\HetznerRobot\Tests\Feature;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vendor\HetznerRobot\Collections\ServerCollection;
use Vendor\HetznerRobot\DTOs\Server;
use Vendor\HetznerRobot\Exceptions\AuthenticationException;
use Vendor\HetznerRobot\Exceptions\NetworkException;
use Vendor\HetznerRobot\Exceptions\ValidationException;
use Vendor\HetznerRobot\Http\Client\HetznerClient;
use Vendor\HetznerRobot\Http\Middleware\RetryMiddleware;
use Vendor\HetznerRobot\Managers\HetznerManager;
use Vendor\HetznerRobot\Tests\TestCase;

class MockedHttpTest extends TestCase
{
    private function createMockClient(array $responses, int $maxRetries = 3, int $retryBackoff = 0): HetznerClient
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);

        // Add retry middleware
        $retry = new RetryMiddleware($maxRetries, $retryBackoff);
        $stack->push(Middleware::retry($retry->decider(), $retry->delay()));

        $guzzle = new GuzzleClient([
            'handler' => $stack,
            'base_uri' => 'https://robot-ws.your-server.de/',
        ]);

        $client = new HetznerClient('mock-user', 'mock-pass', [
            'base_url' => 'https://robot-ws.your-server.de',
            'retries' => $maxRetries,
            'retry_backoff' => $retryBackoff,
        ]);
        $client->setGuzzleClient($guzzle);

        return $client;
    }

    public function test_get_servers_success()
    {
        $responseBody = json_encode([
            [
                'server' => [
                    'server_ip' => '123.123.123.123',
                    'server_ipv6_net' => '2a01:f48:111:4221::',
                    'server_number' => 321,
                    'server_name' => 'server1',
                    'product' => 'DS 3000',
                    'dc' => 'NBG1-DC1',
                    'traffic' => '5 TB',
                    'status' => 'ready',
                    'cancelled' => false,
                    'paid_until' => '2010-09-02',
                ],
            ],
            [
                'server' => [
                    'server_ip' => '123.123.123.124',
                    'server_ipv6_net' => '2a01:f48:111:4222::',
                    'server_number' => 421,
                    'server_name' => 'server2',
                    'product' => 'X5',
                    'dc' => 'FSN1-DC10',
                    'traffic' => '2 TB',
                    'status' => 'ready',
                    'cancelled' => false,
                    'paid_until' => '2010-06-11',
                ],
            ],
        ]);

        $client = $this->createMockClient([
            new Response(
                200,
                [
                    'RateLimit-Limit' => '500',
                    'RateLimit-Remaining' => '499',
                    'RateLimit-Reset' => '1718115600',
                ],
                $responseBody
            ),
        ]);

        $manager = new HetznerManager($client);

        $servers = $manager->servers()->all();

        $this->assertInstanceOf(ServerCollection::class, $servers);
        $this->assertCount(2, $servers);
        $this->assertEquals('server1', $servers->first()->serverName);

        $limits = $manager->rateLimit();
        $this->assertEquals(500, $limits['limit']);
        $this->assertEquals(499, $limits['remaining']);
        $this->assertEquals(1718115600, $limits['reset']);
    }

    public function test_auth_exception_mapping()
    {
        $client = $this->createMockClient([
            new Response(401, [], json_encode([
                'error' => [
                    'status' => 401,
                    'code' => 'unauthorized',
                    'message' => 'Invalid credentials',
                ],
            ])),
        ]);

        $manager = new HetznerManager($client);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $manager->servers()->all();
    }

    public function test_validation_exception_mapping()
    {
        $client = $this->createMockClient([
            new Response(400, [], json_encode([
                'error' => [
                    'status' => 400,
                    'code' => 'INVALID_INPUT',
                    'message' => 'invalid input',
                    'missing' => ['server_name'],
                    'invalid' => [],
                ],
            ])),
        ]);

        $manager = new HetznerManager($client);

        try {
            $manager->servers()->update(321, []);
            $this->fail('Expected ValidationException was not thrown');
        } catch (ValidationException $e) {
            $this->assertEquals('invalid input', $e->getMessage());
            $this->assertEquals('INVALID_INPUT', $e->getErrorCode());
            $this->assertEquals(['server_name'], $e->getMissingFields());
            $this->assertEquals([], $e->getInvalidFields());
        }
    }

    public function test_network_exception_mapping()
    {
        $client = $this->createMockClient([
            new ConnectException('Connection timed out', new Request('GET', 'server')),
        ], 0); // No retries

        $manager = new HetznerManager($client);

        $this->expectException(NetworkException::class);
        $this->expectExceptionMessage('Connection timed out');

        $manager->servers()->all();
    }

    public function test_rate_limit_exception_mapping_and_retries()
    {
        $responseBody = json_encode([
            [
                'server' => [
                    'server_ip' => '123.123.123.123',
                    'server_number' => 321,
                    'server_name' => 'server1',
                ],
            ],
        ]);

        // First call: 403 Forbidden with RATE_LIMIT_EXCEEDED code
        // Second call: 200 OK
        $client = $this->createMockClient([
            new Response(403, [], json_encode([
                'error' => [
                    'status' => 403,
                    'code' => 'RATE_LIMIT_EXCEEDED',
                    'message' => 'Rate limit exceeded',
                    'max_request' => 200,
                    'interval' => 1, // 1 second
                ],
            ])),
            new Response(200, [], $responseBody),
        ], 3, 0);

        $manager = new HetznerManager($client);

        // Should retry once and succeed
        $servers = $manager->servers()->all();

        $this->assertCount(1, $servers);
        $this->assertEquals('server1', $servers->first()->serverName);
    }

    public function test_async_requests()
    {
        $responseBody = json_encode([
            [
                'server' => [
                    'server_ip' => '123.123.123.123',
                    'server_number' => 321,
                    'server_name' => 'async-server',
                ],
            ],
        ]);

        $client = $this->createMockClient([
            new Response(200, [], $responseBody),
        ]);

        $manager = new HetznerManager($client);

        $promise = $manager->servers()->async()->all();

        $this->assertInstanceOf(PromiseInterface::class, $promise);

        // Wait for resolution
        $servers = $promise->wait();

        $this->assertInstanceOf(ServerCollection::class, $servers);
        $this->assertEquals('async-server', $servers->first()->serverName);
    }

    public function test_batch_operations()
    {
        $responseBody1 = json_encode(['server' => ['server_number' => 1, 'server_name' => 'server-1']]);
        $responseBody2 = json_encode(['server' => ['server_number' => 2, 'server_name' => 'server-2']]);

        $client = $this->createMockClient([
            new Response(200, [], $responseBody1),
            new Response(200, [], $responseBody2),
        ]);

        $manager = new HetznerManager($client);

        $results = $manager->batch([
            fn () => $manager->servers()->find(1),
            fn () => $manager->servers()->find(2),
        ]);

        $this->assertCount(2, $results);
        $this->assertInstanceOf(Server::class, $results[0]);
        $this->assertInstanceOf(Server::class, $results[1]);
        $this->assertEquals('server-1', $results[0]->serverName);
        $this->assertEquals('server-2', $results[1]->serverName);
    }
}
