# Backend API

## Languages Used
- **Frontend:** HTML, CSS, Tailwind CSS
- **Backend:** PHP (MVC)
- **Database:** MySQL

## Requirements
Ensure you have the following installed:
- PHP >= 8
- MySQL (or any other supported database)

## Installation Steps

### 1. Clone the repository
Clone the project from GitHub using the alpha branch:
```sh
git clone -b alpha https://github.com/kyawlinntun-gif/backend_api_test.git
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
In scripts' folder
```sh
php migrate_table.php
php refresh_migrations.php # If you need to delete all data in the database.
```

### 4. Run the seeder
Execute the command below to create the default admin and role:
In scripts' folder
```sh
php run_seeder.php
```

### 5. Serve the application
Start the development server:
```sh
php -S localhost:90 -t public
```
The application will be accessible at [http://localhost:90](http://localhost:90).

## Features

### 1.1 Home Page

### 1.2 Admin User (Logged-in User)
#### 1.2.1 Admin User can perform CRUD operations on JSONPlaceholder Post API Data

### 1.3 Normal User (Not Logged-in User)
#### 1.3.1 Can view all posts and detailed JSONPlaceholder post API Data

### 1.4 Role Management
#### 1.4.1 Assign roles to users

### 1.5 JSONPlaceholder Posts Page 
#### 1.5.1 Manage JSONPlaceholder Post API data with CRUD operations.

## Debug
### 1. VPN Errors
#### 1.1 Sometimes you need vpn or reload the browser to get JSONPlaceholder Api Data.
