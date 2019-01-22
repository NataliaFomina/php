<?php
$pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");

if (!empty($_GET)) {
  foreach ($_GET as $value) {
    $name = $value;
  }
  $sth = $pdo->prepare("DESCRIBE $name");
  $sth->execute();
  $table = $sth->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Таблица</title>
  <style>
		body {
			padding: 10px;
		}
		table, tr, th, td {
			border: 1px solid grey;
			border-collapse: collapse;
			padding: 5px;
			text-align: center;
		}
		form {
			display: inline-block;
		}
		.f1, .f2 {
			margin: 20px 0;		
		}
	</style>
</head>
<body>
<a href="list.php">Посмотреть таблицы</a>
<a href="createTable.php">Создать таблицу</a>
<h2>Таблица: <?php echo $name ?></h2>

<table>
	<tr>
		<th>Поле</th>
		<th>Изменить</th>
		<th>Тип</th>
		<th>Изменить</th>
	</tr>
	<?php
		for ($i=0; $i < count($table); $i++) { 
			?>
			<tr><td>
				<?php echo $table[$i]['Field'] ?></td>
				<td>
					<form action="change.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="Table" value="<?= $name ?>">
						<input type="hidden" name="Field" value="<?= $table[$i]['Field'] ?>">
						<input type="hidden" name="Type" value="<?= $table[$i]['Type'] ?>">
						<input type="text" name="Field2" placeholder="ведите новое название" value="">
						<input type="submit" name="" value="Изменить">
					</form>
					<form action="delete.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="Table" value="<?= $name ?>">
						<input type="hidden" name="Field" value="<?= $table[$i]['Field'] ?>">
						<input type="submit" name="" value="Удалить">
					</form>
				</td>
			<td>
				<?php echo $table[$i]['Type'] ?></td>
				<td>
					<form action="change.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="Table" value="<?= $name ?>">
						<input type="hidden" name="Field" value="<?= $table[$i]['Field'] ?>">
						<input type="hidden" name="Type" value="<?= $table[$i]['Type'] ?>">
						<input type="text" name="Type2" placeholder="ведите новый тип" value="">
						<input type="submit" name="" value="Изменить">
					</form>
				</td></tr>
			<?php	
		}
	?>
</table>
    
</body>
</html>
