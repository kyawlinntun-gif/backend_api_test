# Backend API

## Languages Used
- **Frontend:** HTML, CSS
- **Backend:** PHP (MVC)
- **Database:** MySQL

## Requirements
Ensure you have the following installed:
- PHP >= 8
- MySQL (or any other supported database)

## Installation Steps

### 1. Clone the repository
Clone the project from GitHub:
```sh
git clone <repository_url>
```

### 2. Create a database
Create a new database in MySQL (or your preferred database server).  
Update the `config/config.php` file in the project root to include your database connection settings:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'backend_api');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 3. Migrate the database
Run the following command to set up and reset the required database tables:
```sh
php migrate_table.php
php refresh_migrations.php
```

### 4. Serve the application
Start the development server:
```sh
php -S localhost:90 -t public
```
The application will be accessible at [http://localhost:90](http://localhost:90).
