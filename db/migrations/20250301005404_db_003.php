<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db003 extends AbstractMigration
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

        $table = $this->table('banner', ['id' => 'id']);
        if (!$table->exists())
            $table->addColumn('banner_id', 'string', ['limit' => 64, 'null' => false])
                ->addColumn('title', 'string', ['limit' => 64, 'null' => false])
                ->addColumn('description', 'string', ['limit' => 512, 'null' => false])
                ->addColumn('order', 'integer')
                ->addColumn('created_at', 'datetime', ['null' => false])
                ->addColumn('berkas_id', 'string', ['limit' => 64, 'null' => false])
                ->addIndex('banner_id', ['unique' => true])
                ->create();

        $table = $this->table('berkas');
        $table
            ->changeColumn('type', 'string', ['limit' => 128])
            ->addColumn('size', 'integer', ['null' => false])
            ->addColumn('status', 'boolean', ['default' => false, 'null' => false])
            ->save();
    }

    public function down(): void
    {
        $this->table('banner')->drop()->save();
        $this->table('berkas')
            ->changeColumn('type', 'string', ['limit' => 64])
            ->removeColumn('size')
            ->removeColumn('status')
            ->save();
    }
}
