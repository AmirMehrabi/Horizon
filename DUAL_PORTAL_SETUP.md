# Dual Portal System Setup Guide

This document provides a comprehensive guide for setting up and using the dual-portal authentication system with admin and customer portals.

## 🚀 Features Implemented

### ✅ Admin Portal
- **Subdomain**: `hub.aviato.ir`
- **Authentication**: Email/Password based
- **Dashboard**: Existing dashboard from welcome.blade.php
- **Features**: User management, customer oversight, system analytics

### ✅ Customer Portal  
- **Subdomain**: `panel.aviato.ir`
- **Authentication**: Phone number + SMS verification
- **Registration**: Phone-based with SMS verification
- **Dashboard**: Custom dashboard with machine statistics
- **Features**: Resource management, monitoring, billing access

### ✅ Landing Page
- **Available on both subdomains**: Portal selection when needed
- **Responsive Design**: Mobile-friendly interface

## 🛠 Setup Instructions

### 1. Environment Configuration

The system now uses path-based routing instead of subdomain routing for easier deployment. No special domain configuration is needed.

### 2. Database Setup

The migrations have already been run, but if you need to run them again:

```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

### 3. Scheduled Tasks (Optional)

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
- **URL**: `https://hub.aviato.ir/login`
- **Email**: `admin@example.com`
- **Password**: `password`

### Customer Portal
- **Login**: `https://panel.aviato.ir/login`
- **Register**: `https://panel.aviato.ir/register`
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
1. Visit `https://hub.aviato.ir/login`
2. Login with email/password
3. Access existing dashboard at `https://hub.aviato.ir/dashboard`

### Customer Flow
1. **New Users**: Visit `https://panel.aviato.ir/register` → Register with phone number → Verify SMS → Access dashboard
2. **Existing Users**: Visit `https://panel.aviato.ir/login` → Login with phone number → Verify SMS → Access dashboard

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

### Production URLs
- **Admin Portal**: `https://hub.aviato.ir/login`
- **Admin Dashboard**: `https://hub.aviato.ir/dashboard`
- **Customer Login**: `https://panel.aviato.ir/login`
- **Customer Register**: `https://panel.aviato.ir/register`
- **Customer Dashboard**: `https://panel.aviato.ir/dashboard`

### API Endpoints
All authentication endpoints support both web and JSON responses for AJAX usage.

## 🔧 Troubleshooting

### Common Issues

1. **Route [login] not defined error**
   - ✅ **FIXED**: Added fallback login route that redirects based on subdomain
   - Clear route cache: `php artisan route:clear`

2. **Call to undefined method middleware() error**
   - ✅ **FIXED**: Removed deprecated middleware() calls in Laravel 12
   - Middleware is now applied at route level

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
- [ ] Set up HTTPS with SSL certificates (✅ Already done)
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
**Version**: 1.0.1 (Path-based routing)