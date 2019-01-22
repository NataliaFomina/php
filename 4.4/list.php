<?php
  $pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");

  $sth = $pdo->query("SHOW TABLES in `nfomina`");
  $tables = $sth->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($_POST)) {
    foreach($_POST as $name => $v) {
      foreach ($tables as $table) {
        if ($table['Tables_in_nfomina'] === $name) {
          dropTable($table['Tables_in_nfomina']);
          $sth = $pdo->query("SHOW TABLES in `nfomina`");
          $tables = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
      }
    }
  }

  function dropTable($table) 
  {
    $pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");
    $sth = $pdo->query("DROP TABLE IF EXISTS $table");
    $tables = $sth->fetchAll(PDO::FETCH_ASSOC);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Список таблиц</title>
</head>
<body>
<a href="createTable.php">Создать таблицу</a>

<h2>Список таблиц:</h2>
<?php if (count($tables) === 0) { ?>
  <p>Загруженных таблиц нет</p>
<?php } ?>

<ol>
  <?php foreach ($tables as $table): ?>
      <li>
        <a href="table.php?name=<?php echo $table['Tables_in_nfomina']?>"><?php echo $table['Tables_in_nfomina']?></a>
        <form action="list.php" method="post" enctype="multipart/form-data">
          <input type="submit" value="Удалить" name="<?php echo $table['Tables_in_nfomina']?>">
        </form>
      </li>
  <?php endforeach; ?>
</ol>

    
</body>
</html>
