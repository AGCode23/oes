<?php

namespace App\Models;

use PDO;
use App\Models\BaseModel;

class ExamList extends BaseModel
{
    public function getExams($userId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT e.id, e.title, e.description, e.duration
                FROM exams e JOIN exam_assignments ea ON e.id = ea.exam_id
                JOIN student_section ss ON ea.section_id = ss.section_id
                WHERE ss.student_id = ?"
            );
            $stmt->execute([$userId]);

            $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $exams;
        } catch (\Throwable $e) {
            error_log("Database Error in getUserByEmail: " . $e->getMessage());
            return false;
        }
    }
}
