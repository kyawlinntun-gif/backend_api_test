<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Core\MigrationManager;

$database = new Database();
$pdo = $database->getConnection();

$migrationManager = new MigrationManager($pdo);
$migrationManager->migrate();
