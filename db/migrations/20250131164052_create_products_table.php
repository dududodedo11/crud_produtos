<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("products");
        $table
            ->addColumn("user_id", "integer", ['null' => false, 'signed' => false])
            ->addColumn("name", "string", ['null' => false])
            ->addColumn("quantity", "integer", ['null' => false, "signed" => false])
            ->addColumn("code", "string", ['null' => false])
            ->addColumn("description", "text")
            ->addColumn("created_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updated_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])

            ->addIndex(["code"], ['unique' => true])
            ->addForeignKey('user_id', 'users', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'constraint' => 'fk_products_user_id'
            ])

            ->create();
    }
}
