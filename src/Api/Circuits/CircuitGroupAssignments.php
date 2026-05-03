<?php

namespace mkevenaar\NetBox\Api\Circuits;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class CircuitGroupAssignments extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/circuits/circuit-group-assignments/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function add(array $params = []): array
    {
        return $this->post("/circuits/circuit-group-assignments/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function bulkEdit(array $params = []): array
    {
        return $this->put("/circuits/circuit-group-assignments/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function bulkUpdate(array $params = []): array
    {
        return $this->patch("/circuits/circuit-group-assignments/", $params);
    }

    /**
     * @param array $params
     * @return bool
     * @throws GuzzleException
     */
    public function bulkRemove(array $params = []): bool
    {
        return $this->delete("/circuits/circuit-group-assignments/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/circuits/circuit-group-assignments/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function edit(int $id, array $params = []): array
    {
        return $this->put("/circuits/circuit-group-assignments/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function update(int $id, array $params = []): array
    {
        return $this->patch("/circuits/circuit-group-assignments/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return bool
     * @throws GuzzleException
     */
    public function remove(int $id, array $params = []): bool
    {
        return $this->delete("/circuits/circuit-group-assignments/" . $id . "/", $params);
    }
}
