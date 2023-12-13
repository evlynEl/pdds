<?php

$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "northwind";

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);


// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }