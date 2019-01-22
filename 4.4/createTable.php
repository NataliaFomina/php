<?php

if (!empty($_POST)) {
  // print_r($_POST);
  createTable($_POST['title'], $_POST['data1'], $_POST['data2'], $_POST['data3']);
}

function createTable($title, $data1, $data2, $data3) 
{
  $table = $title;
  try {
    $pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE $table(
      `id` int NOT NULL AUTO_INCREMENT,
      $data1 varchar(100) NULL,
      $data2 varchar(100) NULL,
      $data3 int NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8" ;

    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица $table создана.</h3>");
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
  <title>Создание таблицы</title>
</head>
<body>
<a href="list.php">Посмотреть таблицы</a>

<h2>Создание таблицы</h2>

<form action="createTable.php" method="post" enctype="multipart/form-data">
  <div>Введите название таблицы: 
    <input type="text" name="title" placeholder="Формат: латинские буквы">
  <div>
  <hr/>
  <div>Введите названия полей таблицы:<div>
  <div>Текстовый формат<input type="text" name="data1" placeholder="Пример: name"></div>
  <div>Текстовый формат<input type="text" name="data2" placeholder="Пример: author"></div>
  <div>Численный формат<input type="text" name="data3" placeholder="Пример: price"></div>
  <div>
  <input type="submit" value="Добавить">
</form>
    
</body>
</html>
