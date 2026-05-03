<?php

namespace mkevenaar\NetBox\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use mkevenaar\NetBox\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    public function testGetClientBuildsDefaultGuzzleConfiguration(): void
    {
        $httpClient = new HttpClient();
        $httpClient->setBaseUri('https://netbox.example/api');
        $httpClient->setAuthToken('secret-token');

        $guzzleClient = $httpClient->getClient();
        $config = $guzzleClient->getConfig();

        self::assertSame($guzzleClient, $httpClient->getClient());
        self::assertSame('https://netbox.example/api', (string) $config['base_uri']);
        self::assertSame('application/json', $config['headers']['Accept']);
        self::assertSame('application/json', $config['headers']['Content-Type']);
        self::assertSame('Token secret-token', $config['headers']['Authorization']);
    }

    public function testSetClientReturnsAndReusesClient(): void
    {
        $httpClient = new HttpClient();
        $guzzleClient = new GuzzleClient();

        self::assertSame($guzzleClient, $httpClient->setClient($guzzleClient));
        self::assertSame($guzzleClient, $httpClient->getClient());
    }

    public function testSetOptionsMergesOptions(): void
    {
        $httpClient = new HttpClient();

        $httpClient->setOptions(['timeout' => 10, 'headers' => ['A' => 'B']]);
        $httpClient->setOptions(['connect_timeout' => 5]);

        self::assertSame(
            ['timeout' => 10, 'headers' => ['A' => 'B'], 'connect_timeout' => 5],
            $httpClient->getOptions()
        );
    }

    public function testGetSendsQueryAndDecodesJson(): void
    {
        $history = [];
        $httpClient = $this->httpClientWithResponses([
            new Response(200, [], '{"result":"ok"}'),
        ], $history);

        $result = $httpClient->get('/dcim/devices/', ['limit' => 10]);

        self::assertSame(['result' => 'ok'], $result);
        self::assertCount(1, $history);
        self::assertSame('GET', $history[0]['request']->getMethod());
        self::assertSame('https://netbox.example/api/dcim/devices/?limit=10', (string) $history[0]['request']->getUri());
    }

    /**
     * @dataProvider jsonBodyRequestProvider
     */
    public function testJsonBodyRequestsSendJsonAndDecodeJson(string $clientMethod, string $httpMethod): void
    {
        $history = [];
        $httpClient = $this->httpClientWithResponses([
            new Response(200, [], '{"id":123}'),
        ], $history);

        $result = $httpClient->{$clientMethod}('/dcim/devices/', ['name' => 'edge-01']);

        self::assertSame(['id' => 123], $result);
        self::assertCount(1, $history);
        self::assertSame($httpMethod, $history[0]['request']->getMethod());
        self::assertSame('https://netbox.example/api/dcim/devices/', (string) $history[0]['request']->getUri());
        self::assertSame('{"name":"edge-01"}', (string) $history[0]['request']->getBody());
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function jsonBodyRequestProvider(): array
    {
        return [
            'post' => ['post', 'POST'],
            'put' => ['put', 'PUT'],
            'patch' => ['patch', 'PATCH'],
        ];
    }

    public function testDeleteReturnsTrueOnlyForNoContent(): void
    {
        $history = [];
        $httpClient = $this->httpClientWithResponses([
            new Response(204),
            new Response(200),
        ], $history);

        self::assertTrue($httpClient->delete('/dcim/devices/123/', ['id' => 123]));
        self::assertFalse($httpClient->delete('/dcim/devices/124/', ['id' => 124]));
        self::assertCount(2, $history);
        self::assertSame('DELETE', $history[0]['request']->getMethod());
        self::assertSame('{"id":123}', (string) $history[0]['request']->getBody());
    }

    /**
     * @param Response[] $responses
     * @param array<int, array<string, mixed>> $history
     */
    private function httpClientWithResponses(array $responses, array &$history): HttpClient
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($history));

        $httpClient = new HttpClient();
        $httpClient->setBaseUri('https://netbox.example/api');
        $httpClient->setAuthToken('secret-token');
        $httpClient->setClient(new GuzzleClient(['handler' => $stack]));

        return $httpClient;
    }
}
