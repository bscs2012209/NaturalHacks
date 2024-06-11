<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'fyp';

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed");
  }

?>