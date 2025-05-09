<?php

namespace App\Core;

use App\Controllers\Exam\ExamController;
use App\Controllers\Home\HomeController;
use App\Controllers\User\UserController;
use App\Controllers\Exam\ExamListController;
use App\Controllers\Exam\ExamAnswerController;
use App\Controllers\Exam\ExamCreateController;
use App\Controllers\Exam\ExamResultController;
use App\Controllers\Exam\ExamQuestionController;

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
                    $registerName = $_POST['register-name'] ?? '';
                    $registerEmail = $_POST['register-email'] ?? '';
                    $registerGender = $_POST['register-gender'] ?? '';
                    $registerDob = $_POST['register-dob'] ?? '';
                    $registerPwd = $_POST['register-password'] ?? '';
                    $registerConfirmPwd = $_POST['register-confirm-password'] ?? '';
                    $controller->register(
                        $registerName,
                        $registerEmail,
                        $registerGender,
                        $registerDob,
                        $registerPwd,
                        $registerConfirmPwd
                    );
                } else {
                    if (isset($_SESSION['user_id'])) header('Location: /');
                    $controller->showLoginPage();
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
                    if ($_SESSION['user_role'] !== 'student') {
                        $controller->showExamCreatePage();
                    } else {
                        echo 'You do not have permission to visit this page!';
                    }
                }
                break;

            case "/exam/list":
                $controller = new ExamListController();
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                } else {
                    $student_id = (int)$_SESSION['user_id'];
                    $controller->showExamListPage($student_id);
                }
                break;

            case "/exam/take_exam":
                $controller = new ExamQuestionController();
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    if (isset($_GET['exam_id'])) {
                        $user_id = (int)$_SESSION['user_id'];
                        $exam_id = (int)$_GET['exam_id'];

                        $isPending = $controller->userModel->isPending($user_id, $exam_id);
                        if ($isPending) {
                            $controller->showQuestionPage($user_id, $exam_id);
                        } else {
                            header("Location: /exam");
                        }
                    }
                }
                break;

            case "/exam/submit_answer":
                $controller = new ExamAnswerController();

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user_id = (int)$_SESSION['user_id'] ?? null;
                    $examId = (int)$_POST['exam_id'] ?? null;
                    $answers = $_POST['answer'] ?? [];
                    $questionType = $_POST['exam_type'] ?? null;

                    $controller->submitAnswers($user_id, $examId, $answers, $questionType);
                    header("Location: /exam/list");
                    exit;
                }

                break;

            case "/exam/result":
                $controller = new ExamResultController();

                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                } else {
                    $user_id = $_SESSION['user_id'];
                    $subjectCode = $_GET['subject'] ?? null;
                    $yearLevels = !empty($_GET['years']) ? explode(",", $_GET['years']) : [];
                    if (isset($_GET['subject']) || isset($_GET['years'])) {
                        $controller->filterResults($user_id, $subjectCode, $yearLevels);
                    } else {
                        $controller->showResultPage($user_id);
                    }
                }
                break;

            case "/logout":
                $controller = new UserController();

                $controller->logout();
                break;

            case "/user/dashboard_data":
                $controller = new HomeController();
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                } else {
                    $userId = $_SESSION['user_id'];
                    $controller->getDashboardData($userId);
                }
                break;

            default:
                echo '404';
                break;
        }
    }
}
