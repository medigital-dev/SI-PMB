<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db015 extends AbstractMigration
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
        $table = $this->table('identitas');
        if (!$table->exists())
            $table
                ->addColumn('identitas_id', 'string', ['limit' => 64, 'null' => false])
                ->addColumn('nama', 'string', ['limit' => 128, 'null' => false])
                ->addColumn('alamat', 'string', ['limit' => 128, 'null' => false])
                ->addColumn('telepon', 'string', ['limit' => 16, 'null' => true, 'default' => null])
                ->addColumn('email', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('website', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('facebook', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('instagram', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('tiktok', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('youtube', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('whatsapp', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('telegram', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('x', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('maps', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addColumn('threads', 'string', ['limit' => 64, 'null' => true, 'default' => null])
                ->addIndex('identitas_id', ['unique' => true])
                ->create()
            ;
    }

    public function down(): void
    {
        $table = $this->table('identitas');
        if ($table->exists())
            $table
                ->drop()
                ->save()
            ;
    }
}
