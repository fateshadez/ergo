<?php
class Tasks extends Controller
{
  protected $task;

  public function __construct()
  {
    $this->task = $this->model('Task');
  }

  public function delete()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    foreach ($data['ids'] as $id) {
      $this->task->delete($id);
    }
  }

  public function complete()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    foreach ($data['ids'] as $id) {
      $this->task->complete($id);
    }
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $dueDate = null;
      if (!empty($_POST['due_date'])) {
        $time = $_POST['due_time'] ?? '00:00';
        $dueDate = $_POST['due_date'] . ' ' . $time . ':00';
        $localDate = $_POST['due_date'] . '' . $time . ':00';
        $dt = new DateTime($localDate, new DateTimeZone('Europe/Kiev'));
        $dt->setTimezone(new DateTimeZone('UTC'));
        $dueDate = $dt->format('Y-m-d H:i:s');
      } else {
        $dueDate = null;
        if (!empty($_POST['due_date']) || !empty($_POST['due_time'])) {
          $date = !empty($_POST['due_date']) ? $_POST['due_date'] : date('Y-m-d');
          $time = !empty($_POST['due_time']) ? $_POST['due_time'] : '00:00';
          $dueDate = $date . ' ' . $time . ':00';
        }
      }
      $result = $this->task->create(
        trim($_POST['title']),
        trim($_POST['desc'] ?? ''),
        'PENDING',
        $_POST['priority'],
        $dueDate,
        $_SESSION['user_id']
      );
      header('Location: /home/index');
      exit();
    }
  }

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $dueDate = null;
      if (!empty($_POST['due_date'])) {
        $time = $_POST['due_time'] ?? '00:00';
        $dueDate = $_POST['due_date'] . ' ' . $time . ':00';
        $localDate = $_POST['due_date'] . '' . $time . ':00';
        $dt = new DateTime($localDate, new DateTimeZone('Europe/Kiev'));
        $dt->setTimezone(new DateTimeZone('UTC'));
        $dueDate = $dt->format('Y-m-d H:i:s');
      } else {
        $dueDate = null;
        if (!empty($_POST['due_date']) || !empty($_POST['due_time'])) {
          $date = !empty($_POST['due_date']) ? $_POST['due_date'] : date('Y-m-d');
          $time = !empty($_POST['due_time']) ? $_POST['due_time'] : '00:00';
          $dueDate = $date . ' ' . $time . ':00';
        }
      }
      $this->task->db->change($id, [
        'title' => trim($_POST['title']),
        'desc' => trim($_POST['desc'] ?? ''),
        'status' => $_POST['status'] ?? 'PENDING',
        'priority' => $_POST['priority'],
        'due_date' => $dueDate
      ]);
      header('Location: /home/index');
      exit();
    }
  }
}
