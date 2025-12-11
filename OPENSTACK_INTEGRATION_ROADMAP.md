# OpenStack Instance Management - Roadmap & Architecture

## 📋 Executive Summary

This document outlines the complete architecture, database design, and implementation roadmap for integrating OpenStack instance management into the customer portal. The system will enable customers to create, manage, and monitor OpenStack instances with real-time updates via WebSockets (Reverb).

## 🎯 Goals

1. **Local-First Instance Creation**: Customers create instances locally, which are then provisioned in OpenStack
2. **Synced Metadata**: Flavors, networks, images, and other resources are synced from OpenStack and stored locally
3. **Real-Time Updates**: Use Laravel Reverb for WebSocket updates during instance provisioning and status changes
4. **Bidirectional Sync**: Instances are synced between local database and OpenStack
5. **Phase 1**: Instance creation is local-first; other data fetched directly from OpenStack API
6. **Future**: All data will be local-first with periodic sync

---

## 🗄️ Database Architecture

### Core Tables

#### 1. `openstack_instances`
Stores instance information locally (local-first for creation).

```sql
- id (UUID, primary key)
- customer_id (UUID, foreign key -> customers.id)
- name (string)
- description (text, nullable)
- openstack_server_id (string, nullable) - OpenStack server UUID
- openstack_project_id (string, nullable) - OpenStack project/tenant ID
- status (enum: pending, building, active, stopped, error, deleting, deleted)
- flavor_id (UUID, foreign key -> openstack_flavors.id)
- image_id (UUID, foreign key -> openstack_images.id)
- key_pair_id (UUID, foreign key -> openstack_key_pairs.id, nullable)
- root_password_hash (string, nullable) - Encrypted if password-based auth
- user_data (text, nullable) - Cloud-init script
- region (string) - OpenStack region
- availability_zone (string, nullable)
- metadata (json, nullable) - Custom metadata
- config_drive (boolean, default: false)
- auto_billing (boolean, default: true)
- billing_cycle (enum: hourly, monthly)
- monthly_cost (decimal, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, nullable)
- synced_at (timestamp, nullable) - Last sync with OpenStack
- last_openstack_status (string, nullable) - Last known OpenStack status
```

#### 2. `openstack_flavors`
Synced from OpenStack, stored locally for fast access.

```sql
- id (UUID, primary key)
- openstack_id (string, unique) - OpenStack flavor ID
- name (string)
- description (text, nullable)
- vcpus (integer)
- ram (integer) - MB
- disk (integer) - GB
- ephemeral_disk (integer, default: 0) - GB
- swap (integer, default: 0) - MB
- is_public (boolean, default: true)
- is_disabled (boolean, default: false)
- extra_specs (json, nullable) - Additional flavor specs
- pricing_hourly (decimal, nullable) - Local pricing override
- pricing_monthly (decimal, nullable) - Local pricing override
- region (string) - Which region this flavor is available in
- created_at (timestamp)
- updated_at (timestamp)
- synced_at (timestamp, nullable)
```

#### 3. `openstack_images`
Synced from OpenStack Glance.

```sql
- id (UUID, primary key)
- openstack_id (string, unique)
- name (string)
- description (text, nullable)
- status (string) - active, queued, saving, etc.
- visibility (enum: public, private, shared, community)
- disk_format (string) - qcow2, raw, iso, etc.
- container_format (string) - bare, ovf, etc.
- min_disk (integer, nullable) - GB
- min_ram (integer, nullable) - MB
- size (bigint, nullable) - Bytes
- checksum (string, nullable)
- owner_id (string, nullable) - OpenStack project ID
- metadata (json, nullable)
- region (string)
- created_at (timestamp)
- updated_at (timestamp)
- synced_at (timestamp, nullable)
```

#### 4. `openstack_networks`
Synced from OpenStack Neutron.

```sql
- id (UUID, primary key)
- openstack_id (string, unique)
- name (string)
- description (text, nullable)
- status (string) - ACTIVE, DOWN, etc.
- admin_state_up (boolean)
- shared (boolean, default: false)
- external (boolean, default: false) - Is external/public network
- provider_network_type (string, nullable) - flat, vlan, vxlan, gre, etc.
- provider_segmentation_id (integer, nullable) - VLAN ID, etc.
- provider_physical_network (string, nullable)
- router_external (boolean, default: false)
- availability_zones (json, nullable) - Array of AZs
- subnets (json, nullable) - Array of subnet IDs
- region (string)
- created_at (timestamp)
- updated_at (timestamp)
- synced_at (timestamp, nullable)
```

#### 5. `openstack_subnets`
Synced from OpenStack Neutron.

```sql
- id (UUID, primary key)
- openstack_id (string, unique)
- network_id (UUID, foreign key -> openstack_networks.id)
- name (string)
- description (text, nullable)
- cidr (string) - IP range (e.g., 192.168.1.0/24)
- ip_version (integer, default: 4) - 4 or 6
- gateway_ip (string, nullable)
- enable_dhcp (boolean, default: true)
- dns_nameservers (json, nullable) - Array of DNS servers
- allocation_pools (json, nullable) - Array of {start, end} IP ranges
- host_routes (json, nullable)
- region (string)
- created_at (timestamp)
- updated_at (timestamp)
- synced_at (timestamp, nullable)
```

#### 6. `openstack_key_pairs`
SSH key pairs (can be local or synced from OpenStack).

```sql
- id (UUID, primary key)
- customer_id (UUID, foreign key -> customers.id)
- openstack_id (string, nullable, unique) - OpenStack key pair ID
- name (string)
- public_key (text)
- private_key (text, nullable) - Only if generated locally
- fingerprint (string, nullable)
- region (string)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 7. `openstack_security_groups`
Synced from OpenStack Neutron.

```sql
- id (UUID, primary key)
- openstack_id (string, unique)
- name (string)
- description (text, nullable)
- rules (json) - Array of security group rules
- region (string)
- created_at (timestamp)
- updated_at (timestamp)
- synced_at (timestamp, nullable)
```

#### 8. `openstack_instance_networks`
Pivot table for instance-network relationships.

```sql
- id (UUID, primary key)
- instance_id (UUID, foreign key -> openstack_instances.id)
- network_id (UUID, foreign key -> openstack_networks.id)
- subnet_id (UUID, foreign key -> openstack_subnets.id, nullable)
- fixed_ip (string, nullable) - Assigned IP address
- floating_ip (string, nullable) - Floating IP if assigned
- is_primary (boolean, default: false)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 9. `openstack_instance_security_groups`
Pivot table for instance-security group relationships.

```sql
- id (UUID, primary key)
- instance_id (UUID, foreign key -> openstack_instances.id)
- security_group_id (UUID, foreign key -> openstack_security_groups.id)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 10. `openstack_sync_jobs`
Tracks sync operations for monitoring and debugging.

```sql
- id (UUID, primary key)
- resource_type (string) - instances, flavors, images, networks, etc.
- status (enum: pending, running, completed, failed)
- started_at (timestamp, nullable)
- completed_at (timestamp, nullable)
- records_synced (integer, default: 0)
- errors (json, nullable) - Array of error messages
- metadata (json, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 11. `openstack_instance_events`
Event log for instance lifecycle events (for audit trail and real-time updates).

```sql
- id (UUID, primary key)
- instance_id (UUID, foreign key -> openstack_instances.id)
- event_type (string) - created, building, active, stopped, error, etc.
- message (text)
- metadata (json, nullable)
- created_at (timestamp)
```

---

## 🏗️ Software Architecture

### Layer Structure

```
┌─────────────────────────────────────────────────────────┐
│                    Frontend (Blade/Vue)                 │
│  - Server Creation Wizard                               │
│  - Real-time Status Updates (Reverb WebSocket)          │
│  - Instance Management UI                               │
└─────────────────────────────────────────────────────────┘
                          ↕
┌─────────────────────────────────────────────────────────┐
│              Controllers (HTTP Layer)                    │
│  - ServerController (Customer)                           │
│  - OpenStackResourceController (API endpoints)          │
└─────────────────────────────────────────────────────────┘
                          ↕
┌─────────────────────────────────────────────────────────┐
│              Services (Business Logic)                   │
│  - OpenStackInstanceService                             │
│  - OpenStackSyncService                                 │
│  - OpenStackConnectionService                            │
└─────────────────────────────────────────────────────────┘
                          ↕
┌─────────────────────────────────────────────────────────┐
│              Repositories (Data Access)                  │
│  - InstanceRepository                                   │
│  - FlavorRepository                                     │
│  - NetworkRepository                                    │
└─────────────────────────────────────────────────────────┘
                          ↕
┌─────────────────────────────────────────────────────────┐
│              OpenStack SDK Wrapper                       │
│  - OpenStackClient (php-opencloud/openstack)            │
│  - NovaService, NeutronService, GlanceService          │
└─────────────────────────────────────────────────────────┘
                          ↕
┌─────────────────────────────────────────────────────────┐
│              Database (Local Cache + Source of Truth)    │
│  - MySQL/PostgreSQL                                     │
└─────────────────────────────────────────────────────────┘
                          ↕
┌─────────────────────────────────────────────────────────┐
│              OpenStack API                               │
│  - Nova (Compute)                                       │
│  - Neutron (Networking)                                 │
│  - Glance (Images)                                      │
└─────────────────────────────────────────────────────────┘
```

### Key Components

#### 1. **OpenStackConnectionService**
Handles authentication and connection to OpenStack.

**Location**: `app/Services/OpenStack/OpenStackConnectionService.php`

**Responsibilities**:
- Authenticate with OpenStack (Keystone)
- Create service clients (Nova, Neutron, Glance)
- Handle token refresh
- Connection pooling and caching

#### 2. **OpenStackInstanceService**
Core service for instance lifecycle management.

**Location**: `app/Services/OpenStack/OpenStackInstanceService.php`

**Responsibilities**:
- Create instances locally first
- Provision instances in OpenStack
- Update instance status
- Handle instance operations (start, stop, reboot, delete)
- Sync instance status from OpenStack

#### 3. **OpenStackSyncService**
Handles syncing resources from OpenStack to local database.

**Location**: `app/Services/OpenStack/OpenStackSyncService.php`

**Responsibilities**:
- Sync flavors from OpenStack
- Sync images from OpenStack
- Sync networks and subnets
- Sync security groups
- Sync instance statuses
- Handle sync errors and retries

#### 4. **Broadcasting/Events**
Real-time updates via Laravel Broadcasting + Reverb.

**Events**:
- `InstanceCreated`
- `InstanceBuilding`
- `InstanceActive`
- `InstanceError`
- `InstanceStatusChanged`

**Channels**:
- `private-customer.{customer_id}` - Customer-specific updates
- `private-instance.{instance_id}` - Instance-specific updates

#### 5. **Jobs/Queues**
Background processing for long-running operations.

**Jobs**:
- `ProvisionOpenStackInstance` - Provisions instance in OpenStack
- `SyncOpenStackResources` - Syncs resources from OpenStack
- `SyncInstanceStatus` - Syncs instance status from OpenStack
- `CleanupFailedInstances` - Cleans up failed provisioning

---

## 📅 Implementation Roadmap

### Phase 1: Foundation (Week 1-2)

#### 1.1 Database Setup
- [x] Create all migration files
- [ ] Run migrations (ready to run: `php artisan migrate`)
- [x] Create model classes with relationships
- [x] Add model factories for testing

**✅ Completed:**
- Created 11 comprehensive migration files with production-ready best practices:
  - `openstack_flavors` - Flavor specifications with pricing
  - `openstack_images` - Image metadata and requirements
  - `openstack_networks` - Network configurations
  - `openstack_subnets` - Subnet details with IP ranges
  - `openstack_key_pairs` - SSH key pairs per customer
  - `openstack_security_groups` - Security group rules
  - `openstack_instances` - Main instance table with billing fields
  - `openstack_instance_networks` - Instance-network relationships
  - `openstack_instance_security_groups` - Instance-security group relationships
  - `openstack_sync_jobs` - Sync operation tracking
  - `openstack_instance_events` - Event log for audit trail

- Created 9 model classes with:
  - Proper UUID primary keys (matching existing pattern)
  - Comprehensive relationships (belongsTo, hasMany, belongsToMany)
  - Proper type casting (JSON, decimals, booleans, dates)
  - Useful scopes and helper methods
  - Soft deletes where appropriate
  - Billing-related fields and methods

- Created 4 model factories for testing:
  - `OpenStackFlavorFactory` - With pricing and resource specs
  - `OpenStackImageFactory` - With OS types and versions
  - `OpenStackNetworkFactory` - With network types
  - `OpenStackInstanceFactory` - With billing cycles and statuses

**Key Features Implemented:**
- ✅ UUID primary keys throughout (scalable, distributed-friendly)
- ✅ Comprehensive indexes for performance (status, region, customer_id, etc.)
- ✅ Foreign key constraints with proper cascade/restrict behavior
- ✅ Billing fields: `hourly_cost`, `monthly_cost`, `billing_cycle`, `auto_billing`, `billing_started_at`, `last_billed_at`
- ✅ Soft deletes on instances for data retention
- ✅ JSON fields for flexible metadata storage
- ✅ Full-text search indexes on name/description fields
- ✅ Sync tracking with `synced_at` timestamps
- ✅ Event logging for audit trail
- ✅ Production-ready data types and constraints

#### 1.2 OpenStack Connection
- [x] Install and configure `php-opencloud/openstack` (already installed)
- [x] Create `OpenStackConnectionService`
- [x] Add OpenStack credentials to `.env` and config
- [x] Test connection to OpenStack

**✅ Completed:**
- Created `config/openstack.php` with comprehensive configuration:
  - Authentication settings (auth URL, username, password)
  - Project/tenant configuration
  - Domain configuration
  - Connection timeouts
  - Sync settings
  - Service endpoint overrides

- Created `OpenStackConnectionService` (`app/Services/OpenStack/OpenStackConnectionService.php`):
  - Singleton service for managing OpenStack connections
  - Methods for accessing Compute (Nova), Networking (Neutron), Image (Glance), and Identity (Keystone) services
  - Connection caching to avoid re-authentication
  - Comprehensive error handling and logging
  - `testConnection()` method for verifying connectivity to all services

- Registered service in `AppServiceProvider` as singleton

- Created test command `openstack:test-connection`:
  - Tests connection to all OpenStack services
  - Displays service status and resource counts
  - Verbose mode for detailed configuration display
  - Color-coded output for success/error states


**Usage:**
```bash
# Test connection
php artisan openstack:test-connection

# Test with verbose output
php artisan openstack:test-connection --verbose
```

#### 1.3 Basic Sync Service
- [x] Create `OpenStackSyncService`
- [x] Implement flavor sync (fetch from OpenStack, store locally)
- [x] Implement image sync
- [x] Implement network sync (including subnets)
- [x] Implement security group sync
- [x] Create scheduled command for periodic sync

**✅ Completed:**
- Created `OpenStackSyncService` (`app/Services/OpenStack/OpenStackSyncService.php`) with production-ready features:
  - **Batch Processing**: Processes resources in batches of 100 for memory efficiency
  - **Transaction Safety**: All sync operations wrapped in database transactions
  - **Error Handling**: Comprehensive error handling with per-resource error tracking
  - **Job Tracking**: Creates `OpenStackSyncJob` records for monitoring and audit trail
  - **Idempotency**: Safe to run multiple times - updates existing records, creates new ones
  - **Deletion Handling**: Marks resources as deleted/disabled when removed from OpenStack
  - **Logging**: Detailed logging for debugging and monitoring
  - **Performance**: Optimized for high-volume usage with batch processing and efficient queries

- Implemented sync methods:
  - `syncFlavors()` - Syncs compute flavors with pricing and resource specs
  - `syncImages()` - Syncs Glance images with metadata and requirements
  - `syncNetworks()` - Syncs Neutron networks and their subnets
  - `syncSecurityGroups()` - Syncs security groups with rules
  - `syncAll()` - Syncs all or specified resource types

- Created `SyncOpenStackResources` command (`app/Console/Commands/SyncOpenStackResources.php`):
  - Supports syncing specific resource types or all types
  - Displays detailed sync statistics (created, updated, deleted, errors)
  - Respects `OPENSTACK_SYNC_ENABLED` config flag
  - `--force` flag to override disabled sync
  - Color-coded output for success/failure

- Configured scheduled task in `routes/console.php`:
  - Runs every 5 minutes automatically
  - `withoutOverlapping()` prevents concurrent runs
  - `runInBackground()` for non-blocking execution
  - Logs output to `storage/logs/openstack-sync.log`

**Key Production Features:**
- ✅ Batch processing (100 records per batch) for memory efficiency
- ✅ Database transactions for data integrity
- ✅ Comprehensive error tracking per resource
- ✅ Sync job records for monitoring and audit
- ✅ Automatic deletion detection (marks resources as deleted)
- ✅ Efficient database queries with proper indexes
- ✅ Detailed logging for troubleshooting
- ✅ Scheduled execution with overlap prevention
- ✅ Background execution to avoid blocking

**Usage:**
```bash
# Sync all resources
php artisan openstack:sync-resources

# Sync specific resource types
php artisan openstack:sync-resources --type=flavors --type=images

# Force sync even if disabled
php artisan openstack:sync-resources --force
```

**Monitoring:**
- Check sync jobs: `OpenStackSyncJob::latest()->get()`
- View sync logs: `tail -f storage/logs/openstack-sync.log`
- Monitor sync statistics via database queries

### Phase 2: Instance Creation (Week 3-4)

#### 2.1 Instance Service
- [x] Create `OpenStackInstanceService`
- [x] Implement local instance creation (store in DB first)
- [x] Implement OpenStack provisioning logic
- [x] Handle instance metadata and user data

**✅ Completed:**
- Created `OpenStackInstanceService` (`app/Services/OpenStack/OpenStackInstanceService.php`):
  - **Local-First Creation**: Instances are created in database first with status 'pending'
  - **Flavor Resolution**: Automatically resolves flavors from prebuilt plans or custom specs
  - **Image Resolution**: Maps OS selections (ubuntu, debian, etc.) to OpenStack images
  - **Key Pair Management**: Creates or resolves SSH key pairs for authentication
  - **Password Handling**: Encrypts passwords (not hashed) for OpenStack provisioning via cloud-init
  - **Network Attachment**: Automatically attaches external and private networks
  - **Security Group Assignment**: Attaches selected security groups
  - **Cost Calculation**: Calculates hourly and monthly costs based on flavor pricing
  - **Metadata Management**: Stores custom metadata for tracking and billing
  - **Event Logging**: Logs all instance lifecycle events for audit trail

- Created `ProvisionOpenStackInstance` job (`app/Jobs/ProvisionOpenStackInstance.php`):
  - **Queue-Based Provisioning**: Runs asynchronously in background queue
  - **Retry Logic**: 3 attempts with 30-second backoff between retries
  - **OpenStack Integration**: Creates server in OpenStack with all configuration
  - **Network Configuration**: Attaches networks, security groups, and key pairs
  - **User Data Support**: Handles cloud-init scripts for automated setup
  - **Password Injection**: Injects encrypted passwords via cloud-init for password-based auth
  - **Error Handling**: Comprehensive error handling with status updates and event logging
  - **Idempotency**: Checks if already provisioned to avoid duplicate creation

- Created `StoreServerRequest` form request:
  - **Comprehensive Validation**: Validates all form fields from the wizard
  - **Conditional Rules**: Different rules based on plan type and access method
  - **Persian Error Messages**: User-friendly error messages in Persian
  - **Data Preparation**: Converts checkbox values to proper booleans

- Updated `ServerController`:
  - **Resource Loading**: Loads flavors, images, networks, and security groups for form
  - **Instance Creation**: Uses service to create instances locally first
  - **Job Dispatch**: Dispatches provisioning job after local creation
  - **Real Data**: Updated index and show methods to use real instance data

**Key Production Features:**
- ✅ Local-first approach (instance in DB before OpenStack)
- ✅ Transaction safety (all-or-nothing creation)
- ✅ Comprehensive validation
- ✅ Secure password handling (encrypted, not hashed)
- ✅ Automatic resource resolution (flavors, images, networks)
- ✅ Queue-based provisioning (non-blocking)
- ✅ Retry mechanism for failed provisioning
- ✅ Event logging for audit trail
- ✅ Cost calculation and billing support
- ✅ Metadata storage for tracking

**Form Data Mapping:**
- `os` → Resolves to `image_id` (maps ubuntu/debian/etc. to OpenStack images)
- `plan` or `custom_*` → Resolves to `flavor_id` (prebuilt plans or custom specs)
- `access_method` → `key_pair_id` or `root_password_hash`
- `security_groups[]` → Attached security groups
- `assign_public_ip` / `create_private_network` → Network attachments
- `user_data` → Cloud-init script
- `auto_billing` / `billing_cycle` → Billing configuration

#### 2.2 Controller & Routes
- [ ] Update `ServerController` with instance creation logic
- [ ] Create API endpoints for fetching flavors/images/networks
- [ ] Update create wizard to fetch data from local DB (synced from OpenStack)
- [ ] Implement form validation

#### 2.3 Queue Jobs
- [ ] Create `ProvisionOpenStackInstance` job
- [ ] Implement retry logic for failed provisioning
- [ ] Add job monitoring and logging

### Phase 3: Real-Time Updates (Week 5)

#### 3.1 Reverb Setup
- [ ] Install Laravel Reverb
- [ ] Configure Reverb server
- [ ] Set up broadcasting channels
- [ ] Configure authentication for private channels

#### 3.2 Events & Broadcasting
- [ ] Create instance lifecycle events
- [ ] Implement event broadcasting
- [ ] Update frontend to listen to WebSocket events
- [ ] Show real-time status updates in UI

### Phase 4: Instance Management (Week 6)

#### 4.1 Instance Operations
- [ ] Implement start/stop/reboot operations
- [ ] Implement delete operation
- [ ] Add instance details page with real-time stats
- [ ] Implement instance console access (if needed)

#### 4.2 Status Sync
- [ ] Create scheduled job to sync instance statuses
- [ ] Handle status discrepancies
- [ ] Update UI when status changes

### Phase 5: Polish & Testing (Week 7-8)

#### 5.1 Error Handling
- [ ] Comprehensive error handling
- [ ] User-friendly error messages
- [ ] Retry mechanisms for failed operations
- [ ] Logging and monitoring

#### 5.2 Testing
- [ ] Unit tests for services
- [ ] Feature tests for controllers
- [ ] Integration tests with OpenStack (staging)
- [ ] Frontend testing

#### 5.3 Documentation
- [ ] API documentation
- [ ] Deployment guide
- [ ] Troubleshooting guide

---

## 🔧 Technical Implementation Details

### OpenStack Configuration

Add to `config/openstack.php`:

```php
return [
    'auth_url' => env('OPENSTACK_AUTH_URL'),
    'region' => env('OPENSTACK_REGION', 'RegionOne'),
    'user_id' => env('OPENSTACK_USER_ID'),
    'username' => env('OPENSTACK_USERNAME'),
    'password' => env('OPENSTACK_PASSWORD'),
    'project_id' => env('OPENSTACK_PROJECT_ID'),
    'project_name' => env('OPENSTACK_PROJECT_NAME'),
    'domain_id' => env('OPENSTACK_DOMAIN_ID'),
    'domain_name' => env('OPENSTACK_DOMAIN_NAME', 'Default'),
    'timeout' => env('OPENSTACK_TIMEOUT', 30),
    'sync_interval' => env('OPENSTACK_SYNC_INTERVAL', 300), // 5 minutes
];
```

### Service Example Structure

```php
// app/Services/OpenStack/OpenStackInstanceService.php

class OpenStackInstanceService
{
    public function __construct(
        private OpenStackConnectionService $connection,
        private InstanceRepository $repository
    ) {}

    public function create(array $data, Customer $customer): OpenStackInstance
    {
        DB::beginTransaction();
        try {
            // 1. Create instance locally first
            $instance = $this->repository->create([
                'customer_id' => $customer->id,
                'name' => $data['name'],
                'flavor_id' => $data['flavor_id'],
                'image_id' => $data['image_id'],
                'status' => 'pending',
                // ... other fields
            ]);

            // 2. Dispatch job to provision in OpenStack
            ProvisionOpenStackInstance::dispatch($instance);

            // 3. Broadcast event
            broadcast(new InstanceCreated($instance))->toOthers();

            DB::commit();
            return $instance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
```

### WebSocket Channel Example

```php
// routes/channels.php

Broadcast::channel('private-customer.{customerId}', function ($user, $customerId) {
    return (string) $user->id === (string) $customerId;
});

Broadcast::channel('private-instance.{instanceId}', function ($user, $instanceId) {
    $instance = OpenStackInstance::findOrFail($instanceId);
    return (string) $user->id === (string) $instance->customer_id;
});
```

### Frontend WebSocket Example

```javascript
// resources/js/app.js or in Blade template

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Listen for instance updates
Echo.private(`instance.${instanceId}`)
    .listen('.instance.status.changed', (e) => {
        console.log('Instance status:', e.instance.status);
        updateUI(e.instance);
    });
```

---

## 🔄 Sync Strategy

### Initial Sync
- Run on application startup or via scheduled command
- Fetch all flavors, images, networks from OpenStack
- Store in local database

### Periodic Sync
- Run every 5 minutes (configurable)
- Update existing records
- Add new records
- Mark deleted records (soft delete or flag)

### On-Demand Sync
- Trigger sync when user requests resources
- If local data is stale (> 5 minutes), fetch from OpenStack
- Update local cache

### Instance Status Sync
- Sync instance status every 1 minute for active instances
- Sync every 5 minutes for stopped instances
- Real-time updates via events when status changes

---

## 🚀 Deployment Considerations

### Environment Variables

```env
# OpenStack Configuration
OPENSTACK_AUTH_URL=https://your-openstack:5000/v3
OPENSTACK_REGION=RegionOne
OPENSTACK_USER_ID=your-user-id
OPENSTACK_USERNAME=your-username
OPENSTACK_PASSWORD=your-password
OPENSTACK_PROJECT_ID=your-project-id
OPENSTACK_PROJECT_NAME=your-project-name
OPENSTACK_DOMAIN_ID=default
OPENSTACK_DOMAIN_NAME=Default

# Reverb Configuration
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

### Queue Configuration
- Use Redis or database queue driver
- Set up supervisor for queue workers
- Configure retry attempts and timeouts

### Scheduled Tasks
Add to `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Sync OpenStack resources every 5 minutes
    $schedule->command('openstack:sync-resources')
        ->everyFiveMinutes()
        ->withoutOverlapping();

    // Sync instance statuses every minute
    $schedule->command('openstack:sync-instance-statuses')
        ->everyMinute()
        ->withoutOverlapping();
}
```

---

## 📊 Monitoring & Logging

### Key Metrics to Monitor
- Instance creation success rate
- Average provisioning time
- Sync job success/failure rates
- OpenStack API response times
- Queue job processing times
- WebSocket connection count

### Logging
- Log all OpenStack API calls
- Log instance lifecycle events
- Log sync operations
- Log errors with full context

---

## 🔐 Security Considerations

1. **Credentials**: Store OpenStack credentials securely in `.env`, never commit
2. **SSH Keys**: Encrypt private keys in database
3. **Passwords**: Hash root passwords if stored
4. **API Access**: Rate limit API endpoints
5. **WebSocket**: Authenticate private channels properly
6. **Customer Isolation**: Ensure customers can only access their own instances

---

## 🧪 Testing Strategy

### Unit Tests
- Test service methods in isolation
- Mock OpenStack API responses
- Test repository methods

### Integration Tests
- Test with real OpenStack (staging environment)
- Test full instance creation flow
- Test sync operations

### Feature Tests
- Test HTTP endpoints
- Test WebSocket events
- Test queue jobs

---

## 📝 Next Steps

1. Review and approve this architecture
2. Set up OpenStack staging environment
3. Begin Phase 1 implementation
4. Set up CI/CD for testing
5. Create project board with tasks

---

## 📚 References

- [php-opencloud/openstack Documentation](https://github.com/php-opencloud/openstack)
- [Laravel Reverb Documentation](https://laravel.com/docs/reverb)
- [Laravel Broadcasting Documentation](https://laravel.com/docs/broadcasting)
- [OpenStack API Documentation](https://docs.openstack.org/)

