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
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6007",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6008",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "600",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "660",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "602",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60026",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-5",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60024",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60022-3",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-54",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "600223",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-0",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60584",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60036",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6023",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6045",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-02",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-09",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-44",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "60080",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "6002-30",
                'quantity' => 30,
            ],
            [
                'user_id' => 1,
                'name' => "FRALDEIRA 025 BAMBU",
                'code' => "65426",
                'quantity' => 30,
            ],
        ];

        $products = $this->table("products");
        $products->insert($data)->saveData();
    }
}
