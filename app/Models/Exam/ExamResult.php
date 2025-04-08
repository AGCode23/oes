<?php

namespace App\Models\Exam;

use App\Models\BaseModel;
use PDO;

class ExamResult extends BaseModel
{
    public function getAllExams($studentId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT e.title, e.description, c.class_code, er.submitted_at, er.score, er.status
                FROM exam_results as er
                JOIN exams AS e ON er.exam_id = e.id
                JOIN exam_assignments AS ea ON er.exam_id = ea.exam_id
                JOIN sections as s ON ea.section_id = s.id
                JOIN classes as c ON s.class_id = c.id
                WHERE er.student_id = ?"
            );
            $stmt->execute([$studentId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getAllSubjectCode($studentId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT class_code
                FROM sections as s
                JOIN student_section AS ss ON s.id = ss.section_id
                JOIN classes AS c ON c.id = s.class_id
                WHERE ss.student_id = ?"
            );
            $stmt->execute([$studentId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getFilteredResults($studentId, $subjectCode = null, $yearLevels = [])
    {
        try {
            $query = "SELECT e.title, e.description, c.class_code, er.submitted_at, er.score, er.status
                  FROM exam_results AS er
                  JOIN exams AS e ON er.exam_id = e.id
                  JOIN exam_assignments AS ea ON er.exam_id = ea.exam_id
                  JOIN sections AS s ON ea.section_id = s.id
                  JOIN classes AS c ON s.class_id = c.id
                  WHERE er.student_id = ?";

            $params = [':student_id' => $studentId];

            if ($subjectCode) {
                $query .= " AND c.class_code = ?";
                $params[':class_code'] = $subjectCode;
            }

            // Continue working on year level filter
            if (!empty($yearLevels)) {
                $placeholders = implode(',', array_fill(0, count($yearLevels), '?'));
                $query .= " AND s.year_level IN ($placeholders)";
                $params = array_merge($params, $yearLevels);
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute(array_values($params));
            $filteredResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $filteredResult;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getFilteredYear($studentId, $yearLevels = [])
    {
        $query = "SELECT c.class_code
                FROM exam_results AS er
                JOIN exams AS e ON er.exam_id = e.id
                JOIN exam_assignments AS ea ON er.exam_id = ea.exam_id
                JOIN sections AS s ON ea.section_id = s.id
                JOIN classes AS c ON s.class_id = c.id
                WHERE er.student_id = ?";

        $params = [':student_id' => $studentId];

        if (!empty($yearLevels)) {
            $placeholders = implode(',', array_fill(0, count($yearLevels), '?'));
            $query .= " AND s.year_level IN ($placeholders)";
            $params = array_merge($params, $yearLevels);
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($params));
        $year = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $year;
    }
}
