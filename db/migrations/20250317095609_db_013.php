<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Db013 extends AbstractMigration
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
    public function up(): void
    {
        $table = $this->table('syarat');
        if (!$table->exists())
            $table
                ->addColumn('syarat_id', 'string', ['limit' => 64, 'null' => false])
                ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
                ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->addIndex('syarat_id', ['unique' => true])
                ->create()
            ;
    }

    public function down(): void
    {
        $table = $this->table('syarat');
        if ($table->exists())
            $table
                ->drop()
                ->save()
            ;
    }
}
