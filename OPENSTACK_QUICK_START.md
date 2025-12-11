# OpenStack Integration - Quick Start Guide

This is a quick reference guide for implementing the OpenStack integration. Refer to `OPENSTACK_INTEGRATION_ROADMAP.md` for complete details.

## 🚀 Quick Setup Checklist

### Step 1: Install Dependencies

```bash
# Install Reverb (Laravel's WebSocket server)
composer require laravel/reverb

# php-opencloud/openstack is already installed
# Verify: composer show php-opencloud/openstack
```

### Step 2: Configure Environment

Add to `.env`:

```env
# OpenStack Configuration
OPENSTACK_AUTH_URL=http://185.206.95.239:5000/v3
OPENSTACK_REGION=RegionOne
OPENSTACK_USERNAME=admin
OPENSTACK_PASSWORD=supsecret2
OPENSTACK_PROJECT_NAME=admin
OPENSTACK_DOMAIN_NAME=Default
OPENSTACK_DOMAIN_ID=default

# Optional: Override defaults
# OPENSTACK_TIMEOUT=30
# OPENSTACK_CONNECT_TIMEOUT=10
# OPENSTACK_SYNC_INTERVAL=300
# OPENSTACK_SYNC_ENABLED=true
```

**Note:** The auth URL is derived from your Horizon dashboard URL. If the default port 5000 doesn't work, try:
- `http://185.206.95.239/identity/v3`
- `http://185.206.95.239:35357/v3` (admin port)

# Reverb
REVERB_APP_ID=horizon-app
REVERB_APP_KEY=your-secret-key
REVERB_APP_SECRET=your-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

### Step 3: Publish Reverb Configuration

```bash
php artisan reverb:install
php artisan vendor:publish --tag=reverb-config
```

### Step 4: Create Database Migrations

Run these commands to create migration files (you'll need to create them manually based on the roadmap):

```bash
php artisan make:migration create_openstack_instances_table
php artisan make:migration create_openstack_flavors_table
php artisan make:migration create_openstack_images_table
php artisan make:migration create_openstack_networks_table
php artisan make:migration create_openstack_subnets_table
php artisan make:migration create_openstack_key_pairs_table
php artisan make:migration create_openstack_security_groups_table
php artisan make:migration create_openstack_instance_networks_table
php artisan make:migration create_openstack_instance_security_groups_table
php artisan make:migration create_openstack_sync_jobs_table
php artisan make:migration create_openstack_instance_events_table
```

## 📁 Directory Structure

```
app/
├── Models/
│   ├── OpenStackInstance.php
│   ├── OpenStackFlavor.php
│   ├── OpenStackImage.php
│   ├── OpenStackNetwork.php
│   ├── OpenStackSubnet.php
│   ├── OpenStackKeyPair.php
│   ├── OpenStackSecurityGroup.php
│   └── OpenStackInstanceEvent.php
├── Services/
│   └── OpenStack/
│       ├── OpenStackConnectionService.php
│       ├── OpenStackInstanceService.php
│       └── OpenStackSyncService.php
├── Repositories/
│   ├── InstanceRepository.php
│   ├── FlavorRepository.php
│   └── NetworkRepository.php
├── Jobs/
│   ├── ProvisionOpenStackInstance.php
│   ├── SyncOpenStackResources.php
│   └── SyncInstanceStatus.php
├── Events/
│   ├── InstanceCreated.php
│   ├── InstanceBuilding.php
│   ├── InstanceActive.php
│   └── InstanceStatusChanged.php
└── Console/
    └── Commands/
        ├── SyncOpenStackResources.php
        └── SyncInstanceStatuses.php
```

## 🔑 Key Implementation Points

### 1. Instance Creation Flow

```
User submits form
    ↓
ServerController::store()
    ↓
OpenStackInstanceService::create()
    ↓
Create record in DB (status: pending)
    ↓
Dispatch ProvisionOpenStackInstance job
    ↓
Job provisions in OpenStack
    ↓
Update DB with OpenStack server ID
    ↓
Broadcast events via Reverb
    ↓
Frontend receives real-time updates
```

### 2. Resource Sync Flow

```
Scheduled Command (every 5 min)
    ↓
OpenStackSyncService::syncFlavors()
    ↓
Fetch from OpenStack API
    ↓
Compare with local DB
    ↓
Update/Create/Delete records
    ↓
Log sync results
```

### 3. Real-Time Updates Flow

```
Instance status changes in OpenStack
    ↓
Sync job detects change
    ↓
Update local DB
    ↓
Fire InstanceStatusChanged event
    ↓
Broadcast via Reverb
    ↓
Frontend WebSocket receives update
    ↓
Update UI in real-time
```

## 🎯 Phase 1 Priorities

1. **Database Setup** - Create all tables
2. **OpenStack Connection** - Test connectivity
3. **Flavor/Image/Network Sync** - Get data from OpenStack
4. **Instance Creation** - Local-first creation
5. **Basic Provisioning** - Create instance in OpenStack

## 📝 Code Snippets

### Basic Service Structure

```php
// app/Services/OpenStack/OpenStackConnectionService.php
namespace App\Services\OpenStack;

use OpenStack\OpenStack;

class OpenStackConnectionService
{
    private ?OpenStack $client = null;

    public function getClient(): OpenStack
    {
        if ($this->client === null) {
            $this->client = new OpenStack([
                'authUrl' => config('openstack.auth_url'),
                'region' => config('openstack.region'),
                'user' => [
                    'id' => config('openstack.user_id'),
                    'name' => config('openstack.username'),
                    'password' => config('openstack.password'),
                    'domain' => ['id' => config('openstack.domain_id')],
                ],
                'scope' => [
                    'project' => [
                        'id' => config('openstack.project_id'),
                        'domain' => ['id' => config('openstack.domain_id')],
                    ],
                ],
            ]);
        }

        return $this->client;
    }

    public function getNovaService()
    {
        return $this->getClient()->computeV2();
    }

    public function getNeutronService()
    {
        return $this->getClient()->networkingV2();
    }

    public function getGlanceService()
    {
        return $this->getClient()->imageV2();
    }
}
```

### Basic Model Structure

```php
// app/Models/OpenStackInstance.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OpenStackInstance extends Model
{
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'name',
        'openstack_server_id',
        'status',
        'flavor_id',
        'image_id',
        // ... other fields
    ];

    protected $casts = [
        'metadata' => 'array',
        'auto_billing' => 'boolean',
        'synced_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function flavor(): BelongsTo
    {
        return $this->belongsTo(OpenStackFlavor::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(OpenStackImage::class);
    }

    public function networks(): BelongsToMany
    {
        return $this->belongsToMany(OpenStackNetwork::class, 'openstack_instance_networks')
            ->withPivot(['fixed_ip', 'floating_ip', 'is_primary'])
            ->withTimestamps();
    }
}
```

## 🧪 Testing OpenStack Connection

Create a test command:

```bash
php artisan make:command TestOpenStackConnection
```

```php
// app/Console/Commands/TestOpenStackConnection.php
public function handle()
{
    try {
        $service = app(OpenStackConnectionService::class);
        $nova = $service->getNovaService();
        
        $servers = $nova->listServers();
        $this->info('✅ Connected to OpenStack!');
        $this->info('Found ' . count($servers) . ' servers');
        
        // Test flavors
        $flavors = $nova->listFlavors();
        $this->info('Found ' . count($flavors) . ' flavors');
        
    } catch (\Exception $e) {
        $this->error('❌ Connection failed: ' . $e->getMessage());
    }
}
```

Run: `php artisan test:openstack-connection`

## 🚦 Next Actions

1. Review the full roadmap document
2. Set up OpenStack credentials
3. Create database migrations
4. Implement OpenStackConnectionService
5. Test connection
6. Begin Phase 1 implementation

---

For complete details, see `OPENSTACK_INTEGRATION_ROADMAP.md`.

