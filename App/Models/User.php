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
     * @var string $name The name of the user.
     */
    public string $name;

    /**
     * @var string $email The email address of the user.
     */
    public string $email;

    /**
     * @var string $password The hashed password of the user.
     */
    public string $password;

    /**
     * @var int $role_id The role ID assigned to the user.
     */
    public int $role_id;

    /**
     * User constructor.
     * Initializes the database connection.
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Saves a new user record in the database.
     *
     * @return void
     */
    public function save(): void
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)");
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role_id', $this->role_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error inserting users: " . $e->getMessage();
        }
    }
}
