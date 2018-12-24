<?php
  $data = file_get_contents(__DIR__. '/phoneBook.json');
  $users = json_decode($data, true);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="table.css">
  <title>Document</title>
</head>
<body>
  <table>
    <tr>  
      <th>Имя</th>
      <th>Фамилия</th>
      <th>Адрес</th>
      <th>Номер телефона</th>
    <tr>
    <?php foreach ($users as $user) { ?>
      </tr>
        <td><?php echo $user['firstName']?></td>
        <td><?php echo $user['lastName']?></td>
        <td><?php echo $user['address'] ?></td>
        <td><?php echo $user['phoneNumber'] ?></td>
      </tr>
    <?php } ?>
</body>
</html>
