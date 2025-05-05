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

    public function getDashboardData($userId)
    {
        $firstName = $this->userModel->getUserFirstName($userId);
        $examStatus = $this->userModel->getUserExamStatus($userId);
        $pendingExams = $this->userModel->getUserPendingExams($userId);

        echo json_encode([
            'firstName' => $firstName,
            'examStatus' => $examStatus,
            'pendingExams' => $pendingExams
        ]);
    }
}
