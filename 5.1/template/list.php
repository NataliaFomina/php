<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
  .form {
    border: 1px solid grey;
    padding: 10px;
    width: 500px;
  }
  table, tr, th, td {
    border: 1px solid grey;
		border-collapse: collapse;
		padding: 10px;
		text-align: center;
  }
  </style>
</head>
<body>


<h2>Пользователь: <?php echo $_SESSION['user']['login']?></h2>
<form action="index.php?c=user&a=logout" method="POST" style="display: inline">
  <input type="submit" name="logout" value="Выйти из аккаунта">
</form>

<h2>Добавить новую задачу:</h2>
<form class="form" action="index.php?c=task&a=addTask" method="post">
  <p>Описание:</p>
  <textarea name="description"></textarea>
  <p>Кому назначить:</p>
  <select name="user">
    <option value="">Не выбран</option>
    <?php foreach ($users as $user): ?>
      <option value="<?php echo $user['id'] ?>">
        <?php echo $user['login'] ?>
      </option>
    <?php endforeach; ?>
  </select>
  <input type="submit" name="newTask" value="Сохранить">
</form>

<h2>Список дел:</h2>
  <?php if (count($tasks) > 0): ?>
    <table>
      <thead>
      <tr>
        <th>ID</th>
        <th>Дата</th>
        <th>Описание</th>
        <th>Выполнено/Невыполнено</th>
        <th>Исполнитель</th>
        <th>ID исполнителя</th>
        <th>ID автора</th>
        <th>Делегирование</th>
        <th>Удаление</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($tasks as $task): ?>
        <tr>

          <?php foreach ($task as $key => $value): ?>
            <td>
              <?php
              if ($key === 'date_added') {
                $date = date('d.m.Y H:i', strtotime($value)); ?>
                <span><?php echo $date?></span>
              <?php
              } elseif ($key === 'is_done') {
                $str = $value === '0' ? 'Невыполнено' : 'Выполнено'; ?>
                <form action="index.php?c=task&a=taskIsDone" method="post">
                  <input type="hidden" name="taskId" value="<?php echo $task['id']?>">
                  <input type="submit" name="isDone" value="<?php echo $str?>"/>
                </form>
              <?php }  else { ?>
                <span><?php echo $value?></span>
                
              <?php
              }
              ?>
            </td>
          <?php endforeach; ?>
          <td>
          <form action="index.php?c=task&a=taskDelegate" method="post">
              <input type="hidden" name="taskId" value="<?php echo $task['id']?>">
              <select name="assignedUserId">
                <?php foreach ($users as $user): ?>
                  <option value="<?php echo $user['id'] ?>">
                    <?php echo $user['login'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <button type="submit">Делегировать</button>
            </form>
          </td>
          <td>
          <form action="index.php?c=task&a=taskDelete" method="post">
            <input type="hidden" name="taskId" value="<?php echo $task['id']?>">
            <input type="submit" name="delete" value="Удалить"/>
          </form>
          </td>

        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <h2>Количество дел: <?php echo $taskQuantity?></h2>
  <?php else: ?>
    <p>Дел нет</p>
  <?php endif; ?>
  
</body>
</html>