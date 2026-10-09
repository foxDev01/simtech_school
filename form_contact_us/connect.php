<?php
// Загружаем конфигурацию (если ещё не загружена).
$config = $config ?? require __DIR__ . '/config.php';

$servername = $config['db']['host'];
$username   = $config['db']['user'];
$password   = $config['db']['pass'];
$dbname     = $config['db']['name'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
