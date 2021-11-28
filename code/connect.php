<?php
$servername = "mysql";
$username = "root";
$password = "qwerty";

// Create connection
$conn = new mysqli($servername, $username, $password, "Social_Network");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?> 