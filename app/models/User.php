<?php
class User
{
  protected $email;
  protected $password;
  private $db;

  public function __construct()
  {
    $this->db = new Model("users");
    $this->db->connect();
  }

  public function register($email, $password, $confirm_password)
  {

    // Empty email
    if (empty($email)) {
      ErrorLog::add("missing_email", "Please fill out this field.");
    }

    // Account already exists
    $user = $this->db->readByColumn('email', $email);
    if ($user) {
      ErrorLog::add('account_exists', 'Account with such email already exists. Sign in instead.');
      return false;
    }

    // Empty password and mismatched password regex 
    if (empty($password)) {
      ErrorLog::add("missing_password", "Please fill out this field.");
    } else if (preg_match('/\s/', $password)) {
      ErrorLog::add('password_spaces', 'Password cannot contain spaces.');
    } else if (strlen($password) < 8) {
      ErrorLog::add('invalid_password_len', 'Password should be at least 8 characters long.');
    } else if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
      ErrorLog::add('invalid_password', 'Password must have uppercase, lowercase, number and special character');
    }


    // Empty confirm password
    if (empty($confirm_password)) {
      ErrorLog::add("missing_conf_password", "Please fill out this field.");
    } else if ($password !== $confirm_password) {
      ErrorLog::add("passwords_not_matching", "Passwords do not match.");
    } else {
      $hashed = password_hash($password, PASSWORD_BCRYPT);
    }

    if (ErrorLog::has()) {
      return false;
    }

    $insert = $this->db->insert([
      'email' => $email,
      'password' => $hashed
    ]);

    return $insert;
  }

  public function login($email, $password)
  {
    if (empty($email)) {
      ErrorLog::add("missing_email", "Please fill out this field.");
    }
    if (empty($password)) {
      ErrorLog::add("missing_password", "Please fill out this field.");
    }
    if (ErrorLog::has())
      return false;

    $user = $this->db->readByColumn('email', $email);
    if (!$user) {
      ErrorLog::add("not_registered", "There's no account registered with such email.");
      return false;
    }
    if (!password_verify($password, $user['password'])) {
      ErrorLog::add("invalid_credentials", "Incorrect password.");
      return false;
    }
    return $user['id']; 
  }

}
