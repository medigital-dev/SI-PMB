<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Db001 extends AbstractMigration
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
        $admin = $this->table('admin', ['id' => 'id']);
        $admin->addColumn('username', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addIndex(['username'], ['unique' => true])
            ->create();
        $informasi = $this->table('informasi', ['id' => 'id']);
        $informasi->addColumn('info_id', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addColumn('judul', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('isi', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addIndex(['info_id'], ['unique' => true])
            ->create();
    }
}
