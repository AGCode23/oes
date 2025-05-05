<?php

namespace App\Models\Home;

use PDO;
use App\Models\BaseModel;

class HomeModel extends BaseModel
{
    public function getUserFirstName($userId)
    {
        try {
            $stmt = $this->db->prepare("SELECT name FROM users WHERE id = :user_id");
            $stmt->execute([
                ':user_id' => $userId
            ]);
            $userFirstName = $stmt->fetchColumn();

            return $userFirstName;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getUserExamStatus($userId)
    {
        try {
            $stmt = $this->db->prepare("SELECT status FROM exam_results WHERE student_id = :user_id");
            $stmt->execute([
                ':user_id' => $userId
            ]);
            $userExamStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userExamStatus;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getUserPendingExams($userId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT e.title, e.description, ea.due_date
                FROM exam_results as er
                JOIN exams as e ON er.exam_id = e.id
                JOIN exam_assignments AS ea ON e.id = ea.exam_id
                WHERE er.student_id = :user_id AND er.status = 'pending'
                ORDER BY ea.due_date ASC"

            );
            $stmt->execute([
                ':user_id' => $userId
            ]);
            $userPendingExams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userPendingExams;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
