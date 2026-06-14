<?php
class Model
{
  private $conn;
  private $tbName;

  public function __construct($tbName)
  {
    $this->tbName = $tbName;
  }
  public function __destruct()
  {
    if ($this->conn) {
      $this->disconnect();
    }
  }
  public function connect()
  {
    $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int) DB_PORT);
    return $this->conn ? true : false;
  }

  public function disconnect()
  {
    return mysqli_close($this->conn);
  }

  public function read($id)
  {
    $stmt = mysqli_prepare($this->conn, "SELECT * FROM $this->tbName WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
  }

  public function readByColumn($column, $value)
  {
    $stmt = mysqli_prepare($this->conn, "SELECT * FROM $this->tbName WHERE `$column`=?");
    if (!$stmt)
      return null;
    mysqli_stmt_bind_param($stmt, 's', $value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
  }

  public function readAllByColumn($column, $value)
  {
    $stmt = mysqli_prepare(
      $this->conn,
      "SELECT * FROM $this->tbName WHERE `$column`=? ORDER BY priority ASC, due_date ASC"
    );
    mysqli_stmt_bind_param($stmt, 's', $value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
    }
    return $rows;
  }

  public function readAll()
  {
    $result = mysqli_query($this->conn, "SELECT * FROM $this->tbName");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
    }
    return $rows;
  }

  public function insert($args = [])
  {
    if (empty($args))
      return false;
    $columns = implode(', ', array_map(fn($col) => "`$col`", array_keys($args)));
    $placeholders = implode(', ', array_fill(0, count($args), '?'));
    $values = array_values($args);
    $types = str_repeat('s', count($args));
    $stmt = mysqli_prepare(
      $this->conn,
      "INSERT INTO $this->tbName ($columns) VALUES ($placeholders)"
    );
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    return mysqli_stmt_execute($stmt);
  }

  public function delete($id)
  {
    $stmt = mysqli_prepare($this->conn, "DELETE FROM $this->tbName WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
  }

  public function change($id, $args = [])
  {
    if (empty($args))
      return false;

    $set = implode(', ', array_map(fn($col) => "`$col`=?", array_keys($args)));
    $values = array_values($args);
    $values[] = $id;
    $types = str_repeat('s', count($args)) . 'i';

    $stmt = mysqli_prepare(
      $this->conn,
      "UPDATE $this->tbName SET $set WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    return mysqli_stmt_execute($stmt);
  }

  public function query($sql, $types = '', $params = [])
  {
    $stmt = mysqli_prepare($this->conn, $sql);
    if ($types && $params) {
      mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    return $stmt;
  }
}