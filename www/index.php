<?php
require_once('menus/footer.php');
require_once('menus/header.php');
require_once "database-connect.php";

function generateColorKeysFromArray($dataArray)
{
    // Initialize an empty string to store the HTML
    $html = '';

    // Loop through the data and generate HTML for each item
    foreach ($dataArray as $item) {
        // Sanitize inputs to prevent potential HTML or script injection
        $colorKeyID = htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8');
        $color = htmlspecialchars($item['color'], ENT_QUOTES, 'UTF-8');
        $text = htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8');
        $font_color = htmlspecialchars($item['text-color'], ENT_QUOTES, 'UTF-8');

        // Build the HTML structure for each item
        $html .= '<div class="color-key" data-color="' . $color . '" data-color-key-id="' . $colorKeyID . '">';
        $html .= '<div class="color-key-color" style="' . 'background:' . $color . '; color:' . $font_color . ';">' . "" . '</div>';
        $html .= '<input class="color-key-text" value="' . $text . '">';
        $html .= '</div>';
    }

    return $html;
}
function generateCalendar2WithBuffer($year = 2018, $data)
{
    $monthsArray = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
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
        
            // Check if it's a weekend (Saturday or Sunday)
            $isWeekend = ($dayOfWeekCounter == 0 || $dayOfWeekCounter == 6);
        
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
        
                // Add the "month-day-weekend" class if it's a weekend
                $dayClass = $isWeekend ? 'month-day-weekend' : '';
        
                // Add the day square with style and class
                $calendar .= '<div class="month-day ' . $dayClass . '" data-day-id="' . "$year-$monthNumber-$twoDigitDay" . '" style="' . $dayStyle . '">';
        
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

$year = '';
if ($_GET['year']) {
    $year = $_GET['year'];
} else {
    $year = date("Y");
    header("Location: ?year=$year");
}

$sql = " SELECT * FROM `myDb`.`days` WHERE YEAR(date) = '$year'; ";
$result = $connection->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
$sql = " SELECT * FROM `myDb`.`colors`;";
$result = $connection->query($sql);
$colors = $result->fetch_all(MYSQLI_ASSOC);
$connection->close();
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $year ?> War Map</title>
    <link rel="stylesheet" href="baseStyles.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form id="dataForm" method="POST" action="update-cal.php">
        <textarea name="jsonData" id="jsonDataInput" style="display:none;"></textarea>
        <textarea name="colorKeyData" id="colorKeyData" style="display:none;"></textarea>
        <input type="text" name="yearData" id="yearData" value="<?= $year; ?>" style="display:none;">
        <input id="submit" type="submit" value="Submit Form" style="display:none;">
    </form>
    <?php echo headerPanel($year); ?>
    <div class="main-container">
        <div class="center-calender-layout">
            <div class="calendar-layout">
                <?php
                $calendarHTML = generateCalendar2WithBuffer($year, $data);
                echo $calendarHTML;
                ?>
            </div>
        </div>
        <div class="color-selector-menu">
            <div class="color-selector-title">Color Keys</div>
            <?php
            echo generateColorKeysFromArray($colors);;
            ?>
            <div style="display:flex;
                        justify-content: center;
                        align-items: center; 
                        padding:20px;">
                <button id="extractDataButton">Save Changes</button>
            </div>
        </div>
    </div>
    <?php
    makeFooter();
    ?>
</body>

</html>
<script src="selectDays.js"></script>
<script src="fitScreenIphone.js"></script>
<script src="extract-data.js"></script>