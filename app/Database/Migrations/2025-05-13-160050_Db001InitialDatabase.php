<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Db001InitialDatabase extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'info_id' => ['type' => 'VARCHAR', 'constraint' => 128, 'unique' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 128],
            'isi' => ['type' => 'LONGTEXT'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('informasi', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'berkas_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'filename' => ['type' => 'VARCHAR', 'constraint' => 64],
            'title' => ['type' => 'VARCHAR', 'constraint' => 64],
            'src' => ['type' => 'VARCHAR', 'constraint' => 256],
            'type' => ['type' => 'VARCHAR', 'constraint' => 64],
            'size' => ['type' => 'INT'],
            'status' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('berkas', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'banner_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 64],
            'description' => ['type' => 'VARCHAR', 'constraint' => 512],
            'berkas_id' => ['type' => 'VARCHAR', 'constraint' => 64],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('banner', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'event_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 128],
            'tanggal' => ['type' => 'DATETIME'],
            'status' => ['type' => 'BOOLEAN', 'default' => true],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('event', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'tautan_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 128],
            'url' => ['type' => 'VARCHAR', 'constraint' => 128],
            'aktif' => ['type' => 'BOOLEAN', 'default' => true],
            'on_menu' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tautan', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'forum_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'parent_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 64],
            'isi' => ['type' => 'LONGTEXT'],
            'aktif' => ['type' => 'BOOLEAN', 'default' => true],
            'dibaca' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('forum', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'logo_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'src' => ['type' => 'VARCHAR', 'constraint' => 128],
            'type' => ['type' => 'ENUM', 'constraint' => ['dark', 'light', 'default', 'favicon'], 'default' => 'default'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('logo', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'header_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'isi' => ['type' => 'LONGTEXT'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('header', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'hero_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'content' => ['type' => 'LONGTEXT'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('heroes', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'jadwal_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 128],
            'content' => ['type' => 'TEXT'],
            'aktif' => ['type' => 'BOOLEAN', 'default' => true],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwal', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'jalur_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 128],
            'persen' => ['type' => 'INT'],
            'jumlah' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jalur', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'syarat_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'content' => ['type' => 'LONGTEXT'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('syarat', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'dokumen_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'content' => ['type' => 'LONGTEXT'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true,],
            'identitas_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'unique' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 128],
            'alamat' => ['type' => 'VARCHAR', 'constraint' => 128],
            'telepon' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true, 'default' => null],
            'email' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'website' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'facebook' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'instagram' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'tiktok' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'youtube' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'whatsapp' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'telegram' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'x' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'maps' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'threads' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'default' => null],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('identitas', true);
    }

    public function down()
    {
        $this->forge->dropTable('admin', true);
        $this->forge->dropTable('informasi', true);
        $this->forge->dropTable('berkas', true);
        $this->forge->dropTable('banner', true);
        $this->forge->dropTable('event', true);
        $this->forge->dropTable('tautan', true);
        $this->forge->dropTable('forum', true);
        $this->forge->dropTable('logo', true);
        $this->forge->dropTable('header', true);
        $this->forge->dropTable('heroes', true);
        $this->forge->dropTable('jadwal', true);
        $this->forge->dropTable('jalur', true);
        $this->forge->dropTable('syarat', true);
        $this->forge->dropTable('dokumen', true);
        $this->forge->dropTable('identitas', true);
    }
}
