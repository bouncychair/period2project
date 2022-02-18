<?php
$servername = "localhost"; // Write your servername
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, "Toctic");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?> 
