<?php
// Database connecting
$hostname = "localhost";
$username = "root";        
$password = "";           
$dbname = "exam_managment_system";

$conn = new mysqli($hostname, $username, $password, $dbname);


// Return the connection object
return $conn;
?>