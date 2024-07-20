<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GwrModel; 
use App\Models\Ind37Model; 
use App\Models\Ind69Model;
use App\Models\Ind112Model;
use App\Models\KontribusiModel; 
use App\Models\LingkunganBinaanModel; 

class GwrResults extends BaseController
{
    public function __construct()
    {
        $this->gwr = new GwrModel();
        $this->ind37 = new Ind37Model();
        $this->ind69 = new Ind69Model();
        $this->ind112 = new Ind112Model();
        $this->kontribusi = new KontribusiModel();
        $this->lingkungan_binaan = new LingkunganBinaanModel();
    }
    public function index()
    {
        $result =$this->gwr->findAll();
        return json_encode($result);
    }
    public function getData($id)
    {
        $result["A"]=$this->kontribusi->getData($id);
        $result["B"]=$this->gwr->getData($id);
        $result["C"]=$this->ind37->getData($id);
        $result["D"]=$this->ind69->getData($id);
        $result["E"]=$this->ind112->getData($id);
        $result["F"]=$this->lingkungan_binaan->getData($id);
        return json_encode($result);
    }
}
