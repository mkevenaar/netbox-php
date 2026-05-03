<?php

namespace mkevenaar\NetBox\Api\Secrets;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

/**
 * @deprecated NetBox 4.5 no longer provides the /secrets/get-session-key/ endpoint.
 */
class Session extends AbstractApi
{
    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function list(array $params = []): array
    {
        return $this->post("/secrets/get-session-key/", $params);
    }
}
