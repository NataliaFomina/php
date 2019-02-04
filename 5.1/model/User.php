<?php

class User
{
  public function checkLogin($login) 
  {
    $sth = Di::get()->db()->prepare("SELECT id FROM user WHERE login = :login LIMIT 1");
    $sth->execute([":login" => $login]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function addNewUser($login, $pass) 
  {
    $sth = Di::get()->db()->prepare("INSERT INTO user SET login = :login, password = :password");
    return $sth->execute([
      ":login" => $login,
      ":password" => $pass,
    ]);
  }

  public function checkLoginAndPass($login, $pass) 
  {
    $sth = Di::get()->db()->prepare("SELECT id, login FROM user WHERE login = :login AND password = :password LIMIT 1");
    $sth->execute([
      ":login" => $login,
      ":password" => $pass,
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function addToSession($user)
  {
    $_SESSION['user'] = $user[0];
  }

  public function getUsersList()
  {
    $sth = Di::get()->db()->query("SELECT id, login FROM user");
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}
?>