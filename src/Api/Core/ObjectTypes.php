<?php

namespace mkevenaar\NetBox\Api\Core;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class ObjectTypes extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/core/object-types/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/core/object-types/" . $id . "/", $params);
    }
}
