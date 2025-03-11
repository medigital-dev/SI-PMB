<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Db006 extends AbstractMigration
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
        $table = $this->table('forum', ['id' => 'id']);
        $table
            ->addColumn('forum_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('parent_id', 'string', ['limit' => 64, 'null' => true, 'default' => null])
            ->addColumn('nama', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('isi', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('aktif', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addColumn('dibaca', 'boolean', ['default' => false, 'null' => false])
            ->addIndex('parent_id', ['unique' => true])
            ->create()
        ;
    }
}
