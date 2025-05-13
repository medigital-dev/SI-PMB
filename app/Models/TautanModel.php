<?php

namespace App\Models;

use CodeIgniter\Model;

class TautanModel extends Model
{
    protected $table = 'tautan';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'tautan_id',
        'title',
        'url',
        'aktif',
        'on_menu',
        'deleted_at',
    ];
}
