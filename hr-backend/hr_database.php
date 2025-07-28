<?php

$dbServerName = 'localhost';
$dbUsername = 'root';
$dbPassword = 'Umvubo-7';
$dbName = 'hr_project';
$dbPort = 3306;

$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName, $dbPort);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


