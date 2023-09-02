<?php
header("Location: /");
// Check if the jsonData field is set in the POST request
if (isset($_POST['jsonData']) && isset($_POST['yearData'])) {
    // Get the JSON data from the POST request
    $jsonData = $_POST['jsonData'];
    // Get the year from the form input
    $year = $_POST['yearData'];

    // Decode the JSON data into a PHP array
    $data = json_decode($jsonData, true);

    // Check if the JSON data was successfully decoded
    if ($data !== null) {
        require_once "database-connect.php";

        // Delete all rows for the specified year
        $deleteQuery = "DELETE FROM `myDb`.`days` WHERE YEAR(date) = '$year'";
        if ($connection->query($deleteQuery) === TRUE) {
            echo "All rows for the year $year deleted successfully<br>";
        } else {
            echo "Error deleting rows for the year $year<br>";
        }

        // Loop through the JSON data and insert new data into the database
        foreach ($data as $item) {
            $date = $item['date'];
            $backgroundColor = $item['backgroundColor'];
            $textColor = $item['textColor'];

            $insertQuery = "INSERT INTO `myDb`.`days` (date, color, `text-color`) VALUES ('$date', '$backgroundColor', '$textColor')";
            if ($connection->query($insertQuery) === TRUE) {
                echo "New row inserted successfully for date: $date<br>";
            } else {
                echo "Error inserting new row for date: $date<br>";
            }
        }

        // Close the database connection
        $connection->close();
    } else {
        // Handle JSON decoding error
        echo 'Failed to decode JSON data.';
    }
} else {
    // Handle case where jsonData or yearData is not set in the POST request
    echo 'No JSON data or year data received.';
}
