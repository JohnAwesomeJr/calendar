<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add CSS for selected days */
        .month-day.selected {
            background-color: red;
        }
    </style>
</head>
<?php
function generateCalendar() {
    for ($day = 1; $day <= 365; $day++) {
        echo '<div class="month-day">' . $day . '</div>';
    }
}
?>





<?php
function generateCalendar2WithBuffer($year = 2018) {
    $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    $calendar = '<div class="calendar-layout">';
    foreach ($months as $month) {
        $calendar .= '<div class="month-container">';
        $calendar .= '<div class="month-title">' . $month . ' ' . $year . '</div>';
        $calendar .= '<div class="month-body">';
        
        // Get the number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, array_search($month, $months) + 1, $year);

        // Get the day of the week the month starts on (0 = Sunday, 1 = Monday, etc.)
        $firstDayOfWeek = date('w', strtotime("$year-$month-01"));

        // Calculate the total number of squares (35)
        $totalSquares = 35;

        // Loop through the squares
        for ($square = 1; $square <= $totalSquares; $square++) {
            // Calculate the day to display
            $day = $square - $firstDayOfWeek;

            // If it's a buffer day, use a different class
            if ($day <= 0 || $day > $daysInMonth) {
                $calendar .= '<div class="month-day buffer-day"></div>';
            } else {
                $calendar .= '<div class="month-day">' . $day . '</div>';
            }
        }

        $calendar .= '</div>'; // Close month-body
        $calendar .= '</div>'; // Close month-container
    }
    $calendar .= '</div>'; // Close year-container

    return $calendar;
}

?>
<body>
    <div class="page-menu">
        <h1>Title</h1>
        <?php
        $dateString = "2018-01-01"; // Date in the format "YYYY-MM-DD"
        $timestamp = strtotime($dateString);
        $dayOfWeek = date("l", $timestamp); // "l" format gives the full day name

        echo "The first day of January 2018 was a $dayOfWeek.";
        ?>
    </div>

    
    <div class="main-container">




            <?php 
            $calendarHTML = generateCalendar2WithBuffer(2018);
            echo $calendarHTML;
            ?>



        <div class="color-selector">
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        Mke! <br> <hr>
        </div>



    </div>

    <script>
        // JavaScript code for selecting and deselecting days
        const days = document.querySelectorAll('.month-day');
        const selectedDays = [];

        days.forEach(day => {
            day.addEventListener('click', () => {
                if (day.classList.contains('selected')) {
                    // Deselect the day
                    day.classList.remove('selected');
                    const index = selectedDays.indexOf(day.textContent);
                    if (index !== -1) {
                        selectedDays.splice(index, 1);
                    }
                } else {
                    // Select the day
                    day.classList.add('selected');
                    selectedDays.push(day.textContent);
                }
                console.log('Selected days:', selectedDays);
            });
        });
    </script>
</body>
</html>

