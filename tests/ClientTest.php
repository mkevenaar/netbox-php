<?php

namespace mkevenaar\NetBox\Tests;

use BadMethodCallException;
use InvalidArgumentException;
use mkevenaar\NetBox\Api\ApiInterface;
use mkevenaar\NetBox\Api\DCIM\Devices;
use mkevenaar\NetBox\Api\Status;
use mkevenaar\NetBox\Client;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RuntimeException;

class ClientTest extends TestCase
{
    /** @var string|false */
    private $previousNetboxApi;

    /** @var string|false */
    private $previousNetboxApiKey;

    protected function setUp(): void
    {
        $this->previousNetboxApi = getenv('NETBOX_API');
        $this->previousNetboxApiKey = getenv('NETBOX_API_KEY');

        putenv('NETBOX_API=');
        putenv('NETBOX_API_KEY=');
    }

    protected function tearDown(): void
    {
        $this->restoreEnvironmentVariable('NETBOX_API', $this->previousNetboxApi);
        $this->restoreEnvironmentVariable('NETBOX_API_KEY', $this->previousNetboxApiKey);
    }

    /**
     * @param string|false $value
     */
    private function restoreEnvironmentVariable(string $name, $value): void
    {
        if ($value === false) {
            putenv($name);

            return;
        }

        putenv($name . '=' . $value);
    }

    public function testConstructorCredentialsConfigureHttpClient(): void
    {
        $client = new Client('https://example.invalid/api', 'example-token');
        $guzzleClient = $client->getHttpClient()->getClient();
        $config = $guzzleClient->getConfig();

        self::assertSame('https://example.invalid/api', (string) $config['base_uri']);
        self::assertSame('Token example-token', $config['headers']['Authorization']);
    }

    public function testEnvironmentCredentialsConfigureHttpClient(): void
    {
        putenv('NETBOX_API=https://env.example.invalid/api');
        putenv('NETBOX_API_KEY=env-token');

        $client = new Client();
        $config = $client->getHttpClient()->getClient()->getConfig();

        self::assertSame('https://env.example.invalid/api', (string) $config['base_uri']);
        self::assertSame('Token env-token', $config['headers']['Authorization']);
    }

    public function testConstructorRequiresConfiguration(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(1653901216);

        new Client();
    }

    public function testApiReturnsEndpointWrapper(): void
    {
        $client = new Client('https://example.invalid/api', 'example-token');

        self::assertInstanceOf(Devices::class, $client->api('devices'));
        self::assertInstanceOf(Status::class, $client->api('status'));
        self::assertInstanceOf(Devices::class, $client->devices());
    }

    public function testUnknownApiThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Undefined method called: "missingEndpoint"');

        (new Client('https://example.invalid/api', 'example-token'))->api('missingEndpoint');
    }

    public function testUnknownMagicMethodThrowsBadMethodCallException(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Undefined method called: "missingEndpoint"');

        (new Client('https://example.invalid/api', 'example-token'))->missingEndpoint();
    }

    public function testOptionsCanBeSetAndRead(): void
    {
        $client = new Client('https://example.invalid/api', 'example-token');
        $options = ['timeout' => 30];

        $client->setOptions($options);

        self::assertSame($options, $client->getOptions());
        self::assertSame($options, $client->getHttpClient()->getOptions());
    }

    public function testAllRegisteredApiEntriesResolve(): void
    {
        $client = new Client('https://example.invalid/api', 'example-token');
        $clientClass = new ReflectionClass($client);
        $classes = $clientClass->getProperty('classes');
        $classes->setAccessible(true);

        foreach ($classes->getValue($client) as $key => $class) {
            self::assertInstanceOf(
                ApiInterface::class,
                $client->api($key),
                sprintf('Client entry "%s" should resolve to %s', $key, $class)
            );
        }
    }
}
