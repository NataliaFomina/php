<?php
session_start();
$userId = $_SESSION['user']['id'];

// подключение PDO
include ('dbconnect.php');

// записываем всех пользователей в users
$sth = $pdo->query("SELECT id, login FROM user");
$users = $sth->fetchAll(PDO::FETCH_ASSOC);

// проверка есть ли таблица task?
$sth = $pdo->query("SHOW TABLES in `nfomina`");
$tables = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $item) {
  if ($item['Tables_in_nfomina'] !== 'task') {
    // если нет таблицы task, то создаем ее
    createTableTask();
  } 
}

// проверка отправки задачи
if (!empty($_POST)) {

  if (isset($_POST['newTask'])) {

    // новая задача
    $description = htmlspecialchars($_POST['description']);
    if (strlen($description) < 1 && strlen($description) > 500) {
      print('Введите описание задачи не более 500 символов');
    } else {
      $assignedUserId = strlen($_POST['user']) !== 0 ? $_POST['user'] : $userId;
      $sth = $pdo->prepare("INSERT INTO task SET user_id = :user_id, description= :description, assigned_user_id = :assigned_user_id, is_done=false, date_added=NOW()");
      $sth->execute([
        ":user_id" => $userId,
        ":description" => $description,
        ":assigned_user_id" => $assignedUserId
        ]);
      $sth->fetchAll(PDO::FETCH_ASSOC);
      print('Задание добавлено');
    }

  } elseif (isset($_POST['delete'])) {

    // удаление задачи
    $sth = $pdo->prepare("DELETE FROM task WHERE id = :task_id LIMIT 1");
    $sth->execute([ ":task_id" => $_POST['taskId']]);
    $sth->fetchAll(PDO::FETCH_ASSOC);

  } elseif (isset($_POST['isDone'])) {

    // задача выполнена/невыполнена
    $sth = $pdo->prepare("UPDATE task SET is_done=NOT is_done WHERE id = :task_id LIMIT 1");
    $sth->execute([ ":task_id" => $_POST['taskId']]);
    $sth->fetchAll(PDO::FETCH_ASSOC);

  } elseif (isset($_POST['assignedUserId'])) {

    // передача задачи другому пользователю
    $sth = $pdo->prepare("UPDATE task SET assigned_user_id= :assigned_user_id WHERE id= :task_id LIMIT 1");
    $sth->execute([
      ":assigned_user_id" => $_POST['assignedUserId'],
      ":task_id" => $_POST['taskId']
      ]);
    $sth->fetchAll(PDO::FETCH_ASSOC);
  }
}

// Список задач с именем автора
$sqlTaskList = "
SELECT 
  t.id as id, 
  t.date_added as date_added, 
  t.description as description, 
  t.is_done as is_done, 
  u.login as login,
  `assigned_user_id`,
  `user_id`
FROM task t 
INNER JOIN user u 
ON t.assigned_user_id=u.id 
WHERE t.user_id = :user_id OR t.assigned_user_id = :user_id
ORDER BY t.date_added";
$sth = $pdo->prepare($sqlTaskList);
$sth->execute([":user_id" => $userId]);
$tasks = $sth->fetchAll(PDO::FETCH_ASSOC);

// Кол-во дел
$sqlQuantity = $pdo->prepare("SELECT COUNT(*) FROM `task` WHERE user_id = :user_id OR assigned_user_id = :user_id");
$sqlQuantity->execute([":user_id" => $userId]);
$taskQuantity = $sqlQuantity->fetchAll(PDO::FETCH_COLUMN);



function createTableTask() 
{
  $tableName = 'task';
  try {
    $pdo= new PDO("mysql:host=localhost;dbname=nfomina;charset=UTF8", "nfomina", "neto1914");
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE $tableName (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `assigned_user_id` int(11) DEFAULT NULL,
      `description` varchar(500) NOT NULL,
      `is_done` tinyint(1) NOT NULL DEFAULT '0',
      `date_added` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8" ;

    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица $tableName создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Список дел</title>
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
<form action="logout.php" method="POST" style="display: inline">
  <input type="submit" value="Выйти из аккаунта">
</form>

<h2>Добавить новую задачу:</h2>
<form class="form" action="list.php" method="post">
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
        <form action="list.php" method="post">

          <?php foreach ($task as $key => $value): ?>
            <td>
              <?php
              if ($key === 'date_added') {
                $date = date('d.m.Y H:i', strtotime($value)); ?>
                <span><?php echo $date?></span>
              <?php
              } elseif ($key === 'is_done') {
                $str = $value === '0' ? 'Невыполнено' : 'Выполнено'; 
                $taskId = $task['id']; ?>
                <input type="submit" name="isDone" value="<?php echo $str?>"/>
                <?php
              } else { ?>
                <span><?php echo $value?></span>
                
              <?php
              }
              ?>
            </td>
          <?php endforeach; ?>
          <td>
              <input type="hidden" name="taskId" value="<?php echo $taskId ?>">
              <select name="assignedUserId">
                <?php foreach ($users as $user): ?>
                  <option value="<?php echo $user['id'] ?>">
                    <?php echo $user['login'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <button type="submit">Делегировать</button>
          </td>
          <td>
             <input type="submit" name="delete" value="Удалить"/>
          </td>

          </form>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <h2>Количество дел: <?php echo $taskQuantity[0]?></h2>
  <?php else: ?>
    <p>Дел нет</p>
  <?php endif; ?>

</body>
</html>
