<?php
include 'model/Task.php';

class TaskController
{
  public function getList($usersList)
  {
    $task = new Task();
    $tasks = $task->getList($_SESSION['user']['id']);
    $taskQuantity = $task->getQuantity($_SESSION['user']['id']);
    Di::get()->render('list.php', ['tasks' => $tasks,'taskQuantity' => $taskQuantity, 'users' => $usersList]);
  }


  public function addNewTask()
  {
    if(isset($_POST['description']) && isset($_POST['user'])) {
      $task = new Task();
      $newTask = $task->addNewTask($_POST['description'], $_POST['user'], $_SESSION['user']['id']);
      if ($newTask) {
        header('Location: index.php?c=task&a=list');
      }
    }
  }

  public function isDone()
  {
    if(isset($_POST['isDone']) && isset($_POST['taskId'])) {
      $task = new Task();
      $isDone = $task->isDone($_POST['taskId']);
      if ($isDone) {
        header('Location: index.php?c=task&a=list');
      }
    }
  }

  public function delegate()
  {
    if(isset($_POST['assignedUserId']) && isset($_POST['taskId'])) {
      $task = new Task();
      $delegate = $task->assignedUser($_POST['assignedUserId'], $_POST['taskId']);
      if ($delegate) {
        header('Location: index.php?c=task&a=list');
      }
    }
  }

  public function delete()
  {
    if(isset($_POST['delete']) && isset($_POST['taskId'])) {
      $task = new Task();
      $delete = $task->delete($_POST['taskId']);
      if ($delete) {
        header('Location: index.php?c=task&a=list');
      }
    }
  }
}

?>