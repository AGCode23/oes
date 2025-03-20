<?php

namespace App\Models\Exam;

use PDO;
use App\Models\BaseModel;

class ExamQuestion extends BaseModel
{
    public function getQuestionExam($exam_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM questions WHERE exam_id = ?");
            $stmt->execute([$exam_id]);
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $questions;
        } catch (\Throwable $e) {
            error_log("Database Error in getQuestionExam: " . $e->getMessage());
            return false;
        }
    }

    public function isStudentAuthorized($student_id, $exam_id)
    {
        try {
            $verify = $this->db->prepare(
                "SELECT DISTINCT ss.student_id
                FROM student_section ss
                JOIN exam_assignments ea ON ss.section_id = ea.section_id
                WHERE ss.student_id = ? AND ea.exam_id = ?"
            );
            $verify->execute([$student_id, $exam_id]);

            return $verify->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            error_log("Database Error in isStudentAuthorized: " . $e->getMessage());
            return false;
        }
    }
}
