<?php

namespace mkevenaar\NetBox\Tests;

use mkevenaar\NetBox\Api\DCIM\Devices;
use mkevenaar\NetBox\Api\IPAM\Prefixes;
use mkevenaar\NetBox\Api\Core\BackgroundQueues;
use mkevenaar\NetBox\Tests\Support\RecordingHttpClient;
use mkevenaar\NetBox\Tests\Support\TestClient;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionMethod;

class ApiWrappersTest extends TestCase
{
    private const SAMPLE_ID = 123;
    private const SAMPLE_NAME = 'default';
    private const REQUEST_PARAMS = ['filter' => 'value'];

    /**
     * @dataProvider wrapperMethodProvider
     */
    public function testApiWrapperMethodsDelegateToHttpClient(
        string $className,
        string $methodName,
        string $expectedHttpMethod,
        string $expectedPath
    ): void {
        $recordingHttpClient = new RecordingHttpClient();
        $api = new $className(new TestClient($recordingHttpClient));

        $result = $api->{$methodName}(...$this->argumentsForMethod($className, $methodName));

        self::assertCount(1, $recordingHttpClient->calls);
        self::assertSame($expectedHttpMethod, $recordingHttpClient->calls[0]['method']);
        self::assertSame($expectedPath, $recordingHttpClient->calls[0]['path']);
        self::assertSame(self::REQUEST_PARAMS, $recordingHttpClient->calls[0]['params']);

        if ($expectedHttpMethod === 'delete') {
            self::assertTrue($result);
        } else {
            self::assertSame($recordingHttpClient->calls[0], $result);
        }
    }

    /**
     * @return array<string, array{string, string, string, string}>
     */
    public static function wrapperMethodProvider(): array
    {
        $cases = [];
        $apiDirectory = dirname(__DIR__) . '/src/Api';
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($apiDirectory, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            if (in_array($file->getBasename(), ['AbstractApi.php', 'ApiInterface.php'], true)) {
                continue;
            }

            $source = file_get_contents($file->getPathname());
            if ($source === false) {
                continue;
            }

            if (!preg_match('/namespace\s+([^;]+);/', $source, $namespaceMatch)) {
                continue;
            }

            if (!preg_match('/class\s+(\w+)\s+extends\s+AbstractApi/', $source, $classMatch)) {
                continue;
            }

            $className = $namespaceMatch[1] . '\\' . $classMatch[1];
            preg_match_all(
                '/public function\s+(\w+)\s*\([^)]*\)\s*(?::\s*[\w?\\\\|]+)?\s*\{\s*return\s+\$this->(get|post|put|patch|delete)\((.*?),\s*\$params\);\s*\}/s',
                $source,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $match) {
                $methodName = $match[1];
                $httpMethod = $match[2];
                $expectedPath = self::evaluatePathExpression($match[3]);
                $caseName = $className . '::' . $methodName;

                $cases[$caseName] = [$className, $methodName, $httpMethod, $expectedPath];
            }
        }

        ksort($cases);

        return $cases;
    }

    public function testKnownActionEndpointsUseExpectedPaths(): void
    {
        $recordingHttpClient = new RecordingHttpClient();
        $client = new TestClient($recordingHttpClient);

        (new Devices($client))->renderConfig(self::SAMPLE_ID, self::REQUEST_PARAMS);
        (new BackgroundQueues($client))->show(self::SAMPLE_NAME, self::REQUEST_PARAMS);

        self::assertSame(
            [
                [
                    'method' => 'post',
                    'path' => '/dcim/devices/123/render-config/',
                    'params' => self::REQUEST_PARAMS,
                ],
                [
                    'method' => 'get',
                    'path' => '/core/background-queues/default/',
                    'params' => self::REQUEST_PARAMS,
                ],
            ],
            $recordingHttpClient->calls
        );
    }

    public function testPrefixesAvailableAliasesUseAvailablePrefixesEndpoint(): void
    {
        $recordingHttpClient = new RecordingHttpClient();
        $prefixes = new Prefixes(new TestClient($recordingHttpClient));

        $prefixes->showAvailable(self::SAMPLE_ID, self::REQUEST_PARAMS);
        $prefixes->addAvailable(self::SAMPLE_ID, self::REQUEST_PARAMS);

        self::assertSame(
            [
                [
                    'method' => 'get',
                    'path' => '/ipam/prefixes/123/available-prefixes/',
                    'params' => self::REQUEST_PARAMS,
                ],
                [
                    'method' => 'post',
                    'path' => '/ipam/prefixes/123/available-prefixes/',
                    'params' => self::REQUEST_PARAMS,
                ],
            ],
            $recordingHttpClient->calls
        );
    }

    private function argumentsForMethod(string $className, string $methodName): array
    {
        $arguments = [];
        $method = new ReflectionMethod($className, $methodName);

        foreach ($method->getParameters() as $parameter) {
            if ($parameter->getName() === 'params') {
                $arguments[] = self::REQUEST_PARAMS;
                continue;
            }

            $type = $parameter->getType();
            if ($type !== null && (string) $type === 'int') {
                $arguments[] = self::SAMPLE_ID;
                continue;
            }

            $arguments[] = self::SAMPLE_NAME;
        }

        return $arguments;
    }

    private static function evaluatePathExpression(string $expression): string
    {
        preg_match_all('/"([^"]*)"|\$(id|name)/', $expression, $matches, PREG_SET_ORDER);

        $path = '';
        foreach ($matches as $match) {
            if ($match[1] !== '') {
                $path .= stripcslashes($match[1]);
                continue;
            }

            $path .= $match[2] === 'id' ? (string) self::SAMPLE_ID : self::SAMPLE_NAME;
        }

        return $path;
    }
}
