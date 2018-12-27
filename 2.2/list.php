<?php 
$json = file_get_contents("tmp/test1.json");
$jsonData = json_decode($json, true);
// var_dump($jsonData);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>List</title>
</head>
<body>
<a href="admin.php">Загрузка тестов</a>
<h2>Список тестов</h2>
<a href="test.php?file=test1">Тест 1</a>
  
</body>
</html>
