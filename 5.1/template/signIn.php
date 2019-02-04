<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
  .form {
    border: 1px solid grey;
    padding: 10px;
    width: 200px;
  }
  </style>
</head>
<body>

<h2>Форма авторизации</h2>
<form action="index.php?c=user&a=signIn" method="post" class="form">
    <p>Логин</p><input type="text" name="login" placeholder="Введите логин" required>
    <p>Пароль</p><input type="text" name="pass" placeholder="Введите пароль" required>
    <input type="submit" value="Отправить"/>
</form>

</body>
</html>