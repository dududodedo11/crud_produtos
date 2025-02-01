<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ProductsSeeder extends AbstractSeed
{

    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 015 BAMBU",
                'code' => "6000",
                'quantity' => 18,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 020 BAMBU",
                'code' => "6001",
                'quantity' => 0,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002",
                'quantity' => 30,
            ],
        ];

        $products = $this->table("products");
        $products->insert($data)->saveData();
    }
}
