<?php

namespace mkevenaar\NetBox\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class HttpClient implements HttpClientInterface
{
    /** @var Client */
    protected $client;

    /** @var array */
    protected $options = [];
    /**
     * @var string
     */
    private $baseUri;
    /**
     * @var string
     */
    private $authToken;

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if (!isset($this->client)) {
            $this->client = new Client([
                'base_uri' => $this->baseUri,
                RequestOptions::TIMEOUT => 180,
                RequestOptions::COOKIES => true,
                RequestOptions::CONNECT_TIMEOUT => 180,
                RequestOptions::ALLOW_REDIRECTS => false,
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => sprintf("Token %s", $this->authToken),
                ]
            ]);

            return $this->client;
        }

        return $this->client;
    }

    /**
     * @param Client $client
     * @return Client
     */
    public function setClient(Client $client): Client
    {
        $this->client = $client;

        return $this->client;
    }

    /**
     * @param string $path
     * @param array $query
     * @return mixed
     * @throws GuzzleException
     */
    public function get(string $path = "", array $query = []): array
    {
        $response = $this->getClient()->request(
            'GET',
            $this->baseUri . $path,
            [
                'query' => $query
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $path
     * @param array $body
     * @return array
     * @throws GuzzleException
     */
    public function post(string $path = "", array $body = []): array
    {
        $response = $this->getClient()->request(
            'POST',
            $this->baseUri . $path,
            [
                'json' => $body
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $path
     * @param array $body
     * @return array
     * @throws GuzzleException
     */
    public function put(string $path = "", array $body = []): array
    {
        $response = $this->getClient()->request(
            'PUT',
            $this->baseUri . $path,
            [
                'json' => $body
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $path
     * @param array $body
     * @return array
     * @throws GuzzleException
     */
    public function patch(string $path = "", array $body = []): array
    {
        $response = $this->getClient()->request(
            'PATCH',
            $this->baseUri . $path,
            [
                'json' => $body
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $path
     * @param array $body
     * @return bool
     * @throws GuzzleException
     */
    public function delete(string $path = "", array $body = []): ?bool
    {
        $response = $this->getClient()->request(
            'DELETE',
            $this->baseUri . $path,
            [
                'json' => $body
            ]
        );

        return $response->getStatusCode() === 204;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    public function setBaseUri(string $uri)
    {
        $this->baseUri = $uri;
    }

    public function setAuthToken(string $token)
    {
        $this->authToken = $token;
    }
}
