<?php

if ( (count($argv) <= 2 && $argv[1] !== '--today') ) {
  echo 'Ошибка! Аргументы не заданы. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}';
} else if ($argv[1] === '--today') {
  costsOfDay($argv);
} else {
  addCosts($argv);
}

// функция расходов за день
function costsOfDay($argv) 
{
  $resource = fopen('money.csv', 'r');
  $data = [];
  // скачиваем данные
  while (!feof($resource)) {
    $fileStr = fgetcsv($resource);
    if ($fileStr != false) {
      $data[] = $fileStr;
    }
  }
  fclose($resource);

  $count = 0;
  $today = str_replace("-", ".", date('Y-m-d'));
  foreach ($data as $item) {
    if ($today === $item[0]) {
      $count += (int) $item[1];
    }
  }
  if ($count === 0) {
    echo "$today расходов не было!";
  } else {
    echo "$today расход за день: $count";
  }
}

// функция добавления расходов
function addCosts($argv) 
{
  $today = str_replace("-", ".", date('Y-m-d'));
  $name = implode(" ", array_slice($argv, 2));  
  $data = [ $today, $argv[1], $name ];

  $resource = fopen('money/money.csv', 'a+');
  fputcsv($resource, $data);
  fclose($resource);

  echo "Добавлена строка: $data[0], $data[1], $data[2]";
}
?>

