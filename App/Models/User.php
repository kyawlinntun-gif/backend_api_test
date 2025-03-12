<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Class User
 * 
 * Represents the user model for interacting with the users table in the database.
 */
class User
{
    /**
     * @var PDO $db The database connection instance.
     */
    private $db;

    /**
     * User constructor.
     * Initializes the database connection.
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
}
