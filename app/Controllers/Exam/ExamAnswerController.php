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

    public function submitAnswers($studentId, $examId, $answers, $questionType)
    {
        if (!$studentId || !$examId || empty($answers)) {
            echo json_encode(['error' => 'Invalid data received.']);
            return;
        }

        // Save student answers to DB
        foreach ($answers as $questionId => $answer) {
            $this->userModel->saveAnswer($studentId, $examId, $questionId, $answer);
        }

        if ($questionType == 'multiple_choice' || $questionType == 'true_false') {
            $result = $this->userModel->calculateScore($studentId, $examId);
            $percentage = ($result['student_score'] / $result['item_count']) * 100;
            $passing = 75.0;
            $status = ($percentage >= $passing) ? 'passed' : 'failed';

            $this->userModel->saveResult($studentId, $examId, $percentage, $status);

            return $status;
        }
    }
}
