<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'username' => "dududodedo11",
                'password' => password_hash("1234", PASSWORD_ARGON2ID)
            ]
        ];

        $users = $this->table("users");
        $users->insert($data)->saveData();
    }
}
