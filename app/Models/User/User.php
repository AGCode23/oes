<?php

namespace App\Models\User;

use PDO;
use App\Models\BaseModel;
use Exception;

class User extends BaseModel
{
    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT id, email, name, pwd FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            error_log("Database Error in getUserByEmail: " . $e->getMessage());
            return false;
        }
    }

    public function setUser($name, $email, $pwd)
    {

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                throw new Exception("Email already exist!");
            }

            $hashedPassword = password_hash($pwd, PASSWORD_BCRYPT);

            $stmt = $this->db->prepare("INSERT INTO users (name, email, pwd) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);

            $userId = $this->db->lastInsertId();
            $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->db->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Database Error in setUser: " . $e->getMessage());
            return false;
        }
    }
}
