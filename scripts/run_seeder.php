<?php
require_once __DIR__ . '/../App/Core/Database.php';
require_once __DIR__ . '/../App/Seeder/RoleSeeder.php';
require_once __DIR__ . '/../App/Seeder/UserSeeder.php';

use App\Core\Database;
use App\Seeder\RoleSeeder;
use App\Seeder\UserSeeder;

// Run the seeder
$database = new Database();
$db = $database->getConnection();
$roleSeeder = new RoleSeeder();
$roleSeeder->run();
$userSeeder = new UserSeeder();
$userSeeder->run();
