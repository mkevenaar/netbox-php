<?php

namespace mkevenaar\NetBox\Tests;

use mkevenaar\NetBox\Api\DCIM\ConsoleConnections;
use mkevenaar\NetBox\Api\DCIM\InterfaceConnections;
use mkevenaar\NetBox\Api\DCIM\RackGroups;
use mkevenaar\NetBox\Api\Extras\ContentTypes;
use mkevenaar\NetBox\Api\Extras\JobResults;
use mkevenaar\NetBox\Api\Extras\ObjectChanges;
use mkevenaar\NetBox\Api\Extras\Reports;
use mkevenaar\NetBox\Api\Secrets\KeyGen;
use mkevenaar\NetBox\Api\Secrets\SecretRoles;
use mkevenaar\NetBox\Api\Secrets\Secrets;
use mkevenaar\NetBox\Api\Secrets\Session;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class DeprecatedEndpointsTest extends TestCase
{
    /**
     * @dataProvider deprecatedClassProvider
     */
    public function testRemovedNetBoxEndpointsAreMarkedDeprecated(string $className, string $endpoint): void
    {
        $docComment = (new ReflectionClass($className))->getDocComment();

        self::assertIsString($docComment);
        self::assertStringContainsString('@deprecated', $docComment);
        self::assertStringContainsString($endpoint, $docComment);
    }

    /**
     * @return array<string, array{class-string, string}>
     */
    public static function deprecatedClassProvider(): array
    {
        return [
            'console connections' => [ConsoleConnections::class, '/dcim/console-connections/'],
            'interface connections' => [InterfaceConnections::class, '/dcim/interface-connections/'],
            'rack groups' => [RackGroups::class, '/dcim/rack-groups/'],
            'content types' => [ContentTypes::class, '/core/object-types/'],
            'job results' => [JobResults::class, '/core/jobs/'],
            'object changes' => [ObjectChanges::class, '/core/object-changes/'],
            'reports' => [Reports::class, '/extras/reports/'],
            'key gen' => [KeyGen::class, '/secrets/generate-rsa-key-pair/'],
            'secret roles' => [SecretRoles::class, '/secrets/secret-roles/'],
            'secrets' => [Secrets::class, '/secrets/secrets/'],
            'session' => [Session::class, '/secrets/get-session-key/'],
        ];
    }
}
