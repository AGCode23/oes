<?php

namespace App\Controllers;

use App\Models\Exam;
use App\Controllers\BaseController;

class ExamController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Exam();
    }

    public function showExamPage()
    {
        $data = [];
        $role = $this->userModel->getUserRole($_SESSION['user_id']);
        $data['user_role'] = $role;

        $this->view('exam', $data);;
    }
}
