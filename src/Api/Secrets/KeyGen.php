<?php

namespace mkevenaar\NetBox\Api\Secrets;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

/**
 * @deprecated NetBox 4.5 no longer provides the /secrets/generate-rsa-key-pair/ endpoint.
 */
class KeyGen extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/secrets/generate-rsa-key-pair/", $params);
    }
}
