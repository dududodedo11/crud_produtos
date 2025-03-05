<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

/**
 * Classe que excuta todas as seeders na ordem correta.
 */
class MainSeeder extends AbstractSeed
{
    public function run(): void
    {
        // Executar as Seeds:
        exec('php vendor/bin/phinx seed:run -s UsersSeeder');
        exec('php vendor/bin/phinx seed:run -s ProductsSeeder');
    }
}
