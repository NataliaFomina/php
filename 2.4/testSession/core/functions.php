<?php

function rediredt() 
{
  if (empty($_SESSION)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit('<h1>Ошибка 403</h1><p>Перейти к <a href="index.php">Перейти к авторизации</a></p>');
  }
}

function calcMark($questions, $ansTrue) 
{
  return ceil(((100/$questions) * $ansTrue) / 20);
}

?>