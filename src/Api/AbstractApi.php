<?php

namespace mkevenaar\NetBox\Api;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Client;

abstract class AbstractApi implements ApiInterface
{
    /** @var Client */
    public $client;

    /**
     * AbstractApi constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $path
     * @param array $parameters
     * @return mixed
     * @throws GuzzleException
     */
    protected function get($path, array $parameters)
    {
        return $this->client->getHttpClient()->get($path, $parameters);
    }

    /**
     * @param $path
     * @param array $parameters
     * @return array
     * @throws GuzzleException
     */
    protected function post($path, array $parameters): array
    {
        return $this->client->getHttpClient()->post($path, $parameters);
    }

    /**
     * @param $path
     * @param array $parameters
     * @return array
     * @throws GuzzleException
     */
    protected function put($path, array $parameters): array
    {
        return $this->client->getHttpClient()->put($path, $parameters);
    }

    /**
     * @param $path
     * @param array $parameters
     * @return array
     * @throws GuzzleException
     */
    protected function patch($path, array $parameters): array
    {
        return $this->client->getHttpClient()->patch($path, $parameters);
    }

    /**
     * @param $path
     * @param array $parameters
     * @return bool
     * @throws GuzzleException
     */
    protected function delete($path, array $parameters): bool
    {
        return $this->client->getHttpClient()->delete($path, $parameters);
    }
}
