<?php

session_start();

if (!isset($_GET['c']) || !isset($_GET['a'])) {
  $controller = 'user';
  $action = 'logout';
} else {
  $controller = $_GET['c'];
  $action = $_GET['a'];
}

if ($controller === 'user') {

  include 'controller/UserController.php';
  $userController = new UserController;

  if($action === 'logout') {
    $userController->logout();
  } elseif($action === 'signUp') {
    $userController->signUp();
  } elseif($action === 'signIn') {
    $userController->signIn();
  }

} elseif ($controller === 'task') { 

  if (!isset($_SESSION['user']['login'])) {
    header('Location: index.php');
    exit;
  }

  include 'controller/TaskController.php';
  $taskController = new TaskController;

  if($action === 'list') {
    include 'model/User.php';
    $user = new User;
    $usersList = $user->getUsersList();
    $taskController->getList($usersList);

  } elseif ($action === 'addTask') {
    $taskController->addNewTask();
  } elseif($action === 'taskIsDone') {
    $taskController->isDone();
  } elseif($action === 'taskDelegate') {
    $taskController->delegate();
  } elseif($action === 'taskDelete') {
    $taskController->delete();
  }
}

?>