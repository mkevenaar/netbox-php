<?php

namespace mkevenaar\NetBox\HttpClient;

interface HttpClientInterface
{
    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param string $path
     * @param array $query
     * @return array
     */
    public function get(string $path = "", array $query = []): array;

    /**
     * @param string $path
     * @param array $body
     * @return array
     */
    public function post(string $path = "", array $body = []): array;

    /**
     * @param string $path
     * @param array $body
     * @return array
     */
    public function put(string $path = "", array $body = []): array;

    /**
     * @param string $path
     * @param array $body
     * @return bool
     */
    public function delete(string $path = "", array $body = []): ?bool;

    /**
     * @param array $options
     */
    public function setOptions(array $options);
}
