<?php

namespace mkevenaar\NetBox\Api\DCIM;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

/**
 * @deprecated NetBox 4.5 no longer provides the /dcim/interface-connections/ endpoint.
 */
class InterfaceConnections extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/dcim/interface-connections/", $params);
    }
}
