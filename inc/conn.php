<?php
$servername = "data.bounceapp.online";
$username = "bounce_db_admin";
$password = "9dhR4^%W";
$dbname = "bounce_app";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    global $conn;
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>