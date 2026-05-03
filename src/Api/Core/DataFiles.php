<?php

namespace mkevenaar\NetBox\Api\Core;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class DataFiles extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/core/data-files/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/core/data-files/" . $id . "/", $params);
    }
}
