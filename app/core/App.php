<?php

class App
{

  protected $controller = "auth";
  protected $method = "index";
  protected $params = [];

  public function __construct()
  {
    $url = $this->parseUrl();

    if (file_exists(__DIR__ . '/../controllers/' . $url[0] . '.php')) {
      $this->controller = $url[0];
      unset($url[0]);
    } else {
      $this->show404();
      return;
    }

    require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;

    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      } else {
        $this->show404();
        return;
      }
    }

    $this->params = $url ? array_values($url) : [];
    call_user_func_array([$this->controller, $this->method], $this->params);
  }
  public function parseUrl()
  {
    if (isset($_GET['url'])) {
      $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    } else {
      $url = ['auth'];
    }

    if ($url === ['auth'] || $url === ['auth', 'register']) {
      if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('Location: /home');
        exit();
      }
    }
    return $url;
  }

  private function show404()
  {
    http_response_code(404);
    require_once __DIR__ . '/../views/errors/404.php';
    exit();
  }
}