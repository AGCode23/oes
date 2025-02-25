<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\User;

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

    public function register($name, $email, $password, $confirmPassword)
    {
        $validateEmail = new Helper();

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            return $this->setSessionError('All fields must be filled up!', '/register');
        }

        if (!$validateEmail->validateEmail($email)) {
            return $this->setSessionError('Invalid email format!', '/register');
        }

        if ($password !== $confirmPassword) {
            return $this->setSessionError("Password doesn't match!", '/register');
        }

        try {
            $user = $this->userModel->setUser($name, $email, $password);
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
        if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
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

        $this->view("login", $data);
    }

    public function showRegisterPage()
    {
        $data = $this->getSessionErrors();

        $this->view("register", $data);
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
