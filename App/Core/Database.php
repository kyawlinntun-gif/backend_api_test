<?php

namespace App\Core;

require_once __DIR__ . '/../../config/config.php';

use PDO;
use PDOException;

/**
 * Class Database
 * Handles the database connection using PDO.
 */
class Database
{
    /** @var string Database host  */
    private $host;
    /** @var string Database name */
    private $db_name;
    /** @var string Database username */
    private $username;
    /** @var string Database password */
    private $password;
    /** @var PDO|null PDO connection instance */
    private ?PDO $conn;

    public function __construct(?string $host = null, ?string $db_name = null, ?string $username = null, ?string $password = null)
    {
        $this->host = $host ?? DB_HOST;
        $this->db_name = $db_name ?? DB_NAME;
        $this->username = $username ?? DB_USER;
        $this->password = $password ?? DB_PASS;
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" .  $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }

    /**
     * Get the PDO connection instance.
     *
     * @return PDO|null Returns the PDO connection or null if connection fails.
     */
    public function getConnection(): ?PDO
    {
        return $this->conn;
    }
}
