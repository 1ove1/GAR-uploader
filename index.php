<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use GAR\Uploader\XMLReader\XMLReaderFactory;
use GAR\Uploader\DB\DBFactory;

define('ITERS', 1);

$time = time();

$models = [];
$readers = [];

$models = [
  DBFactory::getAddressObjectTable(),
  DBFactory::getAddressObjectParamsTable(),
  DBFactory::getHousesTable(),
  DBFactory::getAdminTable(),
  DBFactory::getMunTable(),
];

for($i = ITERS; $i > 0; $i--) {
  $readers[] = [
    XMLReaderFactory::execAddrObj(),
    XMLReaderFactory::execAddressObjParams(),
    XMLReaderFactory::execHouses(),  
    XMLReaderFactory::execAdminHierarchi(),
    XMLReaderFactory::execMunHierachi(),
  ];
}

for($i = ITERS; $i > 0; $i--) {
  $readers[$i-1][0]->exec($models[0]);
  $readers[$i-1][1]->exec($models[1]);
  $readers[$i-1][2]->exec($models[2]);
  $readers[$i-1][3]->exec($models[3]);
  $readers[$i-1][4]->exec($models[4]);
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

