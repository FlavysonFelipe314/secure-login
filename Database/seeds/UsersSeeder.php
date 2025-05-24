<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'access' => 'admin',
                'avatar' => "default_avatar.png",
                'token' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'access' => 'user',
                'avatar' => "default_avatar.png",
                'token' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smithgmail.com',
                'password' => password_hash('securepass', PASSWORD_BCRYPT),
                'access' => 'user',
                'avatar' => "default_avatar.png",
                'token' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->saveData();
    }
}
