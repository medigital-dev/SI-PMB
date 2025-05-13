<?php

namespace App\Models;

use CodeIgniter\Model;

class HeroesModel extends Model
{
    protected $table = 'heroes';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'hero_id',
        'content',
        'deleted_at',
    ];
}
