<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use GAR\Uploader\XMLReaderFactory\XMLReaderFactory;
use GAR\Uploader\DBFactory\DBFactory;

// DBFactory::getAddressInfoTable();

XMLReaderFactory::excecAddrObj();

// \GAR\Uploader\Log::write('enter to database...');
// $connect = new PDO('mysql:host=localhost;dbname=address_info', 'user', 'password');
// \GAR\Uploader\Log::write('connected!');

// \GAR\Uploader\Log::write('making query...');
// $connect->prepare('INSERT INTO tests (message) VALUES (:message)')->execute(['message' => 'хахахаха попробуй вот это щенок']);
// $statement = $connect->query('SELECT * FROM tests');

// \GAR\Uploader\Log::write('parse result...');
// $row = $statement->fetchAll(PDO::FETCH_ASSOC);

