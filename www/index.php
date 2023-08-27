<?php
$year = 2023;
function generateColorKeysFromJSON($jsonObject) {
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
        $html .= '<div class="color-key" data-color="'.$color.'" data-color-key-id="' . $colorKeyID . '">';
        $html .= '<div class="color-key-color" style="'.'background:' . $color . '; color:'.$font_color.';">' ."". '</div>';
        $html .= '<input class="color-key-text" placeholder="' . $text . '">';
        $html .= '</div>';
    }

    return $html;
}
// genarate calender
function generateCalendar2WithBuffer($year = 2018) {
    $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    $calendar = "";
    foreach ($months as $month) {
        $calendar .= '<div class="month-container">';
        $calendar .= '<div class="month-title">' . $month . ' ' . $year . '</div>';
        $calendar .= '<div class="month-body">';
        // Get the number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, array_search($month, $months) + 1, $year);

        // Get the day of the week the month starts on (0 = Sunday, 1 = Monday, etc.)
        $firstDayOfWeek = date('w', strtotime("$year-$month-01"));

        // Calculate the total number of squares (35)
        $totalSquares = 42;

        // Loop through the squares
        for ($square = 1; $square <= $totalSquares; $square++) {
            // Calculate the day to display
            $day = $square - $firstDayOfWeek;

            // If it's a buffer day, use a different class
            if ($day <= 0 || $day > $daysInMonth) {
                $calendar .= '<div class="month-day buffer-day"></div>';
            } else {
                $monthNumber = date('m', strtotime($month));
                $twoDigitDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                $calendar .= '<div class="month-day" data-day-id="' . "$year-$monthNumber-$twoDigitDay" . '">' . $day . '</div>';
            }
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
    </div>
    <div class="main-container">
        <div class="center-calender-layout">
            <div class="calendar-layout">
                <?php 
            $calendarHTML = generateCalendar2WithBuffer($year);
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

    </div>
</body>

</html>
<script src="selectDays.js"></script>
<script src="fitScreenIphone.js"></script>