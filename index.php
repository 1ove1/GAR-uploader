<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use LAB2\XMLReaderFactory\XMLReaderFactory;
use LAB2\DBFactory\DBFactory;

// DBFactory::getAddressInfoTable();

XMLReaderFactory::excecAddrObj();

// \LAB2\Log::write('enter to database...');
// $connect = new PDO('mysql:host=localhost;dbname=address_info', 'user', 'password');
// \LAB2\Log::write('connected!');

// \LAB2\Log::write('making query...');
// $connect->prepare('INSERT INTO tests (message) VALUES (:message)')->execute(['message' => 'хахахаха попробуй вот это щенок']);
// $statement = $connect->query('SELECT * FROM tests');

// \LAB2\Log::write('parse result...');
// $row = $statement->fetchAll(PDO::FETCH_ASSOC);

