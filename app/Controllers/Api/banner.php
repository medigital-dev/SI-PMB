<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class banner extends ResourceController
{
    protected $model = 'App\models\BannerModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}
