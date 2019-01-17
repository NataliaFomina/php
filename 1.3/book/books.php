<?php
define('URL', 'https://www.googleapis.com/books/v1/volumes?q=');
if(count($argv) < 2) {
  exit('Введите название книги');
}

$query = urlencode(trim(implode(' ', array_slice($argv, 1))));
$request = URL . $query . '&startIndex=0&maxResults=15';

$booksData = file_get_contents($request);
$booksData = json_decode($booksData, true);

if(json_last_error() !== JSON_ERROR_NONE) {
  echo 'Ошибка данных!';
}

$resource = fopen('books.csv', 'a+');
foreach ($booksData['items'] as $item) {
  $book = [];
  $book[] = $item['id'];
  $book[] = $item['volumeInfo']['title'];
  if(in_array('authors', $item['volumeInfo'])) {
    $book[] = $item['volumeInfo']['authors'][0];
  } else {
    $book[] = 'NULL';
  }
  fputcsv($resource, $book);
}
fclose($resource);
  
?>
