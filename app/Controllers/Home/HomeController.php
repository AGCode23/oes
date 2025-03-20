<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;


class HomeController extends BaseController
{

    public function showHomePage()
    {
        $this->view('dashboard');
    }
}
