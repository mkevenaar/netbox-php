# NetBox PHP

Note, this is a fork of the Wicked Software Corp. "[Laravel NetBox](https://github.com/wickedsoft/laravel-netbox)" Package, original Credits go to them.

Note, this is a fork of the "[port389/netbox-php](https://github.com/hexa2k9/netbox-php)" Package, original Credits go to them

The Package was refactored to allow Installation as a standalone composer package (thus is available under the `mkevenaar` namespace for this package). The package was tested against [NetBox v3.2.2](https://github.com/netbox-community/netbox/releases/tag/v3.2.2) while implementing NetBox in the company I'm working for in "scratch your own itch"-Mode. We mainly use the IPAM module in NetBox, other components are not heavily tested.

## Installation

```bash
composer require mkevenaar/netbox
```

### Environment Variables

The package requires 2 environment variables being set accessible through `getenv()`

| Variable        | Type   | Default |  Description                                                                |
|-----------------|--------|---------|-----------------------------------------------------------------------------|
| NETBOX_API      | string | ""      | the NetBox API Endpoint (e.g. `http://localhost:8080/api`)                  |
| NETBOX_API_KEY  | string | ""      | The NetBox API Key created from eg `http://127.0.0.1:8080/user/api-tokens/` |

## Example Usage

```php
$api = new \mkevenaar\NetBox\Api\IPAM\IpAddresses(new \mkevenaar\NetBox\Client());
$result = $api->add([
    'address'  => '11.22.33.44/32',
    'dns_name' => 'foo.example.com'
]);

$result = $api->list(['address' => '11.22.33.44/32']);
```

## Supported NetBox APIs

API wrappers are organized by their namespace and directory under `src/Api`.

* General
  * [AuthenticationCheck](src/Api/AuthenticationCheck.php)
  * [Schema](src/Api/Schema.php)
  * [Status](src/Api/Status.php)
* Circuits
  * [CircuitGroupAssignments](src/Api/Circuits/CircuitGroupAssignments.php)
  * [CircuitGroups](src/Api/Circuits/CircuitGroups.php)
  * [Circuits](src/Api/Circuits/Circuits.php)
  * [CircuitTerminations](src/Api/Circuits/CircuitTerminations.php)
  * [CircuitTypes](src/Api/Circuits/CircuitTypes.php)
  * [ProviderAccounts](src/Api/Circuits/ProviderAccounts.php)
  * [ProviderNetworks](src/Api/Circuits/ProviderNetworks.php)
  * [Providers](src/Api/Circuits/Providers.php)
  * [VirtualCircuits](src/Api/Circuits/VirtualCircuits.php)
  * [VirtualCircuitTerminations](src/Api/Circuits/VirtualCircuitTerminations.php)
  * [VirtualCircuitTypes](src/Api/Circuits/VirtualCircuitTypes.php)
* Core
  * [BackgroundQueues](src/Api/Core/BackgroundQueues.php)
  * [BackgroundTasks](src/Api/Core/BackgroundTasks.php)
  * [BackgroundWorkers](src/Api/Core/BackgroundWorkers.php)
  * [DataFiles](src/Api/Core/DataFiles.php)
  * [DataSources](src/Api/Core/DataSources.php)
  * [Jobs](src/Api/Core/Jobs.php)
  * [ObjectChanges](src/Api/Core/ObjectChanges.php)
  * [ObjectTypes](src/Api/Core/ObjectTypes.php)
* DCIM
  * [Cables](src/Api/DCIM/Cables.php)
  * [CableTerminations](src/Api/DCIM/CableTerminations.php)
  * [ConnectedDevice](src/Api/DCIM/ConnectedDevice.php)
  * [ConnectedDevices](src/Api/DCIM/ConnectedDevices.php)
  * [ConsoleConnections](src/Api/DCIM/ConsoleConnections.php)
  * [ConsolePorts](src/Api/DCIM/ConsolePorts.php)
  * [ConsolePortTemplates](src/Api/DCIM/ConsolePortTemplates.php)
  * [ConsoleServerPorts](src/Api/DCIM/ConsoleServerPorts.php)
  * [ConsoleServerPortTemplates](src/Api/DCIM/ConsoleServerPortTemplates.php)
  * [DeviceBays](src/Api/DCIM/DeviceBays.php)
  * [DeviceBayTemplates](src/Api/DCIM/DeviceBayTemplates.php)
  * [DeviceRoles](src/Api/DCIM/DeviceRoles.php)
  * [Devices](src/Api/DCIM/Devices.php)
  * [DeviceTypes](src/Api/DCIM/DeviceTypes.php)
  * [FrontPorts](src/Api/DCIM/FrontPorts.php)
  * [FrontPortTemplates](src/Api/DCIM/FrontPortTemplates.php)
  * [InterfaceConnections](src/Api/DCIM/InterfaceConnections.php)
  * [Interfaces](src/Api/DCIM/Interfaces.php)
  * [InterfaceTemplates](src/Api/DCIM/InterfaceTemplates.php)
  * [InventoryItemRoles](src/Api/DCIM/InventoryItemRoles.php)
  * [InventoryItems](src/Api/DCIM/InventoryItems.php)
  * [InventoryItemTemplates](src/Api/DCIM/InventoryItemTemplates.php)
  * [Locations](src/Api/DCIM/Locations.php)
  * [MacAddresses](src/Api/DCIM/MacAddresses.php)
  * [Manufacturers](src/Api/DCIM/Manufacturers.php)
  * [ModuleBays](src/Api/DCIM/ModuleBays.php)
  * [ModuleBayTemplates](src/Api/DCIM/ModuleBayTemplates.php)
  * [Modules](src/Api/DCIM/Modules.php)
  * [ModuleTypeProfiles](src/Api/DCIM/ModuleTypeProfiles.php)
  * [ModuleTypes](src/Api/DCIM/ModuleTypes.php)
  * [Platforms](src/Api/DCIM/Platforms.php)
  * [PowerFeeds](src/Api/DCIM/PowerFeeds.php)
  * [PowerOutlets](src/Api/DCIM/PowerOutlets.php)
  * [PowerOutletTemplates](src/Api/DCIM/PowerOutletTemplates.php)
  * [PowerPanels](src/Api/DCIM/PowerPanels.php)
  * [PowerPorts](src/Api/DCIM/PowerPorts.php)
  * [PowerPortTemplates](src/Api/DCIM/PowerPortTemplates.php)
  * [RackGroups](src/Api/DCIM/RackGroups.php)
  * [RackReservations](src/Api/DCIM/RackReservations.php)
  * [RackRoles](src/Api/DCIM/RackRoles.php)
  * [Racks](src/Api/DCIM/Racks.php)
  * [RackTypes](src/Api/DCIM/RackTypes.php)
  * [RearPorts](src/Api/DCIM/RearPorts.php)
  * [RearPortTemplates](src/Api/DCIM/RearPortTemplates.php)
  * [Regions](src/Api/DCIM/Regions.php)
  * [SiteGroups](src/Api/DCIM/SiteGroups.php)
  * [Sites](src/Api/DCIM/Sites.php)
  * [VirtualChassis](src/Api/DCIM/VirtualChassis.php)
  * [VirtualDeviceContexts](src/Api/DCIM/VirtualDeviceContexts.php)
* Extras
  * [Bookmarks](src/Api/Extras/Bookmarks.php)
  * [ConfigContextProfiles](src/Api/Extras/ConfigContextProfiles.php)
  * [ConfigContexts](src/Api/Extras/ConfigContexts.php)
  * [ConfigTemplates](src/Api/Extras/ConfigTemplates.php)
  * [ContentTypes](src/Api/Extras/ContentTypes.php)
  * [CustomFieldChoiceSets](src/Api/Extras/CustomFieldChoiceSets.php)
  * [CustomFields](src/Api/Extras/CustomFields.php)
  * [CustomLinks](src/Api/Extras/CustomLinks.php)
  * [Dashboard](src/Api/Extras/Dashboard.php)
  * [EventRules](src/Api/Extras/EventRules.php)
  * [ExportTemplates](src/Api/Extras/ExportTemplates.php)
  * [ImageAttachments](src/Api/Extras/ImageAttachments.php)
  * [JobResults](src/Api/Extras/JobResults.php)
  * [JournalEntries](src/Api/Extras/JournalEntries.php)
  * [NotificationGroups](src/Api/Extras/NotificationGroups.php)
  * [Notifications](src/Api/Extras/Notifications.php)
  * [ObjectChanges](src/Api/Extras/ObjectChanges.php)
  * [Reports](src/Api/Extras/Reports.php)
  * [SavedFilters](src/Api/Extras/SavedFilters.php)
  * [Scripts](src/Api/Extras/Scripts.php)
  * [Subscriptions](src/Api/Extras/Subscriptions.php)
  * [TableConfigs](src/Api/Extras/TableConfigs.php)
  * [TaggedObjects](src/Api/Extras/TaggedObjects.php)
  * [Tags](src/Api/Extras/Tags.php)
  * [Webhooks](src/Api/Extras/Webhooks.php)
* IPAM
  * [Aggregates](src/Api/IPAM/Aggregates.php)
  * [AsnRanges](src/Api/IPAM/AsnRanges.php)
  * [Asns](src/Api/IPAM/Asns.php)
  * [FhrpGroupAssignments](src/Api/IPAM/FhrpGroupAssignments.php)
  * [FhrpGroups](src/Api/IPAM/FhrpGroups.php)
  * [IpAddresses](src/Api/IPAM/IpAddresses.php)
  * [IpRanges](src/Api/IPAM/IpRanges.php)
  * [Prefixes](src/Api/IPAM/Prefixes.php)
  * [Rirs](src/Api/IPAM/Rirs.php)
  * [Roles](src/Api/IPAM/Roles.php)
  * [RouteTargets](src/Api/IPAM/RouteTargets.php)
  * [Services](src/Api/IPAM/Services.php)
  * [ServiceTemplates](src/Api/IPAM/ServiceTemplates.php)
  * [VlanGroups](src/Api/IPAM/VlanGroups.php)
  * [Vlans](src/Api/IPAM/Vlans.php)
  * [VlanTranslationPolicies](src/Api/IPAM/VlanTranslationPolicies.php)
  * [VlanTranslationRules](src/Api/IPAM/VlanTranslationRules.php)
  * [Vrfs](src/Api/IPAM/Vrfs.php)
* Plugins / NetboxTopologyViews
  * [Circuitcoordinate](src/Api/Plugins/NetboxTopologyViews/Circuitcoordinate.php)
  * [Coordinate](src/Api/Plugins/NetboxTopologyViews/Coordinate.php)
  * [CoordinateGroups](src/Api/Plugins/NetboxTopologyViews/CoordinateGroups.php)
  * [Images](src/Api/Plugins/NetboxTopologyViews/Images.php)
  * [Powerfeedcoordinate](src/Api/Plugins/NetboxTopologyViews/Powerfeedcoordinate.php)
  * [Powerpanelcoordinate](src/Api/Plugins/NetboxTopologyViews/Powerpanelcoordinate.php)
  * [SaveCoords](src/Api/Plugins/NetboxTopologyViews/SaveCoords.php)
  * [XmlExport](src/Api/Plugins/NetboxTopologyViews/XmlExport.php)
* Secrets
  * [KeyGen](src/Api/Secrets/KeyGen.php)
  * [SecretRoles](src/Api/Secrets/SecretRoles.php)
  * [Secrets](src/Api/Secrets/Secrets.php)
  * [Session](src/Api/Secrets/Session.php)
* Tenancy
  * [ContactAssignments](src/Api/Tenancy/ContactAssignments.php)
  * [ContactGroups](src/Api/Tenancy/ContactGroups.php)
  * [ContactRoles](src/Api/Tenancy/ContactRoles.php)
  * [Contacts](src/Api/Tenancy/Contacts.php)
  * [TenantGroups](src/Api/Tenancy/TenantGroups.php)
  * [Tenants](src/Api/Tenancy/Tenants.php)
* Users
  * [Config](src/Api/Users/Config.php)
  * [Groups](src/Api/Users/Groups.php)
  * [OwnerGroups](src/Api/Users/OwnerGroups.php)
  * [Owners](src/Api/Users/Owners.php)
  * [Permissions](src/Api/Users/Permissions.php)
  * [Tokens](src/Api/Users/Tokens.php)
  * [Users](src/Api/Users/Users.php)
* Virtualization
  * [ClusterGroups](src/Api/Virtualization/ClusterGroups.php)
  * [Clusters](src/Api/Virtualization/Clusters.php)
  * [ClusterTypes](src/Api/Virtualization/ClusterTypes.php)
  * [Interfaces](src/Api/Virtualization/Interfaces.php)
  * [VirtualDisks](src/Api/Virtualization/VirtualDisks.php)
  * [VirtualMachines](src/Api/Virtualization/VirtualMachines.php)
* VPN
  * [IkePolicies](src/Api/VPN/IkePolicies.php)
  * [IkeProposals](src/Api/VPN/IkeProposals.php)
  * [IpsecPolicies](src/Api/VPN/IpsecPolicies.php)
  * [IpsecProfiles](src/Api/VPN/IpsecProfiles.php)
  * [IpsecProposals](src/Api/VPN/IpsecProposals.php)
  * [L2vpns](src/Api/VPN/L2vpns.php)
  * [L2vpnTerminations](src/Api/VPN/L2vpnTerminations.php)
  * [TunnelGroups](src/Api/VPN/TunnelGroups.php)
  * [Tunnels](src/Api/VPN/Tunnels.php)
  * [TunnelTerminations](src/Api/VPN/TunnelTerminations.php)
* Wireless
  * [WirelessLanGroups](src/Api/Wireless/WirelessLanGroups.php)
  * [WirelessLans](src/Api/Wireless/WirelessLans.php)
  * [WirelessLinks](src/Api/Wireless/WirelessLinks.php)
