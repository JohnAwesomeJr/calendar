<?php
$hostname = "calendar-calender_db-1";
$username = "user";
$password = "test";
$database = "myDb";

// Create a database connection
$connection = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>