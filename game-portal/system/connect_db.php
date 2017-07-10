<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName = "game-portal";

try {
    $conn = new PDO("mysql:host=$dbServername;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }