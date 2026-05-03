<?php

namespace mkevenaar\NetBox\Api;

use GuzzleHttp\Exception\GuzzleException;

class AuthenticationCheck extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(array $params = [])
    {
        return $this->get("/authentication-check/", $params);
    }
}
