<?php

namespace App\Controllers\Home;

use App\Models\Home\HomeModel;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new HomeModel();
    }

    public function showHomePage()
    {
        $this->view('dashboard');
    }

    public function getFirstName($userId)
    {
        $firstName = $this->userModel->getUserFirstName($userId);

        echo json_encode(['firstName' => $firstName]);
    }
}
