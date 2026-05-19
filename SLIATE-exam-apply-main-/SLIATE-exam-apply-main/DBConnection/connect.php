<?php
// Database connecting
$hostname = "localhost";
$username = "root";        
$password = "";           
$dbname = "exam_managment_system";

$conn = new mysqli($hostname, $username, $password, $dbname);

// Checking connection
if (!$conn) {
    die("There is an error");
}

return $conn;
?>
