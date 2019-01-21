<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include ('core/functions.php');
rediredt();

$message = '';

function getJson($name) 
{
  if (!file_exists("tmp/$name.json")) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit('Ошибка 404. Файл отсутствует');
  }
  $files = glob('tmp/*.json');
  $jsonName;
  foreach($files as $file) {
    $fileName = explode('.', explode('/', $file)[1])[0];
    if ($fileName === $name) {
      $jsonName = "$name.json" ;
    }
  }
  $jsonData = file_get_contents("tmp/$jsonName");
  $json = json_decode($jsonData, true);
  $json['fileName'] = $name;
  // print_r($json);
  return $json;
}
if (!empty($_GET)) {
  $name = $_GET['fileName'];
  $json = getJson($name);
}

if (!empty($_POST)) {
  // print_r($_POST);
  $name = $_POST['fileName'];
  $json = getJson($name);
  $result = [];
  $ansTrue = 0;

  foreach($json['questions'] as $questions) {
    $arr['question'] = $questions['question'];
    foreach($_POST as $key => $value ) {
      if ($key === $questions['id']) {
        $arr['userAnswer'] = $value;
      }
    }
    foreach($questions['answers'] as $answers) {
      if ($answers['isTrue'] === true) {
        $arr['trueAnswer'] = $answers['answer'];
      }
    }
    $result[] = $arr;
  }
 
  foreach($result as $question) {
    if (strval($question['userAnswer']) === strval($question['trueAnswer'])) {
      $ansTrue++; 
    }
  }

  $questions = count($json['questions']);
  $mark = calcMark($questions, $ansTrue);

  if ((count($_POST)-1) === count($json['questions'])) {
    $allAnswers = true;
  } else {
    $message = 'Ответьте на все вопросы';
  }

}

if (isset($_SESSION['guest'])) {
  $userName = $_SESSION['guest'];
} elseif (isset($_SESSION['admin'])) {
  $userName = $_SESSION['admin'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test</title>
</head>
<body>

<?php 
  if (isset($_SESSION['admin'])) { ?>
  <a href="admin.php">Загрузка тестов</a>
<?php  } 
?>
<a href="list.php">Список тестов</a> 

<form action="core/logout.php" method="POST" style="display: inline">
  <input type="submit" value="Выйти из аккаунта">
</form>


<?php
if (isset($json)) { ?>
    <h3>Тема теста: "<?php echo $json['title']?>"</h3>
<?php } else { ?>
    <p>Перейдите к списку тестов</p>
<?php }
?>


<form action="test.php" method="POST">

<input type="hidden" name="fileName" value="<?php echo $json['fileName']?>"/>
<?php
if (empty($_POST) && isset($json)) { ?>
<?php   foreach ($json['questions'] as $question) { ?>
    <legend><?php echo $question['question']?></legend>
    <?php foreach ($question['answers'] as $answer) { ?>
      <label>
        <input type="radio" name="<?php echo $question['id']?>" value="<?php echo $answer['answer']?>"> 
          <?php echo $answer['answer']?>
      </label>
    <?php } ?>
  
  <?php }
  ?>
  <div>
  <input type="submit" value="Отправить">

</div>
  
<?php } ?>
</form>

<?php
if (!empty($_POST) && isset($allAnswers)) { ?>
<h3>Результаты теста:</h3>
<?php foreach($result as $item) { ?>
  <h4><?php echo $item['question']?></h4>
  <p>Ваш ответ: <?php echo $item['userAnswer']?></p>
  <p>Правильный ответ: <?php echo $item['trueAnswer']?></p>
  <?php } ?>
  <img src="core/img.php?name=<?php echo $userName?>&result=<?php echo $mark .' баллов'?>" alt="">
<?php } else { ?>
  <p><?php echo $message?></p>
  <?php }
?>


  
</body>
</html>