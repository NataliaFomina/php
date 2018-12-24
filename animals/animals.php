<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$animals = [ 
  'Africa' => ['Mammuthus columbi', 'Arsinoitherium', 'Giraffa camelopardalis rothschildi', 'Loxodonta'], 
  'Asia' => ['Platybelodon'], 
  'Eurasia' =>  ['Megaloceros giganteus', 'Pteromys volans', 'Bison bonasus', 'Apodemus agrarius'],
  'South America' => ['Titanoides', 'Astrapotherium magnum'],
  'Australia' => ['Macropus', 'Palorchestes azael']
];

// $namesOfTwo = [];

// function checkArray($names) 
// {
//     $array = [];
//     foreach ($names as $name) {
//         $nameArray = explode(' ', $name);
//         if (count($nameArray) === 2) { 
//             array_push($array, $name);
//         } 
//     }
//     return $array;
// }

// foreach ($aminals as $area => $names) {
//     $result = checkArray($names);
//     if (count($result) !== 0) {
//     $namesOfTwo = array_merge($namesOfTwo, $result);
//     }  
// }

// массив из первых слов
// $firstWords = []; 
// foreach ($namesOfTwo as $word) {
//     $nameArray = explode(' ', $word);
//     array_push($firstWords, $nameArray[0]);
// }

// массив из вторых слов
// $secondWords = []; 
// foreach ($namesOfTwo as $word) {
//     $nameArray = explode(' ', $word);
//     array_push($secondWords, $nameArray[1]);
// }

foreach ($animals as $animal) {
  foreach ($animal as $name) {
    $count = count(explode(' ', $name));
    if($count === 2) {
      $namesOfTwo[] = $name;
      $firstWords[] = explode(' ', $name)[0];
      $secondWords[] = explode(' ', $name)[1];
    }
  }
}

// перемешать каждый массив слов
shuffle($firstWords);
shuffle($secondWords);

//смешанные названия
$fantasyAnimals = [];
for ($i=0; $i<count($firstWords); $i++) { 
  $name = $firstWords[$i] .' '. $secondWords[$i];
  array_push($fantasyAnimals, $name);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<h1>Выдуманные животные</h1>
<h2>1. Исходный массив</h2>

<?php 
  print_r($animals);
?>

<h2>2. Названия, состоящие из двух слов:</h2>
<?php
foreach ($namesOfTwo as $name) { ?>
  <p><?=$name ?></p>
<?php }
?>

<h2>3. "Фантазийные" названия</h2>
<?php
foreach ($fantasyAnimals as $name) { ?>
  <p><?=$name ?></p>
<?php }
?>
    
</body>
</html>
