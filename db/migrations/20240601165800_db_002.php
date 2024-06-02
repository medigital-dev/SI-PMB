<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db002 extends AbstractMigration
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
        $berkas = $this->table('berkas', ['id' => 'id']);
        $berkas->addColumn('berkas_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('filename', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('src', 'string', ['limit' => 256, 'null' => false])
            ->addColumn('type', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addIndex('berkas_id', ['unique' => true])
            ->create();
    }
}
