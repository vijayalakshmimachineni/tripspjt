<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Home_model;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    /*public function home_url(){
        // $home = new Home_model();
        $url = base_url().'/users/getusers';
        echo $url;die();
        return $this->CallAPI('GET',$url);        
    }*/


}
