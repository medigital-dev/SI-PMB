<?php

namespace App\Models;

use CodeIgniter\Model;

class SyaratModel extends Model
{
    protected $table = 'syarat';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'syarat_id',
        'content',
        'deleted_at',
    ];
}
