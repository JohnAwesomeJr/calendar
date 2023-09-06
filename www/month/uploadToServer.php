<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the JSON data from the request body
    $json_data = file_get_contents('php://input');

    // Parse the JSON data into a PHP array
    $data = json_decode($json_data, true);

    if ($data !== null) {



    




        // require_once "../database-connect.php";

        // // Delete all rows for the specified day
        // $deleteQuery = "DELETE FROM `myDb`.`day-notes` WHERE DATE(date) = ";
        // if ($connection->query($deleteQuery) === TRUE) {
        // } else {
        //     echo "Error deleting rows for the year $year<br>";
        // }

        // // Loop through the JSON data and insert new data into the database
        // foreach ($data as $item) {
        //     $date = $item['date'];
        //     $backgroundColor = $item['backgroundColor'];
        //     $textColor = $item['textColor'];

        //     $insertQuery = "INSERT INTO `myDb`.`days` (date, color, `text-color`) VALUES ('$date', '$backgroundColor', '$textColor')";
        //     if ($connection->query($insertQuery) === TRUE) {
        //     } else {
        //         echo "Error inserting new row for date: $date<br>";
        //     }
        // }





// Decode the JSON array string into a PHP array
$json_data = json_decode($json_data, true);

$file_path = "fake.txt"; // Specify the path to the file where you want to save the data.

// Check if the JSON data was successfully decoded
if ($data !== null && isset($data[0]['date'])) {
    // Get the 'date' value from the first item as a string
    $dateToSave = $data[0]['date'];

    // Save the date as a plain string to the file
    if (file_put_contents($file_path, $dateToSave) !== false) {
        echo "Data has been written to the file successfully.";
    } else {
        echo "Unable to write data to the file.";
    }
} else {
    echo "JSON decoding failed or 'date' value not found.";
}


















        
        // Output the received data to the PHP error log
        error_log(print_r($data, true));
        // You can also send a response back to the client if needed
        $response = ['message' => 'Data received successfully'];
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle JSON parsing error
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid JSON data']);
    }
} else {
    // Handle non-POST requests
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only POST requests are allowed']);
}
?>