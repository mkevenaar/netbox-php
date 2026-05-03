<?php

namespace mkevenaar\NetBox\Api\Core;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class BackgroundTasks extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/core/background-tasks/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/core/background-tasks/" . $id . "/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function deleteTask(int $id, array $params = []): array
    {
        return $this->post("/core/background-tasks/" . $id . "/delete/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function enqueue(int $id, array $params = []): array
    {
        return $this->post("/core/background-tasks/" . $id . "/enqueue/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function requeue(int $id, array $params = []): array
    {
        return $this->post("/core/background-tasks/" . $id . "/requeue/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function stop(int $id, array $params = []): array
    {
        return $this->post("/core/background-tasks/" . $id . "/stop/", $params);
    }
}
