<?php
class Controller
{
  public function model($model)
  {
    require_once '../app/models/' . $model . '.php';
    return new $model();
  }

  public function view($view, $data = [])
  {
    extract($data);
    require_once '../app/views/' . $view . '.php';
  }

  protected function isLoggedIn()
  {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
  }

  protected function requireAuth()
  {
    if (!$this->isLoggedIn()) {
      header('Location: /task-app/auth/register');
      exit();
    }
  }

  protected function requireGuest()
  {
    if ($this->isLoggedIn()) {
      header('Location: /task-app/home/index');
      exit();
    }
  }
}