<?php

namespace mkevenaar\NetBox\Api\Plugins\NetboxTopologyViews;

use GuzzleHttp\Exception\GuzzleException;
use mkevenaar\NetBox\Api\AbstractApi;

class XmlExport extends AbstractApi
{
    /**
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function list(array $params = [])
    {
        return $this->get("/plugins/netbox_topology_views/xml-export/", $params);
    }
}
