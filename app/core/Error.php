<?php

class ErrorLog {
  public static $errors = [];

  public static function add($title, $message) {
    self::$errors[$title] = $message;
  }

  public static function get() {
    return self::$errors;
  }

  public static function has() {
    return !empty(self::$errors);
  }

  public static function clear() {
    self::$errors = [];
  }

}