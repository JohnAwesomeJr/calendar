// Function to extract and update data
function extractData() {
    // Select all days with background colors applied
    const daysWithColors = document.querySelectorAll('.month-day[style*="background-color"]');

    // Initialize an array to store data
    const data = [];

    // Loop through each day with background color
    daysWithColors.forEach(day => {
        // Extract the date from data-day-id attribute
        const date = day.getAttribute('data-day-id');

        // Extract background color from inline style
        const backgroundColor = day.style.backgroundColor;

        // Extract text color from inline style
        const textColor = day.style.color;

        // Push the data for this day into the array
        data.push({ date, backgroundColor, textColor });
    });

    // Convert the array to a JSON string
    const jsonData = JSON.stringify(data);

    // Update the hidden textarea with the JSON data
    const jsonDataTextarea = document.getElementById('jsonDataInput');
    jsonDataTextarea.value = jsonData;
}

// Add a click event listener to the button
document.getElementById('extractDataButton').addEventListener('click', function () {
    extractData();
    const submitButton = document.getElementById("submit");
    // Programmatically click the button
    submitButton.click();
    // Form will be submitted when the button is clicked
});