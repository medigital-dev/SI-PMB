<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    protected $table = 'berkas';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'berkas_id',
        'filename',
        'title',
        'src',
        'type',
        'size',
        'status',
        'deleted_at',
    ];
}
