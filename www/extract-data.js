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

function extractColorKeysInfo() {
    // Get all elements with the class "color-key"
    var colorKeyElements = document.querySelectorAll('.color-key');

    // Initialize an empty array to store the extracted information
    var colorKeysArray = [];

    // Loop through each "color-key" element
    colorKeyElements.forEach(function (element) {
        // Extract the data attributes
        var colorKeyID = element.getAttribute('data-color-key-id');
        var backgroundColor = element.querySelector('.color-key-color').style.backgroundColor;
        var textColor = element.querySelector('.color-key-color').style.color;
        var textValue = element.querySelector('.color-key-text').value;

        // Create an object with the extracted information
        var colorKeyInfo = {
            'id': colorKeyID,
            'background_color': backgroundColor,
            'text_color': textColor,
            'text_value': textValue
        };

        // Push the object into the array
        colorKeysArray.push(colorKeyInfo);
    });

    // Convert the array to JSON
    var colorKeysJSON = JSON.stringify(colorKeysArray);

    // Return the JSON data if needed
    return colorKeysJSON;
}


// Add a click event listener to the button
document.getElementById('extractDataButton').addEventListener('click', function () {
    extractData();
    document.getElementById('colorKeyData').value = extractColorKeysInfo();
    const submitButton = document.getElementById("submit");
    // Programmatically click the button
    submitButton.click();
    // Form will be submitted when the button is clicked
});