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
            $stmt = $this->db->prepare("SELECT id FROM exam_results
            WHERE student_id = :student_id AND exam_id = :exam_id");
            $stmt->execute([
                ':student_id' => $studentId,
                ':exam_id' => $examId
            ]);
            $resultId = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultId) {
                $updateStmt = $this->db->prepare(
                    "UPDATE exam_results
                    SET score = :score, status = :status, submitted_at = :submitted_at
                    WHERE student_id = :student_id AND exam_id = :exam_id"
                );
                $updateStmt->execute([
                    ':score' => $score,
                    ':status' => $status,
                    ':submitted_at' => date('Y-m-d H:i:s'),
                    ':student_id' => $studentId,
                    ':exam_id' => $examId
                ]);
            } else {
                $stmt = $this->db->prepare(
                    "INSERT INTO exam_results (student_id, exam_id, score, status, submitted_at)
                    VALUES (:student_id, :exam_id, :score, :status, :submitted_at)"
                );

                $stmt->execute([
                    ':student_id' => $studentId,
                    ':exam_id' => $examId,
                    ':score' => $score,
                    ':status' => $status,
                    ':submitted_at' => date('Y-m-d H:i:s')
                ]);
            }

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

    public function calculateScore($studentId, $examId)
    {
        $studentAnswerStmt = $this->db->prepare(
            "SELECT COUNT(*) AS student_score
            FROM student_answers AS sa
            JOIN questions AS q
            ON sa.question_id = q.id
            WHERE sa.exam_id = :exam_id AND sa.student_id = :student_id AND sa.answer = q.correct_answer"
        );

        $studentAnswerStmt->execute([
            ':exam_id' => $examId,
            ':student_id' => $studentId
        ]);

        $studentScore = $studentAnswerStmt->fetch(PDO::FETCH_ASSOC);

        $itemCountStmt = $this->db->prepare(
            "SELECT COUNT(*) AS item_count
            FROM student_answers AS sa
            JOIN questions as q
            ON sa.question_id = q.id
            WHERE sa.exam_id = :exam_id AND sa.student_id = :student_id"
        );

        $itemCountStmt->execute([
            ':exam_id' => $examId,
            ':student_id' => $studentId
        ]);

        $itemCount = $itemCountStmt->fetch(PDO::FETCH_ASSOC);

        $result = array_merge($studentScore, $itemCount);

        return $result;
    }

    private function logError($method, \Throwable $e)
    {
        error_log("Database Error in {$method}: " . $e->getMessage());
    }
}
