<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumModel extends Model
{
    protected $table = 'forum';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'forum_id',
        'parent_id',
        'nama',
        'isi',
        'aktif',
        'dibaca',
        'deleted_at',
    ];
}
