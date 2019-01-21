<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include ('core/functions.php');
rediredt();

if (isset($_SESSION['admin']) && count($_POST) !== 0) {
  if (file_exists('../testSession/tmp/')) {
    foreach (glob('../testSession/tmp/*') as $file) {
      foreach($_POST as $fileName => $v) {
        if ( "../testSession/tmp/$fileName.json" === $file) {
          unlink($file);
        }
      }
    }
  }
}
$files = glob('tmp/*.json');
$message = "";
if (count($files) === 0) {
  $message = 'Нет загруженных тестов';
  $tests = [];
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
<?php 
  if (isset($_SESSION['admin'])) { ?>
  <a href="admin.php">Загрузка тестов</a>
<?php  } 
?>

<form action="core/logout.php" method="POST" style="display: inline">
  <input type="submit" value="Выйти из аккаунта">
</form>

<h2>Список тестов</h2>
<ol>
<?php 
foreach ($tests as $test) { ?>
  <li>
    <a href="test.php?fileName=<?php echo $test['fileName']?>"><?php echo $test['title']?></a>
    <?php
    if (isset($_SESSION['admin'])) { ?>
      <form action="list.php" method="POST">
        <input type="submit" value="Удалить" name="<?php echo $test['fileName']?>">
      </form>
    <?php }
    ?>
  </li>
<?php } ?>
</ol>
<p><?php echo $message ?></p>
  
</body>
</html>