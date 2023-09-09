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

$deleteQuery = "DELETE FROM `myDb`.`day-notes` WHERE DATE(date) = '$date'";
if ($connection->query($deleteQuery) === TRUE) {
} else {
    echo "Error deleting rows for the year $year<br>";
}


foreach ($finishedArray as $note) {
    $queryIntro = "INSERT INTO `myDb`.`day-notes` (date, text) VALUES";
    $finalQuery = "";
    $finalQuery = $finalQuery . $queryIntro . " ('" . $date . "','" . $note['note'] . "');";
    if ($connection->query($finalQuery) === TRUE) {
    } else {
        echo "Error inserting new row for date: $date<br>";
    }
}


// Save the JSON data to the file
file_put_contents($file_path, $finalOutput);

// Output the received data to the PHP error log
error_log($json_data);
?>