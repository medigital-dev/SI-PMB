<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Db008 extends AbstractMigration
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
        $table = $this->table('header', ['id' => 'id']);
        $table
            ->addColumn('header_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('isi', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('updated_at', 'datetime', ['null' => false])
            ->addIndex('header_id', ['unique' => true,])
            ->create()
        ;
    }
}
