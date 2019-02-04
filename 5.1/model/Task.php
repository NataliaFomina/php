<?php

class Task
{
  public function getList($userId)
  {
    $sql = "
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
    $sth = Di::get()->db()->prepare($sql);
    $sth->execute([":user_id" => $userId]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getQuantity($userId)
  {
    $sth = Di::get()->db()->prepare("SELECT COUNT(*) FROM `task` WHERE user_id = :user_id OR assigned_user_id = :user_id");
    $sth->execute([":user_id" => $userId]);
    $result = $sth->fetchAll(PDO::FETCH_COLUMN);  
    return $result[0];
  }

  public function addNewTask($desc, $user, $userId) {
    $description = htmlspecialchars($desc);
    $assignedUserId = strlen($user) !== 0 ? $user : $userId;
    $sth = Di::get()->db()->prepare("INSERT INTO task SET user_id = :user_id, description= :description, assigned_user_id = :assigned_user_id, is_done=false, date_added=NOW()");
    return $sth->execute([
    ":user_id" => $userId,
    ":description" => $description,
    ":assigned_user_id" => $assignedUserId
    ]);
  }

  public function isDone($taskId) 
  {
    $sth = Di::get()->db()->prepare("UPDATE task SET is_done=NOT is_done WHERE id = :task_id LIMIT 1");
    return $sth->execute([ ":task_id" => $taskId]);
  }

  public function assignedUser($assignedUserId, $taskId)
  {
    $sth = Di::get()->db()->prepare("UPDATE task SET assigned_user_id= :assigned_user_id WHERE id= :task_id LIMIT 1");
    return $sth->execute([
      ":assigned_user_id" => $assignedUserId,
      ":task_id" => $taskId
    ]);
  }

  public function delete($taskId)
  {
    $sth = Di::get()->db()->prepare("DELETE FROM task WHERE id = :task_id LIMIT 1");
    return $sth->execute([ ":task_id" => $taskId]);
  }
}

?>