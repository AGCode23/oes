<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Helper;
use App\Models\ExamCreate;

class ExamCreateController extends BaseController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new ExamCreate();
    }

    public function submitExam($postData)
    {
        if (empty($postData) || !isset($postData['questions'])) {
            echo json_encode(['message' => 'Invalid data received.']);
            return;
        }

        $saveExam = $this->userModel->insertNewExam($postData);

        if ($saveExam) {
            echo json_encode(['message' => 'Exam creation success!']);
        } else {
            echo json_encode(['message' => 'Exam creation failed.']);
        }
    }

    public function showExamCreatePage()
    {
        $this->view("exam_create");
    }
}
