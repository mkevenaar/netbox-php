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
        // Root
        'authenticationCheck' => 'AuthenticationCheck',
        'schema' => 'Schema',
        'status' => 'Status',

        // Circuits
        'circuitGroupAssignments' => 'Circuits\CircuitGroupAssignments',
        'circuitGroups' => 'Circuits\CircuitGroups',
        'circuitTerminations' => 'Circuits\CircuitTerminations',
        'circuitTypes' => 'Circuits\CircuitTypes',
        'circuits' => 'Circuits\Circuits',
        'providerAccounts' => 'Circuits\ProviderAccounts',
        'providerNetworks' => 'Circuits\ProviderNetworks',
        'providers' => 'Circuits\Providers',
        'virtualCircuitTerminations' => 'Circuits\VirtualCircuitTerminations',
        'virtualCircuitTypes' => 'Circuits\VirtualCircuitTypes',
        'virtualCircuits' => 'Circuits\VirtualCircuits',

        // Core
        'backgroundQueues' => 'Core\BackgroundQueues',
        'backgroundTasks' => 'Core\BackgroundTasks',
        'backgroundWorkers' => 'Core\BackgroundWorkers',
        'contentTypes' => 'Core\ObjectTypes',
        'coreObjectChanges' => 'Core\ObjectChanges',
        'dataFiles' => 'Core\DataFiles',
        'dataSources' => 'Core\DataSources',
        'jobResults' => 'Core\Jobs',
        'jobs' => 'Core\Jobs',
        'objectChanges' => 'Core\ObjectChanges',
        'objectTypes' => 'Core\ObjectTypes',

        // DCIM
        'cableTerminations' => 'DCIM\CableTerminations',
        'cables' => 'DCIM\Cables',
        'connectedDevice' => 'DCIM\ConnectedDevice',
        'connectedDevices' => 'DCIM\ConnectedDevice',
        'consolePortTemplates' => 'DCIM\ConsolePortTemplates',
        'consolePorts' => 'DCIM\ConsolePorts',
        'consoleServerPortTemplates' => 'DCIM\ConsoleServerPortTemplates',
        'consoleServerPorts' => 'DCIM\ConsoleServerPorts',
        'deviceBayTemplates' => 'DCIM\DeviceBayTemplates',
        'deviceBays' => 'DCIM\DeviceBays',
        'deviceRoles' => 'DCIM\DeviceRoles',
        'deviceTypes' => 'DCIM\DeviceTypes',
        'devices' => 'DCIM\Devices',
        'frontPortTemplates' => 'DCIM\FrontPortTemplates',
        'frontPorts' => 'DCIM\FrontPorts',
        'interfaceTemplates' => 'DCIM\InterfaceTemplates',
        'interfaces' => 'DCIM\Interfaces',
        'inventoryItemRoles' => 'DCIM\InventoryItemRoles',
        'inventoryItemTemplates' => 'DCIM\InventoryItemTemplates',
        'inventoryItems' => 'DCIM\InventoryItems',
        'locations' => 'DCIM\Locations',
        'macAddresses' => 'DCIM\MacAddresses',
        'manufacturers' => 'DCIM\Manufacturers',
        'moduleBayTemplates' => 'DCIM\ModuleBayTemplates',
        'moduleBays' => 'DCIM\ModuleBays',
        'moduleTypeProfiles' => 'DCIM\ModuleTypeProfiles',
        'moduleTypes' => 'DCIM\ModuleTypes',
        'modules' => 'DCIM\Modules',
        'platforms' => 'DCIM\Platforms',
        'powerFeeds' => 'DCIM\PowerFeeds',
        'powerOutletTemplates' => 'DCIM\PowerOutletTemplates',
        'powerOutlets' => 'DCIM\PowerOutlets',
        'powerPanels' => 'DCIM\PowerPanels',
        'powerPortTemplates' => 'DCIM\PowerPortTemplates',
        'powerPorts' => 'DCIM\PowerPorts',
        'rackReservations' => 'DCIM\RackReservations',
        'rackRoles' => 'DCIM\RackRoles',
        'rackTypes' => 'DCIM\RackTypes',
        'racks' => 'DCIM\Racks',
        'rearPortTemplates' => 'DCIM\RearPortTemplates',
        'rearPorts' => 'DCIM\RearPorts',
        'regions' => 'DCIM\Regions',
        'siteGroups' => 'DCIM\SiteGroups',
        'sites' => 'DCIM\Sites',
        'virtualChassis' => 'DCIM\VirtualChassis',
        'virtualDeviceContexts' => 'DCIM\VirtualDeviceContexts',

        // Extras
        'bookmarks' => 'Extras\Bookmarks',
        'configContextProfiles' => 'Extras\ConfigContextProfiles',
        'configContexts' => 'Extras\ConfigContexts',
        'configTemplates' => 'Extras\ConfigTemplates',
        'customFieldChoiceSets' => 'Extras\CustomFieldChoiceSets',
        'customFields' => 'Extras\CustomFields',
        'customLinks' => 'Extras\CustomLinks',
        'dashboard' => 'Extras\Dashboard',
        'eventRules' => 'Extras\EventRules',
        'exportTemplates' => 'Extras\ExportTemplates',
        'imageAttachments' => 'Extras\ImageAttachments',
        'journalEntries' => 'Extras\JournalEntries',
        'notificationGroups' => 'Extras\NotificationGroups',
        'notifications' => 'Extras\Notifications',
        'savedFilters' => 'Extras\SavedFilters',
        'scripts' => 'Extras\Scripts',
        'subscriptions' => 'Extras\Subscriptions',
        'tableConfigs' => 'Extras\TableConfigs',
        'taggedObjects' => 'Extras\TaggedObjects',
        'tags' => 'Extras\Tags',
        'webhooks' => 'Extras\Webhooks',

        // IPAM
        'aggregates' => 'IPAM\Aggregates',
        'asnRanges' => 'IPAM\AsnRanges',
        'asns' => 'IPAM\Asns',
        'fhrpGroupAssignments' => 'IPAM\FhrpGroupAssignments',
        'fhrpGroups' => 'IPAM\FhrpGroups',
        'ipAddresses' => 'IPAM\IpAddresses',
        'ipRanges' => 'IPAM\IpRanges',
        'prefixes' => 'IPAM\Prefixes',
        'rirs' => 'IPAM\Rirs',
        'roles' => 'IPAM\Roles',
        'routeTargets' => 'IPAM\RouteTargets',
        'serviceTemplates' => 'IPAM\ServiceTemplates',
        'services' => 'IPAM\Services',
        'vlanGroups' => 'IPAM\VlanGroups',
        'vlanTranslationPolicies' => 'IPAM\VlanTranslationPolicies',
        'vlanTranslationRules' => 'IPAM\VlanTranslationRules',
        'vlans' => 'IPAM\Vlans',
        'vrfs' => 'IPAM\Vrfs',

        // Plugins / NetboxTopologyViews
        'netboxTopologyViewsCircuitcoordinate' => 'Plugins\NetboxTopologyViews\Circuitcoordinate',
        'netboxTopologyViewsCoordinate' => 'Plugins\NetboxTopologyViews\Coordinate',
        'netboxTopologyViewsCoordinateGroups' => 'Plugins\NetboxTopologyViews\CoordinateGroups',
        'netboxTopologyViewsImages' => 'Plugins\NetboxTopologyViews\Images',
        'netboxTopologyViewsPowerfeedcoordinate' => 'Plugins\NetboxTopologyViews\Powerfeedcoordinate',
        'netboxTopologyViewsPowerpanelcoordinate' => 'Plugins\NetboxTopologyViews\Powerpanelcoordinate',
        'netboxTopologyViewsSaveCoords' => 'Plugins\NetboxTopologyViews\SaveCoords',
        'netboxTopologyViewsXmlExport' => 'Plugins\NetboxTopologyViews\XmlExport',

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
        'ownerGroups' => 'Users\OwnerGroups',
        'owners' => 'Users\Owners',
        'permissions' => 'Users\Permissions',
        'tokens' => 'Users\Tokens',
        'users' => 'Users\Users',

        // Virtualization
        'clusterGroups' => 'Virtualization\ClusterGroups',
        'clusterTypes' => 'Virtualization\ClusterTypes',
        'clusters' => 'Virtualization\Clusters',
        'vinterfaces' => 'Virtualization\Interfaces',
        'virtualDisks' => 'Virtualization\VirtualDisks',
        'virtualMachines' => 'Virtualization\VirtualMachines',
        'virtualizationInterfaces' => 'Virtualization\Interfaces',

        // VPN
        'ikePolicies' => 'VPN\IkePolicies',
        'ikeProposals' => 'VPN\IkeProposals',
        'ipsecPolicies' => 'VPN\IpsecPolicies',
        'ipsecProfiles' => 'VPN\IpsecProfiles',
        'ipsecProposals' => 'VPN\IpsecProposals',
        'l2vpnTerminations' => 'VPN\L2vpnTerminations',
        'l2vpns' => 'VPN\L2vpns',
        'tunnelGroups' => 'VPN\TunnelGroups',
        'tunnelTerminations' => 'VPN\TunnelTerminations',
        'tunnels' => 'VPN\Tunnels',

        // Wireless
        'wirelessLanGroups' => 'Wireless\WirelessLanGroups',
        'wirelessLans' => 'Wireless\WirelessLans',
        'wirelessLinks' => 'Wireless\WirelessLinks',

        // Deprecated endpoints retained for backwards compatibility
        'consoleConnections' => 'DCIM\ConsoleConnections',
        'interfaceConnections' => 'DCIM\InterfaceConnections',
        'keyGen' => 'Secrets\KeyGen',
        'rackGroups' => 'DCIM\RackGroups',
        'reports' => 'Extras\Reports',
        'secretRoles' => 'Secrets\SecretRoles',
        'secrets' => 'Secrets\Secrets',
        'session' => 'Secrets\Session',
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
