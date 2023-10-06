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

$result = $api->list(['address' => '11.22.33.44/32'])
```

## Supported NetBox APIs

* Circuits
  * [CircuitTerminations](src/Api/Circuits/CircuitTerminations.php)
  * [CircuitTypes](src/Api/Circuits/CircuitTypes.php)
  * [Circuits](src/Api/Circuits/Circuits.php)
  * [Providers](src/Api/Circuits/Providers.php)
* DCIM
  * [Cables](src/Api/DCIM/Cables.php)
  * [ConnectedDevices](src/Api/DCIM/ConnectedDevices.php)
  * [ConsoleConnections](src/Api/DCIM/ConsoleConnections.php)
  * [ConsolePortTemplates](src/Api/DCIM/ConsolePortTemplates.php)
  * [ConsolePorts](src/Api/DCIM/ConsolePorts.php)
  * [ConsoleServerPortTemplates](src/Api/DCIM/ConsoleServerPortTemplates.php)
  * [ConsoleServerPorts](src/Api/DCIM/ConsoleServerPorts.php)
  * [DeviceBayTemplates](src/Api/DCIM/DeviceBayTemplates.php)
  * [DeviceBays](src/Api/DCIM/DeviceBays.php)
  * [DeviceRoles](src/Api/DCIM/DeviceRoles.php)
  * [DeviceTypes](src/Api/DCIM/DeviceTypes.php)
  * [Devices](src/Api/DCIM/Devices.php)
  * [FrontPortTemplates](src/Api/DCIM/FrontPortTemplates.php)
  * [FrontPorts](src/Api/DCIM/FrontPorts.php)
  * [InterfaceConnections](src/Api/DCIM/InterfaceConnections.php)
  * [InterfaceTemplates](src/Api/DCIM/InterfaceTemplates.php)
  * [Interfaces](src/Api/DCIM/Interfaces.php)
  * [InventoryItems](src/Api/DCIM/InventoryItems.php)
  * [Manufacturers](src/Api/DCIM/Manufacturers.php)
  * [Platforms](src/Api/DCIM/Platforms.php)
  * [PowerFeeds](src/Api/DCIM/PowerFeeds.php)
  * [PowerOutletTemplates](src/Api/DCIM/PowerOutletTemplates.php)
  * [PowerOutlets](src/Api/DCIM/PowerOutlets.php)
  * [PowerPanels](src/Api/DCIM/PowerPanels.php)
  * [PowerPortTemplates](src/Api/DCIM/PowerPortTemplates.php)
  * [PowerPorts](src/Api/DCIM/PowerPorts.php)
  * [RackGroups](src/Api/DCIM/RackGroups.php)
  * [RackReservations](src/Api/DCIM/RackReservations.php)
  * [RackRoles](src/Api/DCIM/RackRoles.php)
  * [Racks](src/Api/DCIM/Racks.php)
  * [RearPortTemplates](src/Api/DCIM/RearPortTemplates.php)
  * [RearPorts](src/Api/DCIM/RearPorts.php)
  * [Regions](src/Api/DCIM/Regions.php)
  * [Sites](src/Api/DCIM/Sites.php)
  * [VirtualChassis](src/Api/DCIM/VirtualChassis.php)
* Extras
  * [ConfigContexts](src/Api/Extras/ConfigContexts.php)
  * [ContentTypes](src/Api/Extras/ContentTypes.php)
  * [CustomFields](src/Api/Extras/CustomFields.php)
  * [ExportTemplates](src/Api/Extras/ExportTemplates.php)
  * [ImageAttachments](src/Api/Extras/ImageAttachments.php)
  * [JobResults](src/Api/Extras/JobResults.php)
  * [ObjectChanges](src/Api/Extras/ObjectChanges.php)
  * [Reports](src/Api/Extras/Reports.php)
  * [Scripts](src/Api/Extras/Scripts.php)
  * [Tags](src/Api/Extras/Tags.php)
* IPAM
  * [Aggregates](src/Api/IPAM/Aggregates.php)
  * [IpAddresses](src/Api/IPAM/IpAddresses.php)
  * [Prefixes](src/Api/IPAM/Prefixes.php)
  * [Rirs](src/Api/IPAM/Rirs.php)
  * [Roles](src/Api/IPAM/Roles.php)
  * [RouteTargets](src/Api/IPAM/RouteTargets.php)
  * [Services](src/Api/IPAM/Services.php)
  * [VlanGroups](src/Api/IPAM/VlanGroups.php)
  * [Vlans](src/Api/IPAM/Vlans.php)
  * [Vrfs](src/Api/IPAM/Vrfs.php)
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
  * [Permissions](src/Api/Users/Permissions.php)
  * [Users](src/Api/Users/Users.php)
* Virtualization
  * [ClusterGroups](src/Api/Virtualization/ClusterGroups.php)
  * [ClusterTypes](src/Api/Virtualization/ClusterTypes.php)
  * [Clusters](src/Api/Virtualization/Clusters.php)
  * [Interfaces](src/Api/Virtualization/Interfaces.php)
  * [VirtualMachines](src/Api/Virtualization/VirtualMachines.php)
