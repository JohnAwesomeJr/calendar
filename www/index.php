<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="styles.css">

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
                $monthNumber = date('m', strtotime($month));
                $twoDigitDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                $calendar .= '<div class="month-day" data-day-id="' . "$year-$monthNumber-$twoDigitDay" . '">' . $day . '</div>';
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



        <div class="color-selector-menu">
            <div class="color-selector-title">Color Keys</div>


            <div class="color-key">
                <div class="color-key-color">
                    color
                </div>
                <div class="color-key-text">
                    I am the form text
                </div>
            </div>


            <div class="color-key">
                <div class="color-key-color">
                    color
                </div>
                <div class="color-key-text">
                    form text
                </div>
            </div>




        </div>



    </div>
    <script>
    const divs = document.querySelectorAll('div[data-day-id]');
    let lastClickedIndex = -1;
    let isSelecting = false;

    divs.forEach((div, index) => {
        div.addEventListener('click', (event) => {
            if (event.shiftKey) {
                isSelecting = true;
                const minIndex = Math.min(lastClickedIndex, index);
                const maxIndex = Math.max(lastClickedIndex, index);

                divs.forEach((d, i) => {
                    if (i >= minIndex && i <= maxIndex) {
                        d.classList.add('selected');
                    }
                });
            } else if ((event.metaKey && navigator.platform.indexOf('Mac') !== -1) || event.ctrlKey) {
                // Toggle the selected class for the clicked div
                if (div.classList.contains('selected')) {
                    div.classList.remove('selected');
                } else {
                    div.classList.add('selected');
                }
            } else {
                isSelecting = false;
                lastClickedIndex = index;

                // Deselect all divs except the clicked one
                divs.forEach((d, i) => {
                    if (i !== index) {
                        d.classList.remove('selected');
                    }
                });

                if (div.classList.contains('selected')) {
                    div.classList.remove('selected');
                } else {
                    div.classList.add('selected');
                }
            }
        });
    });
    </script>



    <script>
    // This is to set the body size for iphone
    function adjustBodySize() {
        const body = document.body;

        const viewportHeight = window.innerHeight;
        const safeAreaTop = window.safeArea?.insetTop || 0;
        const safeAreaBottom = window.safeArea?.insetBottom || 0;

        body.style.paddingTop = safeAreaTop + 'px';
        body.style.paddingBottom = safeAreaBottom + 'px';
        body.style.height = (viewportHeight - safeAreaTop - safeAreaBottom) + 'px';
    }

    window.addEventListener('resize', adjustBodySize);
    adjustBodySize(); // Call it initially
    </script>
</body>

</html>