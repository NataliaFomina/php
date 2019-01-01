<?php 
$files = glob('tmp/*.json');
$message = "";
if (count($files) === 0) {
  $message = 'Нет загруженных тестов';
} else {
  $tests = [];
  foreach($files as $file) {
    $name = explode('/',$file)[1];
    $json = file_get_contents("tmp/$name");
    $jsonData = json_decode($json, true);
    $jsonData['fileName'] = explode('.',$name)[0];
    $tests[] = $jsonData;
  }
}
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
<ol>
<?php 
foreach ($tests as $test) { ?>
  <li><a href="test.php?fileName=<?php echo $test['fileName']?>"><?php echo $test['title']?></a></li>
<?php } ?>
</ol>
<p><?php echo $message ?></p>
  
</body>
</html>
