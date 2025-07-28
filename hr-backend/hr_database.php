<?php

$dbServerName = 'localhost';
$dbUsername = 'root';
$dbPassword = 'gangca-7';
$dbName = 'hr_project';

$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


