<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentitasModel extends Model
{
    protected $table = 'identitas';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'identitas_id',
        'nama',
        'alamat',
        'telepon',
        'email',
        'website',
        'facebook',
        'instagram',
        'tiktok',
        'youtube',
        'whatsapp',
        'telegram',
        'x',
        'maps',
        'threads',
        'deleted_at',
    ];
}
