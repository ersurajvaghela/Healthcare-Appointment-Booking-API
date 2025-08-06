<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

___


# Healthcare Appointment Booking API

A comprehensive RESTful API built with Laravel for managing healthcare appointments. This production-ready application allows users to book, view, and cancel appointments with healthcare professionals.

## Features

- 🔐 **User Authentication**: Token-based authentication using Laravel Sanctum
- 👨‍⚕️ **Healthcare Professional Management**: View available doctors and specialists
- 📅 **Appointment Booking**: Book appointments with conflict detection
- ⏰ **Business Rules**: 24-hour cancellation policy, business hours validation
- 🔒 **Security**: Users can only access their own appointments
- 📊 **Comprehensive Testing**: Unit and feature tests included
- 📚 **API Documentation**: Clear endpoint documentation

## Tech Stack

- **Backend**: PHP 8.2, Laravel 10
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum
- **Testing**: PHPUnit
- **Web Server**: Apache/Nginx

## Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Apache/Nginx web server
- Git

### PHP Extensions Required

Ensure the following PHP extensions are installed:
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd healthcare-appointment-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit the `.env` file with your database and application settings:

```env
APP_NAME="Healthcare Appointment API"
APP_ENV=local
APP_KEY=base64:your-generated-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthcare_appointments
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
```

### 5. Database Setup

#### Create Database

```bash
# Log into MySQL
mysql -u root -p

# Create database
CREATE DATABASE healthcare_appointments;

# Create a dedicated user (optional but recommended)
CREATE USER 'healthcare_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON healthcare_appointments.* TO 'healthcare_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Run Migrations and Seeders

```bash
# Run database migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed

# Or run both commands together
php artisan migrate:fresh --seed
```

### 6. Set Permissions

```bash
# Set storage and cache permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# If using Apache, ensure the web server can write to these directories
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
```

### 7. Start the Development Server

```bash
# Start Laravel's built-in development server
php artisan serve

# The API will be available at: http://localhost:8000/api
```

Alternatively, configure your web server (Apache/Nginx) to point to the `public` directory.

## Web Server Configuration

### Apache Configuration

Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName healthcare-api.local
    DocumentRoot /path/to/healthcare-appointment-api/public

    <Directory /path/to/healthcare-appointment-api/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/healthcare-api_error.log
    CustomLog ${APACHE_LOG_DIR}/healthcare-api_access.log combined
</VirtualHost>
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name healthcare-api.local;
    root /path/to/healthcare-appointment-api/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/register` | Register a new user | No |
| POST | `/api/login` | Login user | No |
| POST | `/api/logout` | Logout user | Yes |

### Healthcare Professionals

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/healthcare-professionals` | List all active professionals | Yes |
| GET | `/api/healthcare-professionals/{id}` | Get specific professional | Yes |

### Appointments

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/appointments` | List user's appointments | Yes |
| POST | `/api/appointments` | Book new appointment | Yes |
| GET | `/api/appointments/{id}` | Get specific appointment | Yes |
| PATCH | `/api/appointments/{id}/cancel` | Cancel appointment | Yes |
| PATCH | `/api/appointments/{id}/complete` | Mark as completed | Yes |

## API Usage Examples

### 1. Register a User

```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Response:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123xyz..."
}
```

### 2. Login

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123xyz..."
}
```

### 3. List Healthcare Professionals

```bash
curl -X GET http://localhost:8000/api/healthcare-professionals \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
{
  "message": "Healthcare professionals retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Dr. Sarah Johnson",
      "specialty": "Cardiology",
      "email": "sarah.johnson@hospital.com",
      "phone": "+1-555-0101",
      "is_active": true
    }
  ]
}
```

### 4. Book an Appointment

```bash
curl -X POST http://localhost:8000/api/appointments \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "healthcare_professional_id": 1,
    "appointment_start_time": "2024-12-25T10:00:00Z",
    "appointment_end_time": "2024-12-25T11:00:00Z",
    "notes": "Regular checkup"
  }'
```

**Response:**
```json
{
  "message": "Appointment booked successfully",
  "data": {
    "id": 1,
    "user_id": 1,
    "healthcare_professional": {
      "id": 1,
      "name": "Dr. Sarah Johnson",
      "specialty": "Cardiology"
    },
    "appointment_start_time": "2024-12-25T10:00:00Z",
    "appointment_end_time": "2024-12-25T11:00:00Z",
    "status": "booked",
    "notes": "Regular checkup",
    "can_be_cancelled": true
  }
}
```

### 5. List User Appointments

```bash
curl -X GET http://localhost:8000/api/appointments \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 6. Cancel an Appointment

```bash
curl -X PATCH http://localhost:8000/api/appointments/1/cancel \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Business Rules

### Appointment Booking
- Appointments must be scheduled for future dates
- Business hours: 9 AM - 5 PM, Monday-Friday
- Minimum duration: 30 minutes
- Maximum duration: 2 hours
- No double booking for healthcare professionals

### Appointment Cancellation
- Must be cancelled at least 24 hours before appointment time
- Only the appointment owner can cancel
- Cannot cancel completed or already cancelled appointments

### Security
- Users can only view/modify their own appointments
- Token-based authentication required for all protected endpoints
- Input validation and sanitization

## Testing

### Prerequisites for Testing

Ensure you have a separate test database configured:

```bash
# In your .env file, add:
DB_DATABASE_TEST=healthcare_appointments_test

# Create the test database
mysql -u root -p -e "CREATE DATABASE healthcare_appointments_test;"
```

### Run All Tests

```bash
php artisan test
```

### Run Specific Test Suites

```bash
# Feature tests
php artisan test --testsuite=Feature

# Unit tests
php artisan test --testsuite=Unit

# Run tests with coverage (requires Xdebug)
php artisan test --coverage-html coverage
```

### Generate Sample Data for Testing

```bash
# Generate sample users and appointments
php artisan app:generate-sample-data --users=20 --appointments=100
```

## Database Schema

### Users Table
- `id` (Primary Key)
- `name` (String, 255 chars)
- `email` (Unique String, 255 chars)
- `password` (Hashed String)
- `email_verified_at` (Timestamp, nullable)
- `remember_token` (String, nullable)
- `created_at`, `updated_at` (Timestamps)

### Healthcare Professionals Table
- `id` (Primary Key)
- `name` (String, 255 chars)
- `specialty` (String, 255 chars)
- `email` (Unique String, 255 chars)
- `phone` (String, nullable)
- `is_active` (Boolean, default: true)
- `created_at`, `updated_at` (Timestamps)

### Appointments Table
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `healthcare_professional_id` (Foreign Key → healthcare_professionals.id)
- `appointment_start_time` (DateTime)
- `appointment_end_time` (DateTime)
- `status` (Enum: 'booked', 'completed', 'cancelled')
- `notes` (Text, nullable)
- `created_at`, `updated_at` (Timestamps)

**Indexes:**
- `healthcare_professional_id, appointment_start_time`
- `user_id, status`

## Project Structure

```
healthcare-appointment-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/     # API Controllers
│   │   ├── Exceptions/          # Exceptions
│   │   ├── Requests/           # Form Request Classes
│   │   ├── Resources/          # API Resources
│   │   ├── Traits/            #  Custom Traits
│   │   │   ├── Controllers/BaseControllerTraits.php    # Controllers Traits
│   │   │   ├── Models/ModelTraits.php    # Models Traits
│   │   │   ├── Requests/RequestTraits.php    # Requests Traits
│   │   ├── Services/           # Business Logic Services
│   │   └── Middleware/         # Custom Middleware
│   ├── Models/                 # Eloquent Models
│   └── Console/Commands/      # Custom Artisan Commands
├── bootstrap/                 # Application Bootstrap
├── config/                    # Configuration Files
├── database/
│   ├── factories/            # Model Factories
│   ├── migrations/           # Database Migrations
│   └── seeders/             # Database Seeders
├── public/                   # Web Server Document Root
├── resources/               # Views, Language Files
├── routes/
│   └── api.php             # API Routes
│   └── web.php             # API Routes
├── storage/                # Logs, Cache, Sessions
├── tests/
│   ├── Feature/           # Integration Tests
│   └── Unit/             # Unit Tests
├── vendor/               # Composer Dependencies
├── .env.example         # Environment Template
├── composer.json        # PHP Dependencies
├── phpunit.xml         # Test Configuration
└── artisan            # Laravel Command Line Interface
```

## Performance Considerations

- **Database Indexing**: Indexes on frequently queried columns
- **Pagination**: Large datasets are paginated (10 items per page)
- **Eager Loading**: Prevents N+1 query problems
- **Query Optimization**: Efficient conflict detection queries
- **Caching**: File-based caching for configuration and routes

## Security Features

- **CSRF Protection**: Built-in CSRF protection
- **SQL Injection Prevention**: Eloquent ORM with prepared statements
- **Input Validation**: Comprehensive validation rules
- **Password Security**: Bcrypt hashing with salt
- **Token Authentication**: Secure API token system
- **Rate Limiting**: Configurable rate limiting (60 requests/minute)

## Maintenance Commands

### Clear Caches
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Or clear all at once
php artisan optimize:clear
```

### Optimize for Production
```bash
# Cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer autoloader
composer install --optimize-autoloader --no-dev
```

### Database Maintenance
```bash
# Reset database with fresh data
php artisan migrate:fresh --seed

# Run only pending migrations
php artisan migrate

# Rollback last migration batch
php artisan migrate:rollback
```

## Troubleshooting

### Common Issues

1. **Permission Denied Errors**
   ```bash
   sudo chown -R $USER:www-data storage
   sudo chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Issues**
   - Verify database credentials in `.env`
   - Ensure MySQL service is running
   - Check if database exists

3. **Composer Issues**
   ```bash
   composer clear-cache
   composer install
   ```

4. **Token Authentication Issues**
   - Ensure Sanctum is properly configured
   - Check token format in Authorization header
   - Verify token hasn't expired

### Log Files

Application logs are stored in `storage/logs/`:
```bash
# View latest log entries
tail -f storage/logs/laravel.log
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Write tests for new functionality
4. Ensure all tests pass (`php artisan test`)
5. Commit your changes (`git commit -m 'Add amazing feature'`)
6. Push to the branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

### Code Style

This project follows PSR-12 coding standards. Use the following tools to maintain code quality:

```bash
# Install PHP CS Fixer (optional)
composer require --dev friendsofphp/php-cs-fixer

# Fix code style issues
vendor/bin/php-cs-fixer fix
```

## Future Enhancements

If given more time, the following features could be implemented:

1. **Enhanced Notifications**
   - Email appointment confirmations and reminders
   - SMS notifications integration
   - Push notifications for mobile apps

2. **Advanced Scheduling**
   - Recurring appointments
   - Provider availability management
   - Appointment rescheduling
   - Waiting list functionality

3. **Reporting & Analytics**
   - Appointment statistics
   - Provider performance metrics
   - Usage analytics dashboard
   - Export functionality (CSV, PDF)

4. **Advanced Features**
   - Multi-language support
   - Payment integration
   - Insurance verification
   - Patient medical history
   - Telemedicine support

5. **Performance & Scalability**
   - Redis caching
   - Queue system for background jobs
   - API response caching
   - Database read replicas

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For questions, issues, or support:

- **Email**: [vaghelasuraj@ymail.com](mailto:vaghelasuraj@ymail.com)
- **Documentation**: Check this README and inline code comments
- **Issues**: Open an issue on the repository

## Changelog

### Version 1.0.0
- Initial release
- User authentication system
- Healthcare professional management
- Appointment booking and management
- Comprehensive test suite
- API documentation

---

**Note**: This application is designed for development and testing purposes. For production deployment, ensure proper security configurations, SSL certificates, and environment-specific optimizations are implemented.