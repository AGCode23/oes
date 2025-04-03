<?php

namespace App\Models\Exam;

use PDO;
use App\Models\BaseModel;

class ExamQuestion extends BaseModel
{
    public function markAsPending($studentId, $examId)
    {
        try {
            // $stmt = $this->db->prepare(
            //     "INSERT INTO exam_results (student_id, exam_id, status, submitted_at)
            //     VALUES (:student_id, :exam_id, 'pending', :submitted_at)
            //     ON DUPLICATE KEY UPDATE status = 'pending', submitted_at = :submitted_at"
            // );

            // $stmt->execute([
            //     ':student_id' => $studentId,
            //     ':exam_id' => $examId,
            //     ':submitted_at' => date('Y-m-d H:i:s')
            // ]);

            $stmt = $this->db->prepare("SELECT id FROM exam_results WHERE student_id = :student_id AND exam_id = :exam_id");

            $stmt->execute([
                ':student_id' => $studentId,
                ':exam_id' => $examId
            ]);

            $existingEntry = $stmt->fetch();
            if ($existingEntry) {
                // Update if exists
                $stmt = $this->db->prepare(
                    "UPDATE exam_results SET status = 'pending', submitted_at = :submitted_at WHERE id = :id"
                );

                $stmt->execute([
                    ':submitted_at' => date('Y-m-d H:i:s'),
                    ':id' => $existingEntry['id']
                ]);
            } else {
                // Insert if doesn't exist
                $stmt = $this->db->prepare(
                    "INSERT INTO exam_results (student_id, exam_id, status, submitted_at)
                    VALUES (:student_id, :exam_id, 'pending', :submitted_at)"
                );

                $stmt->execute([
                    ':student_id' => $studentId,
                    ':exam_id' => $examId,
                    ':submitted_at' => date('Y-m-d H:i:s')
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            $this->logError('markAsPending', $th);
            return false;
        }
    }

    public function getStatus($studentId, $examId)
    {
        $examAnswerModel = new ExamAnswer();
        $currentStatus = $examAnswerModel->getExamStatus($studentId, $examId);
        return $currentStatus;
    }

    public function isPending($studentId, $examId)
    {
        $examAnswerModel = new ExamAnswer();
        $currentStatus = $examAnswerModel->getExamStatus($studentId, $examId);
        if ($currentStatus == 'pending' || $currentStatus == false) {
            return true;
        }
        return false;
    }

    public function getQuestionExam($exam_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM questions WHERE exam_id = ?");
            $stmt->execute([$exam_id]);
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $questions;
        } catch (\Throwable $e) {
            $this->logError('getQuestionExam', $e);
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
            $this->logError('isStudentAuthorized', $e);
            return false;
        }
    }

    private function logError($method, \Throwable $e)
    {
        error_log("Database Error in {$method}: " . $e->getMessage());
    }
}
