<?php

namespace App\Seeder;

require_once __DIR__ . '/../Models/Role.php';

use App\Models\Role;

/**
 * Class RoleSeeder
 * 
 * Seeds the database with initial role data.
 */
class RoleSeeder
{
    /**
     * Runs the seeding process to insert predefined roles into the database.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'admin', 'description' => 'Administrator with full access'],
        ];
        foreach ($roles as $new_role) {
            $role = new Role();
            $role->role_name = $new_role['role_name'];
            $role->description = $new_role['description'];
            $role->save();
        }
    }
}
