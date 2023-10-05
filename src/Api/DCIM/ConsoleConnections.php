<?php

namespace mkevenaar\NetBox\Api\DCIM;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class ConsoleConnections extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/dcim/console-connections/", $params);
    }
}
