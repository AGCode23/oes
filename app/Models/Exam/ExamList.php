<?php

namespace App\Models\Exam;

use PDO;
use App\Models\BaseModel;

class ExamList extends BaseModel
{
    private $examAnswerModel;

    public function getStatus($studentId, $examId)
    {
        $this->examAnswerModel = new ExamAnswer();
        $currentStatus = $this->examAnswerModel->getExamStatus($studentId, $examId);
        return $currentStatus;
    }

    public function getExams($studentId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT e.id, e.title, e.description, e.duration
                FROM exams e JOIN exam_assignments ea ON e.id = ea.exam_id
                JOIN student_section ss ON ea.section_id = ss.section_id
                WHERE ss.student_id = ?"
            );
            $stmt->execute([$studentId]);

            $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $exams;
        } catch (\Throwable $e) {
            error_log("Database Error in getExams: " . $e->getMessage());
            return false;
        }
    }
}
