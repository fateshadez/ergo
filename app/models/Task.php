<?php
class Task
{
  protected $title;
  protected $desc;
  protected $status;
  protected $priority;
  protected $dueDate;
  protected $usersId;
  public $db;

  public function __construct()
  {
    $this->db = new Model("tasks");
    $this->db->connect();
  }
  public function create($title, $desc, $status, $priority, $dueDate, $users_id)
  {
    if (empty($title) || empty($status) || empty($priority))
      return false;
    return $this->db->insert([
      'title' => $title,
      'desc' => $desc,
      'status' => $status,
      'priority' => $priority,
      'due_date' => $dueDate,
      'users_id' => $users_id
    ]);
  }

  public function edit($id, $title, $desc, $status, $priority, $dueDate)
  {
    return $this->db->change($id, ['title' => $title, 'desc' => $desc, 'status' => $status, 'priority' => $priority, 'due_date' => $dueDate]);
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function getAll($userId)
  {
    return $this->db->readAllByColumn('users_id', $userId);
  }

  public function delete($id)
  {
    return $this->db->delete($id);
  }

  public function complete($id)
  {
    return $this->db->change($id, ['status' => 'COMPLETED']);
  }

  public function markOverdue($userId)
  {
    $this->db->query(
      "UPDATE tasks SET status = 'OVERDUE' 
         WHERE users_id = ? 
         AND status != 'COMPLETED' 
         AND due_date IS NOT NULL 
         AND due_date < NOW()",
      'i',
      [$userId]
    );
  }
}
