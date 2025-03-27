<?php

namespace App\Controllers\Exam;

use App\Controllers\BaseController;
use App\Models\Exam\ExamAnswer;

class ExamAnswerController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new ExamAnswer();
    }

    public function submitAnswers($studentId, $examId, $answers)
    {
        if (!$studentId || !$examId || empty($answers)) {
            echo json_encode(['error' => 'Invalid data received.']);
            return;
        }

        // Save student answers to DB
        foreach ($answers as $questionId => $answer) {
            var_dump($this->userModel->saveAnswer($studentId, $examId, $questionId, $answer));
        }
    }
}
