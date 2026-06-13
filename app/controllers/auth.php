<?php

class Auth extends Controller
{
  protected $user;
  public function __construct()
  {
    $this->user = $this->model('User');
  }

  public function index() {
    $this->register();
  }

  public function register()
  {
    $this->requireGuest();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
      $password = trim($_POST["password"]);
      $confirm_password = $_POST["confirm_password"];
      $result = $this->user->register($email, $password, $confirm_password);
      if (!$result) {
        $_SESSION['errors'] = ErrorLog::get();
        header('Location: /task-app/auth/register');
        exit();
      } else {
        session_regenerate_id(true);
        header('Location: /task-app/auth/login');
        exit();
      }
    } else {
      $errors = $_SESSION['errors'] ?? [];
      unset($_SESSION['errors']);
      $this->view('auth/register', ['errors' => $errors]);
    }
  }

  public function login()
  {
    $this->requireGuest();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
      $password = trim($_POST["password"]);
      $result = $this->user->login($email, $password);

      if (!$result) {
        $_SESSION['errors'] = ErrorLog::get();
        header('Location: /task-app/auth/login');
        exit();
      }

      session_regenerate_id(true);
      $_SESSION['user_id'] = $result;
      $_SESSION['logged_in'] = true;
      header('Location: /task-app/home/index');
      exit();

    } else {
      $errors = $_SESSION['errors'] ?? [];
      unset($_SESSION['errors']);
      $this->view('auth/login', ['errors' => $errors]);
    }
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    header('Location: /task-app/auth/register');
    exit();
  }
}