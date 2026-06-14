<?php
class Controller
{
  public function model($model)
  {
    require_once __DIR__ . '/../models/' . $model . '.php';
    return new $model();
  }

  public function view($view, $data = [])
  {
    extract($data);
    require_once __DIR__ . '/../views/' . $view . '.php';
  }

  protected function isLoggedIn()
  {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
  }

  protected function requireAuth()
  {
    if (!$this->isLoggedIn()) {
      header('Location: /auth/login');
      exit();
    }
  }

  protected function requireGuest()
  {
    if ($this->isLoggedIn()) {
      header('Location: /home');
      exit();
    }
  }
}