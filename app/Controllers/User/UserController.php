<?php

namespace App\Controllers\User;

use App\Helpers\Helper;
use App\Models\User\User;
use App\Controllers\BaseController;

class UserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login($email, $password)
    {
        $validateEmail = new Helper();

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!$validateEmail->validateEmail($email)) {
            return $this->setSessionError('Invalid email format!', '/login');
        }

        if (empty($password)) {
            return $this->setSessionError('Password cannot be empty!', '/login');
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!isset($user['email'])) {
            return $this->setSessionError('No such email exists!', '/login');
        }

        if (!password_verify($password, $user['pwd'])) {
            $_SESSION['user_email'] = $email;
            return $this->setSessionError('Incorrect Password!', '/login');
        }

        $this->setUserSession($user);

        header("Location: /?login=success", true, 303);
        exit;
    }

    public function register($name, $email, $gender, $dob, $password, $confirmPassword)
    {
        $validateEmail = new Helper();

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($name) || empty($email) || empty($gender) || empty($dob) || empty($password) || empty($confirmPassword)) {
            if (!empty($email)) $_SESSION['user_email_register'] = $email;
            if (!empty($name)) $_SESSION['user_name_register'] = $name;
            return $this->setSessionError('All fields must be filled up!', '/register');
        }

        if (!$validateEmail->validateEmail($email)) {
            return $this->setSessionError('Invalid email format!', '/register');
        }

        if ($password !== $confirmPassword) {
            if (!empty($email)) $_SESSION['user_email_register'] = $email;
            if (!empty($name)) $_SESSION['user_name_register'] = $name;
            return $this->setSessionError("Password doesn't match!", '/register');
        }

        try {
            $user = $this->userModel->setUser($name, $email, $gender, $dob, $password);
        } catch (\Exception $e) {
            error_log("User Error in email: " . $e->getMessage());
            return $this->setSessionError($e->getMessage(), '/register');
        }

        $this->setUserSession($user);

        header('Location: /?register=success', true, 303);
        exit;
    }

    public function logout()
    {
        if (isset($_SESSION['user_name']) && isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
            session_unset();
            session_destroy();

            header('Location: /?logout=success', true, 303);
            exit;
        }
    }

    public function showLoginPage()
    {
        $data = $this->getSessionErrors();

        if (isset($_SESSION['user_email'])) {
            $data['user_email'] = $_SESSION['user_email'];
            unset($_SESSION['user_email']);
        }

        if (isset($_SESSION['user_email_register'])) {
            $data['user_email_register'] = $_SESSION['user_email_register'];
            unset($_SESSION['user_email_register']);
        }

        if (isset($_SESSION['user_name_register'])) {
            $data['user_name_register'] = $_SESSION['user_name_register'];
            unset($_SESSION['user_name_register']);
        }

        $this->view("login", $data);
    }

    // HELPER METHODS

    private function setSessionError($message, $redirect)
    {
        $_SESSION['user_error'] = $message;
        header('Location: ' . $redirect, true, 303);
        exit;
    }

    private function setUserSession($user)
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        unset($_SESSION['user_error']);
        unset($_SESSION['user_email']);
    }

    private function getSessionErrors()
    {
        $data = [];

        if (isset($_SESSION['user_error'])) {
            $data['user_error'] = $_SESSION['user_error'];
            unset($_SESSION['user_error']);
        }

        return $data;
    }
}
