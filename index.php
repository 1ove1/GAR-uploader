<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use GAR\Uploader\XMLReaderFactory\XMLReaderFactory;
use GAR\Uploader\DBFactory\DBFactory;

define('ITERS', 100);

$time = time();

$models = [];
$readers = [];

$models = [
  DBFactory::getAddressInfoTable(),
  DBFactory::getHousesTable(),
];

for($i = ITERS; $i > 0; $i--) {
  $readers[] = [
    XMLReaderFactory::execAddrObj(),
    XMLReaderFactory::execHouses(),  
  ];
}

for($i = ITERS; $i > 0; $i--) {
  $readers[$i-1][0]->exec($models[0]);
  $readers[$i-1][1]->exec($models[1]);
}

print_r($time - time());

// \GAR\Uploader\Log::write('enter to database...');
// $connect = new PDO('mysql:host=localhost;dbname=address_info', 'user', 'password');
// \GAR\Uploader\Log::write('connected!');

// \GAR\Uploader\Log::write('making query...');
// $connect->prepare('INSERT INTO tests (message) VALUES (:message)')->execute(['message' => 'хахахаха попробуй вот это щенок']);
// $statement = $connect->query('SELECT * FROM tests');

// \GAR\Uploader\Log::write('parse result...');
// $row = $statement->fetchAll(PDO::FETCH_ASSOC);

