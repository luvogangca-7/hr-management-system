<?php

$dbServerName = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'hr_project';

$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

