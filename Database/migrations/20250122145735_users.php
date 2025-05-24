<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table("users");
    
        $table->addColumn("name", "string", ["limit" => 255, "null" => false])
              ->addColumn("email", "string", ["limit" => 255, "null" => false]) 
              ->addColumn("password", "string", ["limit" => 255, "null" => false])
              ->addColumn("access", "string", ["limit" => 50, "null" => true])
              ->addColumn("avatar", "string", ["limit" => 255, "null" => true])
              ->addColumn("token", "string", ["limit" => 255, "null" => true])
              ->addColumn("is_verified", "boolean", ["default" => false,"null" => false])
              ->addColumn("created_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", "null" => false])
              ->addColumn("updated_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", "update" => "CURRENT_TIMESTAMP", "null" => false])
              ->addIndex(["email"], ["unique" => true])
              ->create();
    }
    
}
