<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pdw_travel';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
}
// echo "Connecting to Database";

?>