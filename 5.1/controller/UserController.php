<?php
include 'model/User.php';

class UserController
{
  public function logout()
  {
    session_destroy();
    Di::get()->render('index.php');
  }

  public function signUp()
  {
    if(!empty($_POST)) {
      if(isset($_POST['login']) && isset($_POST['pass'])) {
    
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $user = new User();
        $result = $user->checkLogin($login);
    
        if (count($result) === 0) {
            $res = $user->addNewUser($login, $pass);

          if($res) {
            $currentUser = $user->checkLoginAndPass($login, $pass);
            $user->addToSession($currentUser);
            header('Location: index.php?c=task&a=list');
          }
    
        } else {
          print("Данный логин $login уже существует, ввведите другой логин");
          Di::get()->render('signUp.php');
        }
      }
    
    } else {
      Di::get()->render('signUp.php');
    }
  }

  public function signIn() 
  {
    if (!empty($_POST)) {
      if(isset($_POST['login']) && isset($_POST['pass'])) {

        $user = new User();
        $result = $user->checkLoginAndPass($_POST['login'], $_POST['pass']);

        if (count($result) !== 0) {
          $user->addToSession($result);
          header('Location: index.php?c=task&a=list');
        } else {
          print("Не верный логин или пароль");
          Di::get()->render('signIn.php');
        }
      }

    } else {
      Di::get()->render('signIn.php');
    }
  }
  

}
?>