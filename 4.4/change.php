<?php
$pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");

if (!empty($_POST)) {
  $name = $_POST['Table'];
  $field = $_POST['Field'];
  $type = $_POST['Type'];
  if (isset($_POST['Field2'])) {
	  $field2 = $_POST['Field2'];
	  $change = 'ALTER TABLE '.$name.' CHANGE '.$field.' '.$field2.' '.$type.';';
  }
  if (isset($_POST['Type2'])) {
	  $type2 = $_POST['Type2'];
	  $change = 'ALTER TABLE '.$name.' MODIFY '.$field.' '.$type2.';';
  }
  $change = $pdo->prepare("$change"); 
  $change->execute();
  header("Location:table.php?name=$name");
}

?>
