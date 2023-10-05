<?php

namespace mkevenaar\NetBox;

use BadMethodCallException;
use InvalidArgumentException;
use mkevenaar\NetBox\HttpClient\HttpClient;
use RuntimeException;

class Client
{
    /** @var array */
    protected $classes = [
        // Circuits
        'circuits' => 'Circuits\Circuits',
        'providers' => 'Circuits\Providers',
        'circuitTerminations' => 'Circuits\CircuitTerminations',
        'circuitTypes' => 'Circuits\CircuitTypes',

        // DCIM
        'cables' => 'DCIM\Cables',
        'connectedDevices' => 'DCIM\ConnectedDevices',
        'consoleConnections' => 'DCIM\ConsoleConnections',
        'consolePorts' => 'DCIM\ConsolePorts',
        'consolePortTemplates' => 'DCIM\ConsolePortTemplates',
        'consoleServerPorts' => 'DCIM\ConsoleServerPorts',
        'consoleServerPortTemplates' => 'DCIM\ConsoleServerPortTemplates',
        'deviceBays' => 'DCIM\DeviceBays',
        'deviceBayTemplates' => 'DCIM\DeviceBayTemplates',
        'deviceRoles' => 'DCIM\DeviceRoles',
        'devices' => 'DCIM\Devices',
        'deviceTypes' => 'DCIM\DeviceTypes',
        'frontPorts' => 'DCIM\FrontPorts',
        'frontPortTemplates' => 'DCIM\FrontPortTemplates',
        'interfaceConnections' => 'DCIM\InterfaceConnections',
        'interfaces' => 'DCIM\Interfaces',
        'interfaceTemplates' => 'DCIM\InterfaceTemplates',
        'inventoryItems' => 'DCIM\InventoryItems',
        'manufacturers' => 'DCIM\Manufacturers',
        'platforms' => 'DCIM\Platforms',
        'powerFeeds' => 'DCIM\PowerFeeds',
        'powerOutlets' => 'DCIM\PowerOutlets',
        'powerOutletTemplates' => 'DCIM\PowerOutletTemplates',
        'powerPanels' => 'DCIM\PowerPanels',
        'powerPorts' => 'DCIM\PowerPorts',
        'powerPortTemplates' => 'DCIM\PowerPortTemplates',
        'rackGroups' => 'DCIM\RackGroups',
        'rackReservations' => 'DCIM\RackReservations',
        'rackRoles' => 'DCIM\RackRoles',
        'racks' => 'DCIM\Racks',
        'rearPorts' => 'DCIM\RearPorts',
        'rearPortTemplates' => 'DCIM\RearPortTemplates',
        'regions' => 'DCIM\Regions',
        'sites' => 'DCIM\Sites',
        'virtualChassis' => 'DCIM\VirtualChassis',

        // Extras
        'configContexts' => 'Extras\ConfigContexts',
        'contentTypes' => 'Extras\ContentTypes',
        'customFields' => 'Extras\CustomFields',
        'exportTemplates' => 'Extras\ExportTemplates',
        'imageAttachments' => 'Extras\ImageAttachments',
        'jobResults' => 'Extras\JobResults',
        'objectChanges' => 'Extras\ObjectChanges',
        'reports' => 'Extras\Reports',
        'scripts' => 'Extras\Scripts',
        'tags' => 'Extras\Tags',

        // IPAM
        'aggregates' => 'IPAM\Aggregates',
        'ipAddresses' => 'IPAM\IpAddresses',
        'prefixes' => 'IPAM\Prefixes',
        'rirs' => 'IPAM\Rirs',
        'roles' => 'IPAM\Roles',
        'routeTargets' => 'IPAM\RouteTargets',
        'services' => 'IPAM\Services',
        'vlanGroups' => 'IPAM\VlanGroups',
        'vlans' => 'IPAM\Vlans',
        'vrfs' => 'IPAM\Vrfs',

        // Secrets
        'keyGen' => 'Secrets\KeyGen',
        'secrets' => 'Secrets\Secrets',
        'secretRoles' => 'Secrets\SecretRoles',
        'session' => 'Secrets\Session',

        // Tenancy
        'tenantGroups' => 'Tenancy\TenantGroups',
        'tenants' => 'Tenancy\Tenants',

        // Users
        'config' => 'Users\Config',
        'groups' => 'Users\Groups',
        'permissions' => 'Users\Permissions',
        'users' => 'Users\Users',

        // Virtualization
        'clusterGroups' => 'Virtualization\ClusterGroups',
        'clusters' => 'Virtualization\Clusters',
        'clusterTypes' => 'Virtualization\ClusterTypes',
        'vinterfaces' => 'Virtualization\Interfaces',
        'virtualMachines' => 'Virtualization\VirtualMachines',

        'status' => 'Status',
    ];

    /** @var HttpClient */
    protected $httpClient;

    /** @var array */
    protected $options = [];

    public function __construct()
    {
        if (strlen(getenv('NETBOX_API')) === 0 || strlen(getenv('NETBOX_API_KEY')) === 0) {
            throw new RuntimeException(
                sprintf(
                    'Environment Variables not found (NETBOX_API, NETBOX_API_KEY): "%s" "redacted(%s(%s))"',
                    getenv('NETBOX_API'),
                    gettype(getenv('NETBOX_API_KEY')),
                    strlen(getenv('NETBOX_API_KEY'))
                ),
                1653901216
            );
        }
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        try {
            return $this->api($method);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $method));
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function api($name)
    {
        if (!isset($this->classes[$name])) {
            throw new InvalidArgumentException(sprintf('Undefined method called: "%s"', $name));
        }
        $class = '\\mkevenaar\\NetBox\\Api\\' . $this->classes[$name];

        return new $class($this);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        if (!isset($this->httpClient)) {
            $this->httpClient = new HttpClient();
        }
        $this->httpClient->setOptions($this->getOptions());

        return $this->httpClient;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}
