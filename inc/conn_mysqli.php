<?php
$servername = "data.bounceapp.online";
$username = "bounce_db_admin";
$password = "9dhR4^%W";
$dbname = "bounce_app";
	
	global $conn;
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
?>