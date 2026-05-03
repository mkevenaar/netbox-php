<?php

namespace mkevenaar\NetBox\Api\Extras;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class NotificationGroups extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/extras/notification-groups/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function add(array $params = []): array
    {
        return $this->post("/extras/notification-groups/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function bulkEdit(array $params = []): array
    {
        return $this->put("/extras/notification-groups/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function bulkUpdate(array $params = []): array
    {
        return $this->patch("/extras/notification-groups/", $params);
    }

    /**
     * @param array $params
     * @return bool
     * @throws GuzzleException
     */
    public function bulkRemove(array $params = []): bool
    {
        return $this->delete("/extras/notification-groups/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/extras/notification-groups/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function edit(int $id, array $params = []): array
    {
        return $this->put("/extras/notification-groups/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function update(int $id, array $params = []): array
    {
        return $this->patch("/extras/notification-groups/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return bool
     * @throws GuzzleException
     */
    public function remove(int $id, array $params = []): bool
    {
        return $this->delete("/extras/notification-groups/" . $id . "/", $params);
    }
}
