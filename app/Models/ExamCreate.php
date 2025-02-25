<?php

namespace App\Models;

use PDO;
use App\Models\BaseModel;

class ExamCreate extends BaseModel
{
    public function insertNewExam($postData)
    {
        $title = $postData['title'];
        $description = $postData['description'];
        $duration = $postData['duration'];
        $type = $postData['type'];
        $questions = $postData['questions'];
        $createdBy = $_SESSION['user_id'];

        try {
            $this->db->beginTransaction();

            $examId = $this->insertExam($title, $description, $duration, $createdBy);

            $this->insertQuestion($examId, $questions, $type);

            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            $this->logError('insertNewExam', $e);
            return false;
        }
    }

    private function insertExam($title, $description, $duration, $createdBy)
    {
        $stmt = $this->db->prepare("INSERT INTO exams (title, description, duration, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bindValue(1, $title, PDO::PARAM_STR);
        $stmt->bindValue(2, $description, PDO::PARAM_STR);
        $stmt->bindValue(3, $duration, PDO::PARAM_INT);
        $stmt->bindValue(4, $createdBy, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $this->db->lastInsertId();
    }

    private function insertQuestion($examId, $questions, $type)
    {
        $stmt = $this->db->prepare("INSERT INTO questions (exam_id, question_text, type, options, correct_answer) VALUES (?, ?, ?, ?, ?)");

        foreach ($questions as $question) {
            $options = isset($question['options']) ? json_encode($question['options']) : null;
            $answer = $question['answer'] ?? '';
            $stmt->bindValue(1, $examId, PDO::PARAM_INT);
            $stmt->bindValue(2, $question['question'], PDO::PARAM_STR);
            $stmt->bindValue(3, $type, PDO::PARAM_STR);
            $stmt->bindValue(4, $options, PDO::PARAM_STR);
            $stmt->bindValue(5, $answer, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    private function logError($method, \Throwable $e)
    {
        error_log("Database Error in {$method}: " . $e->getMessage());
    }
}
