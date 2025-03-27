<?php

namespace App\Models\Exam;

use PDO;
use App\Models\BaseModel;

class ExamAnswer extends BaseModel
{
    public function saveAnswer($studentId, $examId, $questionId, $answer)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO student_answers (student_id, exam_id, question_id, answer)
            VALUES (?, ?, ?, ?)");
            $stmt->bindValue(1, $studentId, PDO::PARAM_INT);
            $stmt->bindValue(2, $examId, PDO::PARAM_INT);
            $stmt->bindValue(3, $questionId, PDO::PARAM_INT);
            $stmt->bindValue(4, $answer, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (\Throwable $th) {
            $this->logError('saveAnswer', $th);
            return false;
        }
    }

    public function saveResult($studentId, $examId, $score, $status = 'completed')
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO exam_results (student_id, exam_id, score, status, submitted_at)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                score = VALUES(score), status = VALUES(status), submitted_at = VALUES(submitted_at)"
            );

            $stmt->execute();

            return true;
        } catch (\Throwable $th) {
            $this->logError('saveResult', $th);
            return false;
        }
    }

    public function getExamStatus($studentId, $examId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT status FROM exam_results
                WHERE student_id = ? AND exam_id = ?"
            );

            $stmt->bindValue(1, $studentId, PDO::PARAM_INT);
            $stmt->bindValue(2, $examId, PDO::PARAM_INT);

            $stmt->execute();

            $currentStatus = $stmt->fetchColumn();

            if (!$currentStatus) {
                return false;
            }

            return $currentStatus;
        } catch (\Throwable $th) {
            $this->logError('getExamStatus', $th);
            return false;
        }
    }

    private function logError($method, \Throwable $e)
    {
        error_log("Database Error in {$method}: " . $e->getMessage());
    }
}
