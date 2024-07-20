<?php

namespace App\Controllers;
use App\Models\GwrModel; 

class Home extends BaseController
{
    public function __construct()
    {
        $this->gwr = new GwrModel();
    }
    public function index(): string
    {
        $result =$this->gwr->getData(12);
        $data["gwr"]=json_encode($result);
        return view('map',$data);
    }
}
