<?php
class Home extends Controller
{
    protected $task;
    public function __construct()
    {
        $this->task = $this->model('Task');
    }

    public function index()
    {
        $this->requireAuth();
        $this->task->markOverdue($_SESSION['user_id']);
        $tasks = $this->task->getAll($_SESSION['user_id']);
        $this->view('home/index', ['tasks' => $tasks]);
    }
}
