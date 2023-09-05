<?php
function makeFooter() {
    $monthsArray = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // Get the current URL with query parameters
    $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Parse the query string
    $query = parse_url($currentURL, PHP_URL_QUERY);
    parse_str($query, $queryParams);

    // Get the year from the query parameters
    $year = isset($queryParams['year']) ? $queryParams['year'] : date('Y'); // Use the current year if not specified

    echo '<div class="month-tabs-menu">';
    // Add the "Dashboard" link
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    echo '<a class="month-tabs-tab dashboard-tab" href="' . $baseUrl . '">Dashboard</a>';
    foreach ($monthsArray as $month) {
        // Build the URL for each month
        $monthNumber = array_search($month, $monthsArray) + 1;
        $monthURL = strtok($baseUrl . '/month', '?') . "?year=$year&month=$monthNumber";
        echo '<a class="month-tabs-tab" href="' . $monthURL . '">' . $month . '</a>';
    }
    echo '</div>';
}
?>