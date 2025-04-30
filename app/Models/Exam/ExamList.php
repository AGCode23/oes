<?php

namespace App\Models\Exam;

use PDO;
use App\Models\BaseModel;

class ExamList extends BaseModel
{
    private $examAnswerModel;
    private $yearLevel;

    public function getStatus($studentId, $examId)
    {
        $this->examAnswerModel = new ExamAnswer();
        $currentStatus = $this->examAnswerModel->getExamStatus($studentId, $examId);
        return $currentStatus;
    }

    public function getExams($studentId)
    {
        $this->getYearLevel($studentId);
        try {
            $stmt = $this->db->prepare(
                "SELECT e.id, e.title, e.description, c.class_code, e.duration, ea.due_date
                FROM exams AS e
                JOIN exam_assignments AS ea ON e.id = ea.exam_id
                JOIN student_section AS ss ON ea.section_id = ss.section_id
                JOIN sections AS s ON ss.section_id = s.id
                JOIN classes AS c ON s.class_id = c.id
                WHERE ss.student_id = :student_id AND s.year_level = :year_level"
            );
            $stmt->execute([
                ':student_id' => $studentId,
                ':year_level' => $this->yearLevel
            ]);

            $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $exams;
        } catch (\Throwable $e) {
            error_log("Database Error in getExams: " . $e->getMessage());
            return false;
        }
    }

    private function getYearLevel($studentId)
    {
        try {
            $stmt = $this->db->prepare("SELECT year FROM users WHERE id = :student_id");
            $stmt->execute([
                ':student_id' => $studentId
            ]);
            $this->yearLevel = $stmt->fetchColumn();
        } catch (\Throwable $th) {
            return false;
        }
    }
}
