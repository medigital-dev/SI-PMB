<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class scema extends AbstractMigration
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
        $table = $this->table('admin');
        $table
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('username', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('username', ['unique' => true])
            ->create();

        $table = $this->table('informasi');
        $table
            ->addColumn('info_id', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('judul', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('isi', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('info_id', ['unique' => true])
            ->create();

        $table = $this->table('berkas');
        $table->addColumn('berkas_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('filename', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('src', 'string', ['limit' => 256, 'null' => false])
            ->addColumn('type', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('size', 'integer', ['null' => false])
            ->addColumn('status', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('berkas_id', ['unique' => true])
            ->create();

        $table = $this->table('banner');
        $table->addColumn('banner_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 512, 'null' => false])
            ->addColumn('berkas_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('banner_id', ['unique' => true])
            ->create();

        $tabel =  $this->table('event');
        $tabel->addColumn('event_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('tanggal', 'datetime', ['null' => false])
            ->addColumn('status', 'boolean', ['default' => 1, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('event_id', ['unique' => true])
            ->create();

        $table = $this->table('tautan');
        $table->addColumn('tautan_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('url', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('aktif', 'boolean', ['null' => false, 'default' => true])
            ->addColumn('on_menu', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('tautan_id', ['unique' => true])
            ->create();

        $table = $this->table('forum');
        $table
            ->addColumn('forum_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('parent_id', 'string', ['limit' => 64, 'null' => true, 'default' => null])
            ->addColumn('nama', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('isi', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('aktif', 'boolean', ['null' => false, 'default' => true])
            ->addColumn('dibaca', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('forum_id', ['unique' => true])
            ->create();

        $table = $this->table('logo');
        $table
            ->addColumn('logo_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('src', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('type', 'enum', ['values' => ['dark', 'light', 'default', 'favicon'], 'default' => 'default', 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('logo_id', ['unique' => true])
            ->create();

        $table = $this->table('header');
        $table
            ->addColumn('header_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('isi', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('header_id', ['unique' => true,])
            ->create();

        $table = $this->table('heroes');
        $table
            ->addColumn('hero_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('hero_id', ['unique' => true])
            ->create();

        $table = $this->table('jadwal');
        $table
            ->addColumn('jadwal_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_SMALL, 'null' => false])
            ->addColumn('aktif', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('jadwal_id', ['unique' => true])
            ->create();

        $table = $this->table('jalur');
        $table
            ->addColumn('jalur_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('nama', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('persen', 'integer', ['null' => false])
            ->addColumn('jumlah', 'integer', ['null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('jalur_id', ['unique' => true])
            ->create();

        $table = $this->table('syarat');
        $table
            ->addColumn('syarat_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('syarat_id', ['unique' => true])
            ->create();

        $table = $this->table('dokumen');
        $table
            ->addColumn('dokumen_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('dokumen_id', ['unique' => true])
            ->create();

        $table = $this->table('identitas');
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
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('identitas_id', ['unique' => true])
            ->create();
    }
}
