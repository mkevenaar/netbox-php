<?php

namespace mkevenaar\NetBox\Api\DCIM;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

/**
 * @deprecated NetBox 4.5 no longer provides the /dcim/console-connections/ endpoint.
 */
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
