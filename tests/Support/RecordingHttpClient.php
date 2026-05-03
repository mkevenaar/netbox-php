<?php

namespace mkevenaar\NetBox\Tests\Support;

use mkevenaar\NetBox\HttpClient\HttpClient;

class RecordingHttpClient extends HttpClient
{
    /** @var array<int, array{method: string, path: string, params: array}> */
    public $calls = [];

    /**
     * @return array{method: string, path: string, params: array}
     */
    private function record(string $method, string $path, array $params): array
    {
        $call = [
            'method' => $method,
            'path' => $path,
            'params' => $params,
        ];

        $this->calls[] = $call;

        return $call;
    }

    public function get(string $path = "", array $query = []): array
    {
        return $this->record('get', $path, $query);
    }

    public function post(string $path = "", array $body = []): array
    {
        return $this->record('post', $path, $body);
    }

    public function put(string $path = "", array $body = []): array
    {
        return $this->record('put', $path, $body);
    }

    public function patch(string $path = "", array $body = []): array
    {
        return $this->record('patch', $path, $body);
    }

    public function delete(string $path = "", array $body = []): ?bool
    {
        $this->record('delete', $path, $body);

        return true;
    }
}
