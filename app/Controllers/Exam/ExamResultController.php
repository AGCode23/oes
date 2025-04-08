<?php

namespace App\Controllers\Exam;

use App\Models\Exam\ExamResult;
use App\Controllers\BaseController;

class ExamResultController extends BaseController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new ExamResult();
    }

    public function showResultPage($studentId)
    {
        $data = [];
        // Get student exam results
        $examResult = $this->userModel->getAllExams($studentId);
        $subjectCodes = $this->userModel->getAllSubjectCode($studentId);
        $data['user_exam_result'] = $examResult;
        $data['user_exam_subject_code'] = $subjectCodes;
        $this->view('exam_result', $data);
    }

    public function filterResults($studentId, $subjectCode, $yearLevels)
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        $filteredResults = $this->userModel->getFilteredResults($studentId, $subjectCode, $yearLevels);
        $filteredYear = $this->userModel->getFilteredYear($studentId, $yearLevels);

        echo json_encode([
            'filteredResult' => $filteredResults,
            'filteredYear' => $filteredYear
        ]);
        exit;
    }
}
