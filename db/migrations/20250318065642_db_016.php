<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db016 extends AbstractMigration
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
        $table = $this->table('forum');
        if ($table->exists())
            $table
                ->changeColumn('aktif', 'boolean', ['null' => false, 'default' => true])
                ->changeColumn('created_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->update()
            ;

        $table = $this->table('banner');
        if ($table->exists())
            $table
                ->removeColumn('order')
                ->changeColumn('created_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->update();

        $table = $this->table('berkas');
        if ($table->exists())
            $table
                ->changeColumn('type', 'string', ['limit' => 64, 'null' => false])
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('event');
        if ($table->exists())
            $table
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('header');
        if ($table->exists())
            $table
                ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('heroes');
        if ($table->exists())
            $table
                ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('identitas');
        if ($table->exists())
            $table
                ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('event');
        if ($table->exists())
            $table
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('informasi');
        if ($table->exists())
            $table
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('jadwal');
        if ($table->exists())
            $table
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('jalur');
        if ($table->exists())
            $table
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->update();

        $table = $this->table('tautan');
        if ($table->exists())
            $table
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('on_menu', 'boolean', ['default' => false, 'null' => false])
                ->removeColumn('urutan')
                ->update();

        $table = $this->table('logo');
        if ($table->exists())
            $table
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->changeColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                ->removeColumn('aktif')
                ->update();
    }

    public function down(): void
    {
        $table = $this->table('forum');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->changeColumn('aktif', 'boolean', ['default' => false, 'null' => false])
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update()
            ;

        $table = $this->table('banner');
        if ($table->exists())
            $table
                ->addColumn('order', 'integer')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('berkas');
        if ($table->exists())
            $table
                ->changeColumn('type', 'string', ['limit' => 128])
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('event');
        if ($table->exists())
            $table
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('header');
        if ($table->exists())
            $table
                ->removeColumn('created_at')
                ->changeColumn('updated_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('heroes');
        if ($table->exists())
            $table
                ->removeColumn('created_at')
                ->changeColumn('updated_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('identitas');
        if ($table->exists())
            $table
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->update();

        $table = $this->table('event');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->update();

        $table = $this->table('informasi');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('jadwal');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('jalur');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->update();

        $table = $this->table('tautan');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->addColumn('urutan', 'integer', ['null' => false])
                ->changeColumn('on_menu', 'boolean', ['null' => true, 'default' => false])
                ->update();

        $table = $this->table('logo');
        if ($table->exists())
            $table
                ->removeColumn('updated_at')
                ->changeColumn('created_at', 'datetime', ['null' => false])
                ->addColumn('aktif', 'boolean', ['null' => false])
                ->update();
    }
}
