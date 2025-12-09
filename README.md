# Dual Portal System Setup Guide

This document provides a comprehensive guide for setting up and using the dual-portal authentication system with admin and customer portals.

## 🚀 Features Implemented

### ✅ Admin Portal
- **Subdomain**: `admin.yourdomain.com`
- **Authentication**: Email/Password based
- **Dashboard**: Existing dashboard from welcome.blade.php
- **Features**: User management, customer oversight, system analytics

### ✅ Customer Portal  
- **Subdomain**: `customer.yourdomain.com`
- **Authentication**: Phone number + SMS verification
- **Registration**: Phone-based with SMS verification
- **Dashboard**: Custom dashboard with machine statistics
- **Features**: Resource management, monitoring, billing access

### ✅ Landing Page
- **Main Domain**: `yourdomain.com`
- **Portal Selection**: Choose between Admin and Customer portals
- **Responsive Design**: Mobile-friendly interface

## 🛠 Setup Instructions

### 1. Environment Configuration

Add the following to your `.env` file:

```env
# Subdomain Configuration
ADMIN_SUBDOMAIN=admin
CUSTOMER_SUBDOMAIN=customer
APP_DOMAIN=localhost
FORCE_HTTPS=false

# Database (if not already configured)
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/horizon/database/database.sqlite
```

### 2. Domain Configuration

For local development, add these entries to your `/etc/hosts` file:

```
127.0.0.1 localhost
127.0.0.1 admin.localhost
127.0.0.1 customer.localhost
```

For production, configure your DNS to point subdomains to your server:
- `admin.yourdomain.com` → Your server IP
- `customer.yourdomain.com` → Your server IP

### 3. Web Server Configuration

#### Apache (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com *.yourdomain.com;
    root /var/www/html/horizon/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 4. Database Setup

The migrations have already been run, but if you need to run them again:

```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

### 5. Scheduled Tasks (Optional)

Add to your crontab for automatic cleanup of expired verification codes:

```bash
* * * * * cd /var/www/html/horizon && php artisan schedule:run >> /dev/null 2>&1
```

Then add this to `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('verification:cleanup')->hourly();
}
```

## 🔐 Default Credentials

### Admin Portal
- **URL**: `http://admin.localhost/login`
- **Email**: `admin@example.com`
- **Password**: `password`

### Customer Portal
- **URL**: `http://customer.localhost/register`
- **Registration**: Use any phone number (codes are logged for development)

## 📱 SMS Verification

### Development Mode
- Verification codes are logged in `storage/logs/laravel.log`
- Check the logs to find the 6-digit verification code
- Codes expire after 15 minutes
- Maximum 3 attempts per code

### Production Setup
To implement real SMS sending, modify the `CustomerVerificationCode::generateCode()` method to integrate with:
- Twilio
- AWS SNS
- Vonage (Nexmo)
- Or any other SMS provider

## 🎨 UI Customization

### Color Scheme
The system uses a consistent blue color scheme matching your existing dashboard:
- Primary: `bg-blue-600` / `text-blue-600`
- Secondary: `bg-gray-50` / `text-gray-600`
- Success: `bg-green-600` / `text-green-600`

### Responsive Design
- Mobile-first approach
- Sidebar collapses on mobile
- Touch-friendly buttons and forms

## 🔄 Portal Flow

### Admin Flow
1. Visit main site (`localhost`)
2. Click "Choose Portal" → Select "Admin Portal"
3. Login with email/password
4. Access existing dashboard

### Customer Flow
1. Visit main site (`localhost`)
2. Click "Choose Portal" → Select "Customer Portal"
3. **New Users**: Register with phone number → Verify SMS → Access dashboard
4. **Existing Users**: Login with phone number → Verify SMS → Access dashboard

## 📊 Database Schema

### Customers Table
```sql
- id (UUID, Primary Key)
- first_name, last_name
- phone_number (Unique)
- email (Optional)
- company_name (Optional)
- address, city, state, postal_code, country
- status (pending, active, inactive, suspended)
- phone_verified_at
- last_login_at
- preferences (JSON)
- notes
- timestamps, soft_deletes
```

### Customer Verification Codes Table
```sql
- id (Auto-increment)
- phone_number
- code (6 digits)
- type (registration, login, password_reset)
- verified, verified_at
- expires_at
- attempts, max_attempts
- ip_address, user_agent
- timestamps
```

## 🛡 Security Features

### Authentication
- Multi-guard authentication (web for admin, customer for customers)
- Phone-based authentication for customers
- SMS verification with expiration and attempt limits
- Session management with proper logout

### Data Protection
- UUID primary keys for customers
- Soft deletes for data retention
- Input validation and sanitization
- CSRF protection on all forms

### Rate Limiting
- Verification code attempts (3 max)
- Time-based code expiration (15 minutes)
- Automatic cleanup of expired codes

## 🧪 Testing URLs

### Local Development
- **Main Site**: `http://localhost`
- **Portal Selection**: `http://localhost/choose-portal`
- **Admin Login**: `http://admin.localhost/login`
- **Customer Register**: `http://customer.localhost/register`
- **Customer Login**: `http://customer.localhost/login`

### API Endpoints
All authentication endpoints support both web and JSON responses for AJAX usage.

## 🔧 Troubleshooting

### Common Issues

1. **Subdomain not working**
   - Check `/etc/hosts` file
   - Verify web server configuration
   - Ensure DNS is properly configured

2. **SMS codes not appearing**
   - Check `storage/logs/laravel.log`
   - Verify phone number format
   - Ensure database connection is working

3. **Authentication redirects**
   - Check guard configuration in `config/auth.php`
   - Verify middleware is properly applied
   - Check session configuration

4. **Database errors**
   - Run `php artisan migrate`
   - Check database permissions
   - Verify `.env` database configuration

### Debug Commands
```bash
# Check routes
php artisan route:list

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check logs
tail -f storage/logs/laravel.log
```

## 🚀 Production Deployment

### Security Checklist
- [ ] Change default admin password
- [ ] Configure real SMS provider
- [ ] Set up HTTPS with SSL certificates
- [ ] Configure proper session security
- [ ] Set up database backups
- [ ] Configure log rotation
- [ ] Set up monitoring and alerts

### Performance Optimization
- [ ] Configure Redis for sessions/cache
- [ ] Set up queue workers for SMS sending
- [ ] Optimize database indexes
- [ ] Configure CDN for static assets
- [ ] Set up application monitoring

## 📞 Support

For issues or questions:
1. Check the troubleshooting section
2. Review Laravel logs
3. Verify configuration settings
4. Test with different browsers/devices

---

**System Status**: ✅ Fully Functional
**Last Updated**: December 2025
**Version**: 1.0.0
