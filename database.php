<?php
$host = 'localhost';
$user = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$dbname = 'Quizzer'; // Replace with your database name

$mysqli = new mysqli($host, $user, $password, $dbname);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}


?>
