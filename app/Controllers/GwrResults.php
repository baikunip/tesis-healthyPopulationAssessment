<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GwrModel; 

class GwrResults extends BaseController
{
    public function __construct()
    {
        $this->gwr = new GwrResults();
    }
    public function index()
    {
        $result =$this->gwr->findAll();
        return $this->respond($result,200);
    }
}
