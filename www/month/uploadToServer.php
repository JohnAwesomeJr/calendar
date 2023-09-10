<?php
// Read the JSON data from the request body
$json_data = file_get_contents('php://input');

// Specify the path to the file where you want to save the data.
$file_path = "fake.txt";
$json = json_decode($json_data, true);
$jsonInput = $json['input'];
$finishedArray = json_decode($jsonInput, true);
$date = $finishedArray[0]['date'];
$finalOutput = "";

require_once "../database-connect.php";

// Use prepared statement for deleting rows
$deleteQuery = "DELETE FROM `myDb`.`day-notes` WHERE DATE(date) = ?";
$stmt = $connection->prepare($deleteQuery);
$stmt->bind_param("s", $date);

if ($stmt->execute() === TRUE) {
} else {
    echo "Error deleting rows for the date: $date<br>";
}

foreach ($finishedArray as $note) {
    // Use prepared statement for inserting rows
    $insertQuery = "INSERT INTO `myDb`.`day-notes` (date, text) VALUES (?, ?)";
    $stmt = $connection->prepare($insertQuery);
    $stmt->bind_param("ss", $date, $note['note']);

    if ($stmt->execute() === TRUE) {
    } else {
        echo "Error inserting new row for date: $date<br>";
    }
}

// Save the JSON data to the file
file_put_contents($file_path, $finalOutput);

// Output the received data to the PHP error log
error_log($json_data);
?>