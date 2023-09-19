<?php
require_once('../menus/footer.php');
require_once('../menus/header.php');
function getAllNotes($year)
{
    require_once "../database-connect.php";
    $sql = " SELECT * FROM `myDb`.`day-notes` WHERE YEAR(CAST(date AS DATE)) = $year;";
    $result = $connection->query($sql);
    $notes = $result->fetch_all(MYSQLI_ASSOC);
    $connection->close();
    return $notes;
}
;
function generateMonthDates($year, $month)
{
    // Create a date for the first day of the month
    $firstDay = new DateTime("$year-$month-01");

    // Calculate the number of blank dates to add at the beginning
    $blankDays = ($firstDay->format('N') + 7) % 7;

    // Initialize an empty array to store the result
    $dates = array();

    // Add blank dates to the array
    for ($i = 0; $i < $blankDays; $i++) {
        $dates[] = '';
    }

    // Get the last day of the month
    $lastDay = new DateTime("$year-$month-" . $firstDay->format('t'));

    // Loop through the days of the month and add them to the array
    for ($currentDay = clone $firstDay; $currentDay <= $lastDay; $currentDay->modify('+1 day')) {
        $dates[] = $currentDay->format('Y-m-d');
    }
    $remainingBlankDays = 42 - count($dates);

    // Add blank dates to the end of the array
    for ($i = 0; $i < $remainingBlankDays; $i++) {
        $dates[] = '';
    }

    return $dates;
}
function addTitlesToMonth($year, $month)
{
    $daysOfWeek = array(
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    );
    $monthWithTitles = array_merge($daysOfWeek, generateMonthDates($year, $month));
    return $monthWithTitles;
}
function createNewArray($notes, $calendar)
{
    $newArray = array();
    $currentType = "";

    foreach ($calendar as $item) {
        if (in_array($item, ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"])) {
            $currentType = "title";
            $newArray[] = array("type" => $currentType, "data" => $item);
        } elseif ($item == "") {
            $currentType = "buffer";
            $newArray[] = array("type" => $currentType);
        } else {
            $currentType = "date";
            $dateArray = array("type" => 'date', "date" => $item, "data" => array());

            // Iterate through notes and add them to the dateArray
            foreach ($notes as $note) {
                if ($note["date"] == $item) {
                    $dateArray["data"][] = array("id" => $note["id"], "text" => $note["text"]);
                }
            }

            $newArray[] = $dateArray;
        }
    }

    return $newArray;
}
function buildCalendar($dataArray)
{
    $uniqueIdentafier = 0;
    foreach ($dataArray as $square) {
        if ($square['type'] == 'title') {
            echo '<div class="square title-day">' . $square['data'] . "</div>";
        }
        ;
        if ($square['type'] == 'buffer') {
            echo '<div class="square buffer-day"></div>';
        }
        ;
        if ($square['type'] == 'date') {
            $currentDateTime = new DateTime(date("Y-m-d"));
            $date = new DateTime($square['date']);
            $dayOfWeek = (int) $date->format('w');
            if ($date < $currentDateTime) {
                // The target date has already passed
                if ($dayOfWeek === 0 || $dayOfWeek === 6) {
                    echo '<div class="square datepassed weekend" data-date="' . $square['date'] . '" data-uniqueIdentafier="' . $uniqueIdentafier . '">';
                } else{
                    echo '<div class="square datepassed" data-date="' . $square['date'] . '" data-uniqueIdentafier="' . $uniqueIdentafier . '">';
                }
            } else {
                // The target date is in the future
                // Check if it's a weekend (Saturday or Sunday)
                if ($dayOfWeek === 0 || $dayOfWeek === 6) {
                    if ($currentDateTime == $date) {
                        echo '<div class="square weekend today" data-date="' . $square['date'] . '" data-uniqueIdentafier="' . $uniqueIdentafier . '">';
                    } else {
                        echo '<div class="square weekend" data-date="' . $square['date'] . '" data-uniqueIdentafier="' . $uniqueIdentafier . '">';
                    }
                } else {
                    if ($currentDateTime == $date) {
                        echo '<div class="square today" data-date="' . $square['date'] . '" data-uniqueIdentafier="' . $uniqueIdentafier . '">';
                    } else {
                        echo '<div class="square" data-date="' . $square['date'] . '" data-uniqueIdentafier="' . $uniqueIdentafier . '">';
                    }
                }
            }

            $date = strtotime($square['date']); // Convert the string to a timestamp
            $day = date("d", $date); // Format the timestamp to extract the day
            echo '<div class="dateSquare date">' . $day . '</div>';
            echo '<div class="note-holder">';


            if (empty($square['data'])) {
                // If $square['data'] is empty, add a default input
                echo '<input class="note" value="">';
            } else {
                foreach ($square['data'] as $note) {
                    echo '<input class="note" value="' . $note['text'] . '">';
                }
                echo '<input class="note input" value="">';
            }

            echo '</div>';

            echo '</div>';
        }
        ;
        $uniqueIdentafier = $uniqueIdentafier + 1;
    }
}


$year = '';
if ($_GET['year']) {
    $year = $_GET['year'];
} else {
    $year = date("Y");
    header("Location: ?year=$year");
}
$month = '';
if ($_GET['month']) {
    $month = $_GET['month'];
} else {
    $month = date("n");
    $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $currentURL&month=$month");
}
$fullMonthName = date("F", strtotime("2023-$month-01"));
$calendar = createNewArray(getAllNotes($year), addTitlesToMonth($year, $month));
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $fullMonthName . ' ' . $year ?> War Map
    </title>
    <link rel="stylesheet" href="/baseStyles.css">
    <link rel="stylesheet" href="styles.css">
</head>
<textarea style='display:none' name="saveSquare" id="saveSquare"></textarea>

<body>
    <?php echo headerPanel($year); ?>
    <div class="main-container">
        <div class="day-container">
            <?php buildCalendar($calendar); ?>
        </div>
    </div>
    <?php makeFooter(); ?>
</body>

</html>
<script src="/fitScreenIphone.js"></script>
<script src="addEmptyInputs.js"></script>
<script src="uploadToServer.js"></script>
<script src="UpdateJasonToBeSentToServer.js"></script>
<script src="hideDates.js"></script>