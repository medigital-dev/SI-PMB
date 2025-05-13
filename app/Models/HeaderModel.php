<?php

namespace App\Models;

use CodeIgniter\Model;

class HeaderModel extends Model
{
    protected $table = 'header';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'header_id',
        'isi',
        'deleted_at',
    ];
}
