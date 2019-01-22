<?php
$pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");

if (!empty($_POST)) {
  $name = $_POST['Table'];
  $column = $_POST['Field'];
  $delete = 'ALTER TABLE '.$name.' DROP COLUMN '.$column;
  $delete = $pdo->prepare("$delete"); 
  $delete->execute();
  header("Location:table.php?name=$name"); 
}

?>
