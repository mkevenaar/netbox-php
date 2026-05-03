<?php

namespace mkevenaar\NetBox\Api\Core;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class BackgroundWorkers extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/core/background-workers/", $params);
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(string $name, array $params = [])
    {
        return $this->get("/core/background-workers/" . $name . "/", $params);
    }
}
