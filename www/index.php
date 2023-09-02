<?php


require_once "database-connect.php";
$year = 2023;
// SQL query to retrieve all days of a given year (in this case, 2023)
$sql = " SELECT * FROM `myDb`.`days` WHERE YEAR(date) = '$year'; ";
// Execute the query
$result = $connection->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
// echo "<pre>";
// print_r($data);
// echo "</pre>";
// Close the database connection
$connection->close();


function generateColorKeysFromJSON($jsonObject)
{
    // Decode the JSON object into a PHP associative array
    $data = json_decode($jsonObject, true);
    // Initialize an empty string to store the HTML
    $html = '';
    // Loop through the data and generate HTML for each item
    foreach ($data as $item) {
        // Sanitize inputs to prevent potential HTML or script injection
        $colorKeyID = htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');
        $color = htmlspecialchars($item['color'], ENT_QUOTES, 'UTF-8');
        $text = htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8');
        $font_color = htmlspecialchars($item['fontColor'], ENT_QUOTES, 'UTF-8');
        // Build the HTML structure for each item
        $html .= '<div class="color-key" data-color="' . $color . '" data-color-key-id="' . $colorKeyID . '">';
        $html .= '<div class="color-key-color" style="' . 'background:' . $color . '; color:' . $font_color . ';">' . "" . '</div>';
        $html .= '<input class="color-key-text" placeholder="' . $text . '">';
        $html .= '</div>';
    }

    return $html;
}
// genarate calender
$months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

function generateCalendar2WithBuffer($year = 2018, $monthsArray, $data)
{
    $calendar = "";
    foreach ($monthsArray as $month) {
        $calendar .= '<div class="month-container">';
        $calendar .= '<div class="month-title">' . $month . ' ' . $year . '</div>';
        $calendar .= '<div class="month-body">';

        // Add day headers (Mo, Tu, We, etc.)
        $calendar .= '<div class="month-day-header">Su</div>';
        $calendar .= '<div class="month-day-header">Mo</div>';
        $calendar .= '<div class="month-day-header">Tu</div>';
        $calendar .= '<div class="month-day-header">We</div>';
        $calendar .= '<div class="month-day-header">Th</div>';
        $calendar .= '<div class="month-day-header">Fr</div>';
        $calendar .= '<div class="month-day-header">Sa</div>';

        // Get the number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, array_search($month, $monthsArray) + 1, $year);

        // Get the day of the week the month starts on (0 = Sunday, 1 = Monday, etc.)
        $firstDayOfWeek = date('w', strtotime("$year-$month-01"));

        // Calculate the total number of squares (35)
        $totalSquares = 42;

        // Initialize a counter for the day of the week headers
        $dayOfWeekCounter = 0;

        // Loop through the squares
        for ($square = 1; $square <= $totalSquares; $square++) {
            // Calculate the day to display
            $day = $square - $firstDayOfWeek;

            // Check if it's today's date
            $isToday = false;
            if ($day == date('j') && $month == date('F') && $year == date('Y')) {
                $isToday = true;
            }

            // If it's a buffer day, use a different class
            if ($day <= 0 || $day > $daysInMonth) {
                $calendar .= '<div class="month-day buffer-day"></div>';
            } else {
                $twoDigitDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                $monthNumber = date('m', strtotime("$year-$month-01")); // Calculate the correct month number

                $daysDate = $year . '-' . $monthNumber . '-' . $twoDigitDay;

                // Check if there's color information for this date in the database
                $color = ''; // Default background color
                $textColor = ''; // Default text color
                foreach ($data as $item) {
                    if ($item['date'] == $daysDate) {
                        $color = $item['color'];
                        $textColor = $item['text-color'];
                        break; // Stop searching when a match is found
                    }
                }

                // Apply the background color and text color as inline styles, but only if there's a color specified
                $dayStyle = '';
                if (!empty($color)) {
                    $dayStyle .= 'background-color: ' . $color . ';';
                }
                if (!empty($textColor)) {
                    $dayStyle .= 'color: ' . $textColor . ';';
                }

                // Add the day square with style and class
                $calendar .= '<div class="month-day" data-day-id="' . "$year-$monthNumber-$twoDigitDay" . '" style="' . $dayStyle . '">';

                // Add a transparent yellow div on top if it's today's date
                if ($isToday) {
                    $calendar .= '<div class="today"></div>';
                }

                $calendar .= $day . '</div>'; // Close month-day
            }

            // Increment the day of the week counter and reset it if it's Sunday (6)
            $dayOfWeekCounter = ($dayOfWeekCounter + 1) % 7;
        }

        $calendar .= '</div>'; // Close month-body
        $calendar .= '</div>'; // Close month-container
    }
    return $calendar;
}






// Example JSON data (you can replace this with your actual JSON data)
$jsonObject = '[
{"id": 0, "color": "reset", "text": "reset", "fontColor": "black"},
{"id": 7, "color": "pink", "text": "", "fontColor": "black"},
{"id": 1, "color": "red", "text": "", "fontColor": "white"},
{"id": 13, "color": "darkred", "text": "", "fontColor": "white"},
{"id": 8, "color": "#ffd68a", "text": "", "fontColor": "black"},
{"id": 6, "color": "orange", "text": "", "fontColor": "white"},
{"id": 14, "color": "#ca6f00", "text": "", "fontColor": "white"},
{"id": 9, "color": "#ffffb9", "text": "", "fontColor": "black"},
{"id": 4, "color": "yellow", "text": "", "fontColor": "black"},
{"id": 15, "color": "#b5b500", "text": "", "fontColor": "white"},
{"id": 10, "color": "lightgreen", "text": "", "fontColor": "black"},
{"id": 2, "color": "green", "text": "", "fontColor": "white"},
{"id": 16, "color": "darkgreen", "text": "", "fontColor": "white"},
{"id": 11, "color": "lightblue", "text": "", "fontColor": "black"},
{"id": 3, "color": "blue", "text": "", "fontColor": "white"},
{"id": 17, "color": "darkblue", "text": "", "fontColor": "white"},
{"id": 12, "color": "#d657ff", "text": "", "fontColor": "black"},
{"id": 5, "color": "#e200ff", "text": "", "fontColor": "white"},
{"id": 18, "color": "#9a00ae", "text": "", "fontColor": "white"}
]';
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $year ?> War Map</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-menu">
        <img src="consulting-logo.png" height=30>
        <p style="margin: 0px 20px;"><?php echo $year ?> War Map calendar</p>
        <button id="extractDataButton">Save Changes</button>

        <!-- Hidden form field to store the extracted data as JSON -->
        <form id="dataForm" method="POST" action="update-cal.php">
            <textarea name="jsonData" id="jsonDataInput" style="display:none;"></textarea>
            <input type="text" name="yearData" id="yearData" value="<?= $year; ?>" style="display:none;">
            <input id="submit" type="submit" value="Submit Form" style="display:none;">
        </form>
    </div>
    <div class="main-container">
        <div class="center-calender-layout">
            <div class="calendar-layout">
                <?php
                $calendarHTML = generateCalendar2WithBuffer($year, $months, $data);
                echo $calendarHTML;
                ?>
            </div>
        </div>
        <div class="color-selector-menu">
            <div class="color-selector-title">Color Keys</div>

            <?php echo generateColorKeysFromJSON($jsonObject); ?>

        </div>
    </div>
    <div class="month-tabs-menu">
        <?php foreach ($months as $month) : ?>
            <div class="month-tabs-tab">
                <?php echo $month; ?>
            </div>
        <?php endforeach; ?>

    </div>
</body>

</html>
<script src="selectDays.js"></script>
<script src="fitScreenIphone.js"></script>
<script src="extract-data.js"></script>