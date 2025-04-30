<?php

namespace App\Models\Home;

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
}
