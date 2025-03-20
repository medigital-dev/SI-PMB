<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db004 extends AbstractMigration
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
        $tabel =  $this->table('event', ['id' => 'id']);
        $tabel->addColumn('event_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('tanggal', 'datetime', ['null' => false])
            ->addColumn('status', 'boolean', ['default' => 1, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addIndex('event_id', ['unique' => true])
            ->create();
    }
}
