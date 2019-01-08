<?php

class Car 
{
  public $brand;
  public $model;
  protected $price;
  public $hp;
  public $discount = 0;

  public function __construct($brand, $model, $price, $hp) 
  {
    $this->brand = $brand;
    $this->model = $model;
    $this->price = $price;
    $this->hp = $hp;
  }

  public function getPrice() 
  {
    $price = $this->price;

    if ($this->discount) {
      $price *= (1 - $this->discount/100);
    }
    return $price;
  }

  public function showCar() {
    echo 'Бренд машины: ' . $this->brand . '<br/>';
    echo 'Модель: ' . $this->model . '<br/>';
    echo 'Цена: ' . $this->getPrice() . ' $'. '<br/>';
    echo 'Скидка: ' . $this->discount . '%' . '<br/>';
    echo 'Лошадиные силы: ' . $this->hp . '<br/>' .'<br/>';
  }
}

$alfaRomeo = new Car('Alfa Romeo', '145', 50000, 103);
$alfaRomeo->showCar();

$toyotaAltezza = new Car('Toyota Altezza', 'Gita 2.0', 800000, 160);
$toyotaAltezza->discount = 7;
$toyotaAltezza->showCar();

class TV 
{
  public $brand;
  public $model;
  protected $price;
  public $screenSize;
  public $discount = 0;
  public $resolution;
  protected $distance;

  public function __construct($brand, $model, $price, $resolution, $screenSize) 
  {
    $this->brand = $brand;
    $this->model = $model;
    $this->price = $price;
    $this->resolution = $resolution;
    $this->screenSize = $screenSize;
  }

  public function getPrice() 
  {
    $price = $this->price;

    if ($this->discount) {
      $price *= (1 - $this->discount/100);
    }
    return $price;
  }

  public function getDistance() 
  {
    $distance = $this->distance;
    if ($this->screenSize <= 42 ) {
      $distance = 2;
    } else {
      $distance = 3;
    } 

    return $distance;
  }

  public function showТv() {
    echo 'Бренд телевизора: ' . $this->brand . '<br/>';
    echo 'Модель: ' . $this->model . '<br/>';
    echo 'Цена: ' . $this->getPrice() . '  руб'. '<br/>';
    echo 'Скидка: ' . $this->discount . '%' . '<br/>';
    echo 'Разрешение: ' . $this->resolution . '<br/>';
    echo 'Диагональ экрана: ' . $this->screenSize . ' дюйм' . '<br/>';
    echo 'Расстояние просмотра до телевизора: ' . $this->getDistance() . ' м' . '<br/>'. '<br/>';
  }
}

$lg = new Tv('LG', '24TK410V-PZ', 11290, '720p HD', 23.6);
$lg->showТv();
$samsung = new Tv('Samsung', 'UE55NU7100U', 44990, '4K UHD', 54.6);
$samsung->discount = 10;
$samsung->showТv();

class Pen 
{
  public $brand;
  public $color;
  protected $weight;
  public $material;
  public $production;

  public function __construct($brand, $color, $material, $production) 
  {
    $this->brand = $brand;
    $this->color = $color;
    $this->material = $material;
    $this->production = $production;
  }

  public function getWeight()
  {
    $weight = $this->weight;
    if ($this->material === 'пластик') {
      $weight = 4;
    } elseif ($this->material === 'серебро') {
      $weight = 19;
    }  else {
      $weight = 'Вес не известен';
    }
    return $weight;
  }

  public function showPen() {
    echo 'Бренд ручки: ' . $this->brand . '<br/>';
    echo 'Цвет пасты: ' . $this->color . '<br/>';
    echo 'Материал: ' . $this->material . '<br/>';
    echo 'Вес: ' . $this->getWeight() . ' грамм' . '<br/>';
    echo 'Производитель: ' . $this->production . '<br/>' . '<br/>';
  }
}

$silverPen = new Pen('Sokolov', 'черный', 'серебро', 'Россия');
$silverPen->showPen();
$placticPen = new Pen('Pilot', 'синий', 'пластик', 'Китай');
$placticPen->showPen();

class Duck
{
  public $breed;
  protected $gender;
  protected $isMigrant;

  public function __construct($breed, $gender, $isMigrant) 
  {
    $this->breed = $breed;
    $this->gender = $gender;
    $this->isMigrant = $isMigrant;
  }

  public function getMigrant() 
  {
    $isMigrant = $this->isMigrant;
    if ($isMigrant === true) {
      $isMigrant = 'перелетная';
    } else {
      $isMigrant = 'не мигрирует';
    }
    return $isMigrant;
  }

  public function showDuck() 
  {
    echo 'Утка ' . $this->breed . '-  пол '. $this->gender . ', '  . $this->getMigrant() . '<br/>';
  } 
}
$krukva = new Duck('Кряква', 'женский', false);
$krukva->showDuck();
$gogol = new Duck('Гоголь', 'мужской', true);
$gogol->showDuck();

class Product 
{
  protected $category;
  protected $name;
  protected $price;
  public $count;

  public function totalSum() 
  {
    return $this->count * $this->price;
  }

  public function __construct($category, $name, $price) 
  {
    $this->category = $category;
    $this->name = $name;
    $this->price = $price;
  }

  public function getTotal() 
  {
    if($this->count !== null) {
      echo 'Общая сумма: ' . $this->totalSum() . "<br/>";
    } else {
      echo 'Не указано количество' . "<br/>";
    }
  }
}

$dress = new Product('dreses', 'Zara', 6000);
$dress->count = 10;
$dress->getTotal();
$pants = new Product('pants', 'Mango', 3500);
$pants->getTotal();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Class</title>
</head>
<body>
  
</body>
</html>
