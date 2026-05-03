<?php

namespace mkevenaar\NetBox\Api\Plugins\NetboxTopologyViews;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class SaveCoords extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/plugins/netbox_topology_views/save-coords/", $params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function show(int $id, array $params = [])
    {
        return $this->get("/plugins/netbox_topology_views/save-coords/" . $id . "/", $params);
    }

    /**
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function saveCoords(array $params = []): array
    {
        return $this->patch("/plugins/netbox_topology_views/save-coords/save_coords/", $params);
    }
}
