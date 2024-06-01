<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'username' => 'admin',
                'password' => '$2y$10$N94kT/LSuCtnFFDKvD6CbeC0M3t4hw1yL6SsxVrk9rlDq1aFyN4T.',
                'created_at' => date('Y-m-d H:i:s', time()),
                'name' => 'Administrator'
            ]
        ];
        $user = $this->table('admin');
        $user->insert($data)->save();
    }
}
