<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db009 extends AbstractMigration
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
        $table = $this->table('logo');
        $table
            ->removeColumn('tema')
            ->addColumn('type', 'enum', ['values' => ['dark', 'light', 'default', 'favicon'], 'default' => 'default', 'null' => false])
            ->update();
    }

    public function down(): void
    {
        $table = $this->table('logo');
        $table
            ->removeColumn('type')
            ->addColumn('tema', 'enum', ['values' => ['dark', 'light'], 'null' => false])
            ->update();
    }
}
