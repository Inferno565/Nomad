<?php
$host = "localhost";
$user = "root";
$database_name = "crm";
$password = "";
$conn = mysqli_connect($host, $user, $password, $database_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
