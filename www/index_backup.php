<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>   	
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>


<?php
function generateCalendar() {
    for ($day = 1; $day <= 35; $day++) {
        if ($day % 7 === 1) {
            // Start a new week div
            echo '<div class="month-week">';
        }
        
        echo '<div class="month-day">' . $day . '</div>';
        
        if ($day % 7 === 0) {
            // Close the week div after the 7th day
            echo '</div>';
        }
    }
}
?>



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
		<div class="month-container">
			<div class="month-title">
				<span style="background:gray;">January</span>
			</div>
			<div class="month-body">
			<?php generateCalendar(); ?>
			</div>
		</div>
	</div>





  </body>
</html>
