<?php

namespace App\Controllers;

use App\Models\ExamList;

class ExamListController extends BaseController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new ExamList();
    }

    public function showExamListPage()
    {
        $data = [];
        $exams = $this->userModel->getExams($_SESSION['user_id']);
        $data['user_exams'] = $exams;
        $this->view('exam_list', $data);
    }
}
