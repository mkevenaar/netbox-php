<?php

namespace mkevenaar\NetBox\Api\IPAM;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class IpRanges extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/ipam/ip-ranges/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function add(array $params = []): array
    {
        return $this->post("/ipam/ip-ranges/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function bulkEdit(array $params = []): array
    {
        return $this->put("/ipam/ip-ranges/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function bulkUpdate(array $params = []): array
    {
        return $this->patch("/ipam/ip-ranges/", $params);
    }

    /**
     * @param array $params
     * @return bool
     * @throws GuzzleException
     */
    public function bulkRemove(array $params = []): bool
    {
        return $this->delete("/ipam/ip-ranges/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/ipam/ip-ranges/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function edit(int $id, array $params = []): array
    {
        return $this->put("/ipam/ip-ranges/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function update(int $id, array $params = []): array
    {
        return $this->patch("/ipam/ip-ranges/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return bool
     * @throws GuzzleException
     */
    public function remove(int $id, array $params = []): bool
    {
        return $this->delete("/ipam/ip-ranges/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function showAvailableIps(int $id, array $params = [])
    {
        return $this->get("/ipam/ip-ranges/" . $id . "/available-ips/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function addAvailableIps(int $id, array $params = []): array
    {
        return $this->post("/ipam/ip-ranges/" . $id . "/available-ips/", $params);
    }
}
