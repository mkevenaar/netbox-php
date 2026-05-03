<?php

namespace mkevenaar\NetBox\Api\Plugins\NetboxTopologyViews;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class Images extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/plugins/netbox_topology_views/images/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/plugins/netbox_topology_views/images/" . $id . "/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function save(array $params = []): array
    {
        return $this->post("/plugins/netbox_topology_views/images/save/", $params);
    }
}
