<?php

$serverName = "localhost";
$userName = "root";
$password = "";
$baseName = "sotiroglou";
$mysqli = new mysqli($serverName, $userName, $password, $baseName);
$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {
    echo "Η σύνδεση με τη MySQL απέτυχε!: " . $mysqli->connect_error;
    exit();
}
?>