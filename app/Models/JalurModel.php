<?php

namespace App\Models;

use CodeIgniter\Model;

class JalurModel extends Model
{
    protected $table = 'jalur';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'jalur_id',
        'nama',
        'persen',
        'jumlah',
        'deleted_at',
    ];
}
