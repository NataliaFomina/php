<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<?php
  if(count($argv) === 1) {
    echo 'Напишите название страны';
  }

  $url = 'https://data.gov.ru/opendata/7704206201-country/data-20180609T0649-structure-20180609T0649.csv?encoding=UTF-8';
  $urlAlter = 'https://raw.githubusercontent.com/netology-code/php-2-homeworks/master/files/countries/opendata.csv';
  $data = file_get_contents($url);
  //проверка url
  if ( $data ===  false ){
    $data = file_get_contents($urlAlter);
  }

  $destination = implode(" ", array_slice($argv, 1)); 
  $data = explode(PHP_EOL, $data);

  //записываем массив с массивами
  $arrayContries = [];
  foreach ($data as $item) {
    $array = [];
    $array = explode(',', $item);
    $arrayContries[] = $array;
  }

  //проверка в массиве нужную страну
  $country;
  $visa;
  foreach ($arrayContries as $item) {
    $place = trim($item[1],'"');
    if ($destination === $place) {
      $country = $place;
      $visa = trim($item[3],'"');
    } 
  }

  if (isset($country) && isset($visa)) {
    echo "$country: $visa";
  } else {
    echo "$destination: страна не найдена";
  }
  
?>
</body>
</html>
