<?php

session_start();
if (isset($_SESSION['user']['login'])) {
  header('Location: list.php');
  exit;
}

// подключение PDO
include ('dbconnect.php');

// проверка есть ли таблица user?
$sth = $pdo->query("SHOW TABLES in `nfomina`");
$tables = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $item) {
  if ($item['Tables_in_nfomina'] !== 'user') {
    // если нет таблицы user, то создаем ее
    createUserTable();
  } 
}

// проверка отправлена ли форма ?
if (!empty($_POST)) {
   // смотрим GET - регистрация или авторизация?
  if (isset($_GET['signUp'])) {
    // регистрируем
    signUp($_POST['login'], $_POST['pass']);
  } elseif (isset($_GET['signIn'])) {
    // авторизируем
    signIn($_POST['login'], $_POST['pass']);
  }
}

// функция регистрации
function signUp($login, $pass) {

  // проверка есть ли такой логин в таблице?
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT id FROM user WHERE login = :login LIMIT 1");
  $sth->execute([":login" => $login]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);

  if (count($result) === 0) {
    // нет - сохраняем данные и пропускаем дальше пользователя в создание таблиц
    $sth = $pdo->prepare("INSERT INTO user SET login = :login, password = :password");
    $sth->execute([
      ":login" => $login,
      ":password" => $pass,
      ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth = $pdo->query("SELECT @@IDENTITY");
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['user'] = ['login' => $login, 'id' => $result[0]['@@IDENTITY']];
    header('Location: list.php');
    exit;

  } else {
    print("Данный логин $login уже существует, ввведите другой логин");
  }
}

// функция авторизации
function signIn($login, $pass) {

  // проверка есть ли такой логин в таблице?
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT id, login FROM user WHERE login = :login AND password = :password LIMIT 1");
  $sth->execute([
    ":login" => $login,
    ":password" => $pass,
    ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);

  if (count($result) !== 0) {
    //  есть - переходим в список
    $_SESSION['user'] = $result[0];
    header('Location: list.php');
  } else {
    print("Не верный логин или пароль");
  }
}

function createUserTable() 
{
  $tableName = 'user';
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE $tableName (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `login` varchar(50) NOT NULL,
      `password` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8" ;

    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица $tableName создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Главная страница</title>
  <style>
  .button {
    padding: 10px;
    margin: 5px;
    border: 1px solid grey;
    text-decoration: none;
  }
  .form {
    border: 1px solid grey;
    padding: 10px;
    width: 200px;
  }
  </style>
</head>
<body>

<?php if (empty($_GET)) { ?>
  <h2>Вы зарегистрированы или новый пользователь?</h2>
  <a class="button" href="index.php?signUp">Регистрация</a>
  <a class="button" href="index.php?signIn">Авторизация</a>
<?php }
?>

<?php if (isset($_GET['signIn'])) : ?>
  <h2>Форма авторизации</h2> 
<?php elseif (isset($_GET['signUp'])) : ?>
  <h2>Форма регистрации</h2>   
<?php endif; ?>

<?php if (isset($_GET['signIn']) || isset($_GET['signUp'])) { ?>
  <form action="index.php?<?php echo isset($_GET['signIn']) ? 'signIn' : 'signUp' ?>" method="post" class="form">
    <p>Логин</p><input type="text" name="login" placeholder="Введите логин" required>
    <p>Пароль</p><input type="text" name="pass" placeholder="Введите пароль" required>
    <input type="submit" value="Отправить" />
  </form>
<?php } ?>

</body>
</html>
