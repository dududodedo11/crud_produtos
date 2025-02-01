<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("users");
        $table
            ->addColumn("username", "string", ["null" => false])
            ->addColumn("password", "string", ["null" => false])
            ->addColumn("created_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updated_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])

            ->addIndex(["username"], ['unique' => true])

            ->create();
    }
}
