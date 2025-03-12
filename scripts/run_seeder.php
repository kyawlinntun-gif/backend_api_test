<?php
require_once __DIR__ . '/../App/Core/Database.php';
require_once __DIR__ . '/../App/Seeder/UserSeeder.php';
require_once __DIR__ . '/../App/Seeder/RoleSeeder.php';
require_once __DIR__ . '/../App/Seeder/PermissionSeeder.php';
require_once __DIR__ . '/../App/Seeder/FeatureSeeder.php';
require_once __DIR__ . '/../App/Seeder/RolePermissionSeeder.php';
require_once __DIR__ . '/../App/Seeder/PermissionFeatureSeeder.php';
require_once __DIR__ . '/../App/Seeder/PostSeeder.php';

use App\Core\Database;
// Run the seeder
$database = new Database();
$db = $database->getConnection();
