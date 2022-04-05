<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$connect = new PDO('mysql:host=localhost;dbname=address_info', 'user', 'password');
$connect->prepare('INSERT INTO data (id, message) VALUES (:id, :message)')->execute(['message' => 'хахахаха попробуй вот это щенок']);
$statement = $connect->query('SELECT * FROM data');
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
echo var_dump($row);