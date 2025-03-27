<?php

namespace App\Controllers\Exam;

use App\Controllers\BaseController;
use App\Models\Exam\ExamQuestion;

class ExamQuestionController extends BaseController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new ExamQuestion();
    }

    public function showQuestionPage($studentId, $exam_id)
    {
        // Mark the exam as pending
        $this->userModel->markAsPending($studentId, $exam_id);

        $data = [];
        $questions = $this->userModel->getQuestionExam($exam_id);
        if ($questions && $this->userModel->isStudentAuthorized($studentId, $exam_id)) {
            $data['exam_id'] = $exam_id;
            $data['exam_questions'] = $questions;
            $this->view('exam_question', $data);
        } else {
            echo "You are not authorized!";
        }
    }
}
