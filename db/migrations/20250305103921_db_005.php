<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Db005 extends AbstractMigration
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
    public function change(): void {
        $table = $this->table('sekolah',['id'=>'id']);
        $table->addColumn('nama','string',['limit'=>128,'null'=>false])
        ->addColumn('logo','string',['limit'=>64,'null'=>false])
        ->addColumn('')
    }
}
