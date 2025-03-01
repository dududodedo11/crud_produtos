<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateQuerysGeneratorTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("querys_generator");
        $table
            ->addColumn("user_id", "integer", ['null' => false, 'signed' => false])
            ->addColumn("name", "string", ['null' => false])
            ->addColumn("query", "text", ['null' => false])
            ->addColumn("created_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updated_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])

            ->addForeignKey('user_id', 'users', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
                'constraint' => 'fk_querys_generator_user_id'
            ])

            ->create();
    }
}
