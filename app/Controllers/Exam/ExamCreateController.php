<?php

namespace App\Controllers\Exam;

use App\Models\Exam\ExamCreate;
use App\Controllers\BaseController;

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
