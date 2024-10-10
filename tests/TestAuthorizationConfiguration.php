<?php
require_once __DIR__ . '/../vendor/autoload.php';
use mkevenaar\NetBox\Client;

const TESTURL = "https://example.invalid";
const TESTKEY = "example_api_key";
function compareGuzzleConfig($config, $testid)
{
    $uri = $config['base_uri'];
    if(TESTURL != $uri) {
        throw new \Exception("FAIL $testid: uri $uri did not match expected ".TESTURL);
    }
    $expectedAuth = 'Token '.TESTKEY;
    $actualAuth = $config['headers']['Authorization'];
    if($expectedAuth !== $actualAuth) {
        throw new \Exception("FAIL $testid: Authorization Header $actualAuth did not match expected Authorization Header $expectedAuth");
    }
}

function testSettingAuthWithEnvironmentVariables()
{
    putenv('NETBOX_API='.TESTURL);
    putenv('NETBOX_API_KEY='.TESTKEY);
    $guzzleClient = (new Client())->getHttpClient()->getClient();
    $config = $guzzleClient->getConfig();
    compareGuzzleConfig($config, 'ENV-TEST');
    echo "ENV-TEST: OK\n";
    putenv('NETBOX_API=');
    putenv('NETBOX_API_KEY=');

}

function testSettingAuthWithConstructor()
{
    $guzzleClient = (new Client(TESTURL, TESTKEY))->getHttpClient()->getClient();
    $config = $guzzleClient->getConfig();
    compareGuzzleConfig($config, 'CONSTRUCTOR-TEST');
    echo "CONSTRUCTOR-TEST: OK\n";
}

### Run Tests

testSettingAuthWithConstructor();
testSettingAuthWithEnvironmentVariables();
