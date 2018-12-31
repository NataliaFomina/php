<?php
$message;
if (!empty($_FILES)) {
  if (array_key_exists('test', $_FILES)) {
    if ($_FILES['test']['type'] === 'application/json') {
      if ($_FILES['test']['error'] === 0) {
        $name = $_FILES['test']['name'];
        $files = glob('tmp/*.json');
        $result = inFiles($files, $name);
        
        if (!isset($result)) {
          if (move_uploaded_file($_FILES['test']['tmp_name'], 'tmp/' . $name)) {
            $message ='Файл успешно загружен';
          } else {
            $message = 'Файл не был загружен';
          }
        } else {
          $message ='Файл c таким именем уже загружен';
        }
      } else {
        $message = 'Ошибка в файле';
      }
    } else {
      $message = 'Загрузите файл формата JSON';
    }
  } else {
    $message = 'Файл не был отправлен';
  }
}

function inFiles($files, $name) 
{
  $result;
  foreach($files as $file) {
    $nameOfFile = explode('/', $file)[1];
    if ($nameOfFile === $name) {
      $result = true;
    }
  }
  return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin</title>
</head>
<body>
<a href="list.php">Список тестов</a>
<h2>Страница загрузки тестов</h2>
<form action="admin.php" method="POST" enctype="multipart/form-data">
  <div><input type="file" name="test"></div>
  <div><input type="submit" value="Отправить"></div>
  <?php echo $message ?>
</form>
    
</body>
</html>
