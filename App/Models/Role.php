<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Core\Database;

/**
 * Class Role
 * 
 * Represents the Role model for managing roles in the database.
 */
class Role
{
    /**
     * @var PDO Database connection instance.
     */
    private PDO $db;

    /**
     * @var string Role name.
     */
    public string $role_name;

    /**
     * @var string|null Role description (optional).
     */
    public ?string $description;

    /**
     * Role constructor.
     * Initializes the database connection
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Saves a new role to the database.
     * 
     * @return void
     */
    public function save(): void
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO roles (role_name, description) VALUES (:role_name, :description)");
            $stmt->bindParam(':role_name', $this->role_name);
            $stmt->bindParam(':description', $this->description);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error inserting roles: " . $e->getMessage();
        }
    }
}
