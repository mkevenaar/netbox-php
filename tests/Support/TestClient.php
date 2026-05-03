<?php

namespace mkevenaar\NetBox\Tests\Support;

use mkevenaar\NetBox\Client;
use mkevenaar\NetBox\HttpClient\HttpClient;

class TestClient extends Client
{
    /** @var RecordingHttpClient */
    private $recordingHttpClient;

    public function __construct(RecordingHttpClient $recordingHttpClient)
    {
        $this->recordingHttpClient = $recordingHttpClient;

        parent::__construct('https://netbox.example/api', 'test-token');
    }

    public function getHttpClient(): HttpClient
    {
        return $this->recordingHttpClient;
    }
}
