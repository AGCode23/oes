<?php

namespace App\Controllers\Exam;

use App\Models\Exam\ExamList;
use App\Controllers\BaseController;

class ExamListController extends BaseController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new ExamList();
    }

    public function showExamListPage($studentId)
    {
        $data = [];
        $exams = $this->userModel->getExams($studentId);
        $data['user_exams'] = $exams;
        foreach ($data['user_exams'] as $exam) {
            $currentStatus = $this->userModel->getStatus($studentId, $exam['id']);
            $data['user_exam_status'][$exam['id']] = $currentStatus;
        }
        $this->view('exam_list', $data);
    }
}
