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
        'circuitTerminations' => 'Circuits\CircuitTerminations',
        'circuitTypes' => 'Circuits\CircuitTypes',
        'circuits' => 'Circuits\Circuits',
        'providers' => 'Circuits\Providers',

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
        'moduleBays' => 'DCIM\ModuleBays',
        'modules' => 'DCIM\Modules',
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
        'contactAssignments' => 'Tenancy\ContactAssignments',
        'contactGroups' => 'Tenancy\ContactGroups',
        'contactRoles' => 'Tenancy\ContactRoles',
        'contacts' => 'Tenancy\Contacts',
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

    private $netbox_api = null;
    private $netbox_token = null;

    public function __construct($netbox_api = null, $netbox_token = null)
    {
        $this->netbox_api = $netbox_api;
        $this->netbox_token = $netbox_token;
        if($this->netbox_api === null && strlen(getenv('NETBOX_API')) !== 0) {
            $this->netbox_api = getenv('NETBOX_API');
        }
        if($this->netbox_token === null && strlen(getenv('NETBOX_API_KEY')) !== 0) {
            $this->netbox_token = getenv('NETBOX_API_KEY');
        }
        if ($this->netbox_api === null || $this->netbox_token === null) {
            throw new RuntimeException(
                sprintf(
                    'Client not properly configured (NETBOX_API, NETBOX_API_KEY): "%s" "redacted(%s(%s))". 
                    Please configure in constructor or environment variables',
                    $this->netbox_api,
                    gettype($this->netbox_token),
                    strlen($this->netbox_token)
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
        $this->httpClient->setBaseUri($this->netbox_api);
        $this->httpClient->setAuthToken($this->netbox_token);
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
