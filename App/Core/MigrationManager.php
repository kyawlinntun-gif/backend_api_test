<?php

namespace App\Core;

use PDO;

/**
 * Class MigrationManager
 * 
 * Manages database migrations, including running, rolling back, and refreshing migrations
 */
class MigrationManager
{
    /** @var PDO Database connection instance */
    private PDO $pdo;
    /** @var string Path to the migration files */
    private string $migrationPath;
    /** @var array List of migration files to execute */
    public array $migrateFiles;

    /**
     * MigrationManager constructor.
     *
     * @param PDO $pdo The database connection instance.
     * @param string|null $migrationPath The path where migration files are stored.
     * @param array|null $migrateFiles List of migration file names.
     */
    public function __construct(PDO $pdo, ?string $migrationPath = null, ?array $migrateFiles = null)
    {
        $this->pdo = $pdo;
        $this->migrationPath = $migrationPath ?? __DIR__ . '/../../migrations/';
        $this->migrateFiles = $migrateFiles ?? [

        ];
    }

    /**
     * Run all migrations in the specified order.
     *
     * @return void
     */
    public function migrate(): void
    {
        foreach ($this->migrateFiles as $file) {
            if ($file !== '.' && $file !== '..') {
                include_once $this->migrationPath . $file;
                $className = pathinfo($file, PATHINFO_FILENAME);
                $migration = new $className();
                $migration->up($this->pdo);
            }
        }
    }

    /**
     * Rollback all migrations in reverse order.
     *
     * @return void
     */
    public function rollback(): void
    {
        // For foreign key dropdown
        $migrateFiles = array_reverse($this->migrateFiles);

        foreach ($migrateFiles as $file) {
            if ($file !== '.' && $file !== '..') {
                include_once $this->migrationPath . $file;
                $className = pathinfo($file, PATHINFO_FILENAME);
                $migration = new $className();
                $migration->down($this->pdo);
            }
        }
    }

    /**
     * Regfresh migrations by rolling back and then re-running all migrations.
     *
     * @return void
     */
    public function refresh()
    {
        // Rollback all migrations
        $this->rollback();
        // Re-run all migrations
        $this->migrate();
    }
}
