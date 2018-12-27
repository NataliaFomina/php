<?php
$json = file_get_contents( "tmp/test1.json");
$jsonData = json_decode($json, true);
// var_dump($jsonData);

if (!empty($POST)) {
  echo $POST;
  var_dump($POST);
  $e = (int)$POST['1'];
  var_dump($e);
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
<form action="test.php" method="POST">
<?php
foreach ($jsonData as $question) { ?>
  <legend><?php echo $question['question']?></legend>
  <?php foreach ($question['answers'] as $answer) { ?>
    <label>
      <input type="radio" name="<?php echo $question['id']?>" value="<?php echo $answer['answer']?>"> 
        <?php echo $answer['answer']?>
    </label>
  <?php } ?>
<?php }
?>
  <div><input type="submit" value="Отправить"></div>
</form>
<h2>Результат</h2>
<?php
if (!empty($POST)) {
  echo $POST;
  var_dump($POST);
}
?>
<!-- вопрос
ответ
результат -->
  
</body>
</html>
