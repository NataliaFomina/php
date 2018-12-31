<?php

function getJson($name) 
{
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
  if ((count($_POST)-1) === count($json['questions'])) {
    $allAnswers = true;
  } else {
    $message = 'Ответьте на все вопросы';
  }
  // print_r($result);
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
<a href="admin.php">Загрузка тестов</a>
<a href="list.php">Список тестов</a>
<h3>Тема теста: "<?php echo $json['title']?>"</h3>
<form action="test.php" method="POST">
<input type="hidden" name="fileName" value="<?php echo $json['fileName']?>"/>
<?php
if (empty($_POST)) {
  foreach ($json['questions'] as $question) { ?>
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
<?php } else { ?>
  <p><?php echo $message?></p>
  <?php }
?>

</body>
</html>
