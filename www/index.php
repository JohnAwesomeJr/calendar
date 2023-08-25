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
    for ($day = 1; $day <= 35; $day++) {


        echo '<div class="month-day">' . $day . '</div>';


    }
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



        <div class="calender-layout">

            <div class="month-container">
                <div class="month-title">
                    <span>Febuary</span>
                </div>
                <div class="month-body" id="calendar">
                        <?php generateCalendar(); ?>
                </div>
            </div>

        </div>



        <div class="color-selector">
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
            I am the best <br> <hr>
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

