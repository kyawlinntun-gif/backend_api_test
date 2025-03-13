<?php

namespace App\Seeder;

require_once __DIR__ . '/../Models/User.php';

use App\Models\User;

/**
 * Class UserSeeder
 * 
 * Seeds the users table with initial data.
 */
class UserSeeder
{
    /**
     * Run the seeder to insert user records into the database.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => password_hash('password', PASSWORD_BCRYPT), 'role_id' => 1],
        ];
        foreach ($users as $new_user) {
            $user = new User();
            $user->name = $new_user['name'];
            $user->email = $new_user['email'];
            $user->password = $new_user['password'];
            $user->role_id = $new_user['role_id'];
            $user->save();
        }
    }
}
