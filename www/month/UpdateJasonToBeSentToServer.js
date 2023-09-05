function postData(inputId, endpoint) {
    // Get the input element by its ID
    const inputElement = document.getElementById(inputId);

    if (!inputElement) {
        console.error(`Input element with ID '${inputId}' not found.`);
        return;
    }

    // Get the value from the input element
    const inputValue = inputElement.value;

    // Create an object with the data you want to send
    const data = {
        input: inputValue // You can structure your data as needed
    };

    // Make the POST request
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(responseData => {
            // Handle the response data here
            console.log('Response Data:', responseData);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
postData('myInput', 'https://example.com/api/endpoint');
