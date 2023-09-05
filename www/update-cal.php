<?php
// Check if the jsonData field is set in the POST request
if (isset($_POST['jsonData']) && isset($_POST['yearData'])) {
    // Get the JSON data from the POST request
    $jsonData = $_POST['jsonData'];
    $colorKeyData = $_POST['colorKeyData'];
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
            } else {
                echo "Error inserting new row for date: $date<br>";
            }
        }

        $colorKeyDataDecode = json_decode($colorKeyData, true);
        array_shift($colorKeyDataDecode);
        $newItem = array(
            array(
            'id' => '0',  // Change '0' to the desired ID for the reset item
            'background_color' => 'reset',  // Reset background color
            'text_color' => 'reset',  // Reset text color
            'text_value' => 'reset'  // Reset text value
            )
        );
        $mergedArray = array_merge($newItem, $colorKeyDataDecode);

        

        // Drop all rows from the "colors" table
        $connection->query("DELETE FROM colors");

        // Insert data from the JSON array
        foreach ($mergedArray as $item) {
            $id = $item['id'];
            $color = $item['background_color'];
            $text = $item['text_value'];
            $textColor = $item['text_color'];

            // Perform the INSERT operation
            $insertQuery = "INSERT INTO myDb.colors ( color, text, `text-color`) VALUES ( '$color', '$text', '$textColor')";
            
            if ($connection->query($insertQuery) === false) {
                echo "Error inserting data: ";
            }
        }

        // Close the database connection
        $connection->close();
        header('Location: /?year=' . $_POST["yearData"]);
    } else {
        // Handle JSON decoding error
        echo 'Failed to decode JSON data.';
    }
} else {
    // Handle case where jsonData or yearData is not set in the POST request
    echo 'No JSON data or year data received.';
}