<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db007 extends AbstractMigration
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
        $table = $this->table('logo', ['id' => 'id']);
        $table
            ->addColumn('logo_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('src', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('tema', 'enum', ['values' => ['dark', 'light'], 'null' => false])
            ->addColumn('aktif', 'boolean', ['null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addIndex('logo_id', ['unique' => true])
            ->create()
        ;
    }
}
