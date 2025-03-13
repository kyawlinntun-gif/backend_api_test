<?php

/**
 * Class CreateRoleTable
 * 
 * This class is responsible for handling the creation and deletion fo the roles table in the database.
 */
class CreateRoleTable
{

    /**
     * Creates the `roles` table if it does not exist
     *
     * @param PDO $pdo A PDO instance representing a connection to a database.
     * @return void
     */
    public function up(PDO $pdo): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS roles (
      role_id INT PRIMARY KEY AUTO_INCREMENT,
      role_name VARCHAR(100) UNIQUE NOT NULL,
      description TEXT,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        $pdo->exec($sql);
    }

    /**
     * Drops the `roles` table if it exists.
     *
     * @param PDO $pdo A PDO instance representing a connection to a database.
     * @return void
     */
    public function down(PDO $pdo): void
    {
        $sql = "DROP TABLE IF EXISTS roles";
        $pdo->exec($sql);
    }
}
