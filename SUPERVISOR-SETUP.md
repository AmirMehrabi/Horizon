# Supervisor Setup Guide for Laravel Queue Worker and Scheduler

## Prerequisites

- Redis is installed and running (verified with `redis-cli ping`)
- Supervisor is installed
- Laravel application is configured with `QUEUE_CONNECTION=redis` in `.env`

## Setup Instructions

### 1. Clear Laravel Config Cache

First, clear the config cache to ensure Redis queue connection is used:

```bash
cd /var/www/html/horizon
php artisan config:clear
php artisan cache:clear
```

### 2. Install Supervisor Configuration Files

Copy the supervisor configuration files to `/etc/supervisor/conf.d/`:

```bash
sudo cp /var/www/html/horizon/horizon-queue-worker.conf /etc/supervisor/conf.d/
sudo cp /var/www/html/horizon/horizon-scheduler.conf /etc/supervisor/conf.d/
```

Or use the setup script:

```bash
sudo bash /var/www/html/horizon/setup-supervisor.sh
```

### 3. Create Log Directory (if needed)

```bash
mkdir -p /var/www/html/horizon/storage/logs
chown -R ammir:ammir /var/www/html/horizon/storage/logs
```

### 4. Reload Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
```

### 5. Start the Services

```bash
sudo supervisorctl start horizon-queue-worker:*
sudo supervisorctl start horizon-scheduler
```

### 6. Check Status

```bash
sudo supervisorctl status
```

You should see:
- `horizon-queue-worker:horizon-queue-worker_00` - RUNNING
- `horizon-queue-worker:horizon-queue-worker_01` - RUNNING
- `horizon-scheduler` - RUNNING

## Scheduler Cronjob (Alternative to Supervisor)

If you prefer to use cron instead of supervisor for the scheduler, add this to your crontab:

```bash
crontab -e
```

Add this line:
```
* * * * * cd /var/www/html/horizon && php artisan schedule:run >> /dev/null 2>&1
```

**Note:** If using supervisor for scheduler, you don't need the cronjob. The `schedule:work` command runs continuously.

## Useful Commands

### Supervisor Commands

```bash
# Check status
sudo supervisorctl status

# Restart queue worker
sudo supervisorctl restart horizon-queue-worker:*

# Restart scheduler
sudo supervisorctl restart horizon-scheduler

# Stop services
sudo supervisorctl stop horizon-queue-worker:*
sudo supervisorctl stop horizon-scheduler

# View logs
tail -f /var/www/html/horizon/storage/logs/queue-worker.log
tail -f /var/www/html/horizon/storage/logs/scheduler.log

# Reload supervisor after config changes
sudo supervisorctl reread
sudo supervisorctl update
```

### Laravel Queue Commands

```bash
# Check queue status
php artisan queue:monitor redis:openstack-provisioning,default

# View failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

## Configuration Details

### Queue Worker Configuration

- **Processes:** 2 workers (numprocs=2)
- **Queues:** `openstack-provisioning`, `default`
- **Retries:** 3 attempts
- **Timeout:** 60 seconds per job
- **Max Time:** 3600 seconds (1 hour) per worker process
- **Sleep:** 3 seconds when no jobs available

### Scheduler Configuration

- Uses `schedule:work` which runs continuously
- Executes scheduled tasks defined in `routes/console.php`
- Currently scheduled: OpenStack resource sync every 5 minutes

## Troubleshooting

### Queue Worker Not Processing Jobs

1. Check if Redis is running: `redis-cli ping`
2. Verify queue connection: `php artisan config:show queue.default` (should be 'redis')
3. Check supervisor logs: `tail -f /var/www/html/horizon/storage/logs/queue-worker.log`
4. Check supervisor status: `sudo supervisorctl status`

### Jobs Stuck in Queue

1. Check Redis queue: `redis-cli LLEN laravel_database_queues:openstack-provisioning`
2. Restart workers: `sudo supervisorctl restart horizon-queue-worker:*`
3. Check for failed jobs: `php artisan queue:failed`

### Scheduler Not Running

1. Check supervisor status: `sudo supervisorctl status horizon-scheduler`
2. Check logs: `tail -f /var/www/html/horizon/storage/logs/scheduler.log`
3. Verify scheduled tasks: `php artisan schedule:list`

## Monitoring

Monitor the queue workers and scheduler:

```bash
# Watch supervisor status
watch -n 1 'sudo supervisorctl status'

# Monitor queue worker logs
tail -f /var/www/html/horizon/storage/logs/queue-worker.log

# Monitor scheduler logs
tail -f /var/www/html/horizon/storage/logs/scheduler.log
```

