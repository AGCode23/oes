<?php

namespace App\Models;

use PDO;
use App\Models\BaseModel;

class Exam extends BaseModel
{
    public function getUserRole($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['role'];
        } catch (\Throwable $e) {
            error_log("Database Error in getUserRole: " . $e->getMessage());
            return false;
        }
    }
}
