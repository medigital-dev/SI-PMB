<?php

namespace App\Models;

use CodeIgniter\Model;

class LogoModel extends Model
{
    protected $table = 'logo';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'logo_id',
        'src',
        'type',
        'deleted_at',
    ];
}
