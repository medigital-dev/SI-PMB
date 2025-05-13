<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Info extends ResourceController
{
    protected $model = 'App\models\InfoModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}
