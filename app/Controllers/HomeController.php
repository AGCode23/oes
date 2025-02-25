<?php

namespace App\Controllers;


class HomeController extends BaseController
{

    public function showHomePage()
    {
        $this->view('dashboard');
    }
}
