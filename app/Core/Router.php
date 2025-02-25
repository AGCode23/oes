<?php

namespace App\Core;

use App\Controllers\ExamController;
use App\Controllers\ExamCreateController;
use App\Controllers\HomeController;
use App\Controllers\UserController;

class Router
{
    public function route($url)
    {
        $parsedUrl = parse_url($url);
        switch ($parsedUrl['path']) {
            case "/":
                $controller = new HomeController();

                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                } else {
                    $controller->showHomePage();
                }
                break;

            case "/login":
                $controller = new UserController();

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $controller->login($_POST['login-email'], $_POST['login-password']);
                } else {
                    if (isset($_SESSION['user_id'])) header('Location: /');
                    $controller->showLoginPage();
                }
                break;

            case "/register":
                $controller = new UserController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->register(
                        $_POST['register-name'],
                        $_POST['register-email'],
                        $_POST['register-password'],
                        $_POST['register-confirm-password']
                    );
                } else {
                    if (isset($_SESSION['user_id'])) header('Location: /');
                    $controller->showRegisterPage();
                }
                break;

            case "/exam":
                $controller = new ExamController();
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                } else {
                    $controller->showExamPage();
                }
                break;

            case "/exam/create":
                $controller = new ExamCreateController();
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $postData = json_decode(file_get_contents('php://input'), true);
                    $controller->submitExam($postData);
                } else {
                    $controller->showExamCreatePage();
                }
                break;

            case "/exam/list":
                echo "List";
                break;

            case "/logout":
                $controller = new UserController();

                $controller->logout();
                break;

            default:
                echo '404';
                break;
        }
    }
}
