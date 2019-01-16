<?php
$pdo = new PDO("mysql:host=localhost;dbname=global;charset=UTF8", "nfomina", "neto1914");
$author = isset($_GET['author']) ? $_GET['author'] : '%';
$name = isset($_GET['name']) ? $_GET['name'] : '%';
$isbn = isset($_GET['isbn']) ? $_GET['isbn'] : '%';
$sql = "SELECT * FROM books WHERE author LIKE '%$author%' AND name LIKE '%$name%' AND isbn LIKE '%$isbn%'";
$sth = $pdo->query($sql);
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
// print_r($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SQL</title>
  <style>
    table {
      border: 1px solid grey;
      border-collapse: collapse;
    }
    td, th {
      border: 1px solid grey;
      padding: 5px;
    }
  </style>
</head>
<body>
<br>
<form method="GET" action="sql_books.php">
  <input type="text" name="isbn" placeholder="ISBN" value="<?php echo $author === '%' ? '' : $author?>">
  <input type="text" name="name" placeholder="Название книги" value="<?php echo $name === '%' ? '' : $name?>">
  <input type="text" name="author" placeholder="Автор книги" value="<?php echo $isbn === '%' ? '' : $isbn?>">
  <input type="submit" value="Поиск">
</form>
<br>
<table>
  <tr>
    <th>№</th>
    <th>Название</th>
    <th>Автор</th>
    <th>Год выпуска</th>
    <th>ISBN</th>
    <th>Жанр</th>
  </tr>
  <?php foreach ($result as $row) { ?>
    <tr>
      <?php
      foreach ($row as $cell) {
        echo "<td>$cell</td>";
      }
      ?>
    </tr>
  <?php } ?>
</table>
  
</body>
</html>
