<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
$message = " ";

if (isset($_POST['username'], $_POST['password'])) {
  // print_r($_POST);
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (file_exists('core/users/login.json')) {
    $file = file_get_contents('core/users/login.json', true);
    $users = json_decode($file, true);
    foreach ($users as $user) {
      if ($user['name'] === $username  && $user['password'] === $password) {
        $_SESSION['admin'] = $username;
        header('Location: list.php');
      } else {
        $message = "Неверное имя пользователя или пароль";
      }
    }
  }
}
if (isset($_POST['guestname'])) {
  $_SESSION['guest'] = $_POST['guestname'];
  header('Location: list.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Index</title>
</head>
<body>
<h3>Форма авторизации</h3>
<form action="index.php" method="POST">
  <legend>Введите имя пользователя</legend>
  <input type="text" name="username"/>
  <br/>
  <legend>Введите пароль</legend>
  <input type="text" name="password"/>
  <input type="submit">
</form>
<p style="color:red;"><?php echo $message ?></p>

<h3>Или войдите как гость</h3>
<form action="index.php" method="POST">
  <legend>Введите имя пользователя</legend>
  <input type="text" name="guestname"/>
  <br/>
  <input type="submit">
</form>
 
</body>
</html>