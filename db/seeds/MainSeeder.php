<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class MainSeeder extends AbstractSeed
{
    public function run(): void
    {
        exec('php vendor/bin/phinx seed:run -s UsersSeeder');
        exec('php vendor/bin/phinx seed:run -s ProductsSeeder');
    }
}
