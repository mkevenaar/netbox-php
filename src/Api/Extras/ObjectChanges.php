<?php

namespace mkevenaar\NetBox\Api\Extras;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

/**
 * @deprecated NetBox 4.5 moved object changes to /core/object-changes/.
 */
class ObjectChanges extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/extras/object-changes/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/extras/object-changes/" . $id . "/", $params);
    }
}
