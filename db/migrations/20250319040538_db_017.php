<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db017 extends AbstractMigration
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
        $table = $this->table('banner');
        if ($table->exists())
            $table
                ->removeColumn('order')
                ->changeColumn('created_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->update();
    }

    public function down(): void
    {
        $table = $this->table('banner');
        if ($table->exists())
            $table
                ->addColumn('order', 'integer')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();
    }
}
