<?php
$servername = "localhost";  // Change if using a remote server
$username = "root";         // Default username for XAMPP/MAMP
$password = "";             // Default password is empty for XAMPP
$database = "lifeataimsr";   // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character encoding to UTF-8
$conn->set_charset("utf8");
