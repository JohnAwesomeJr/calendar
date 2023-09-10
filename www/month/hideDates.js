// Get all square div elements
var squares = document.querySelectorAll('.square');

// Iterate through each square
squares.forEach(function (square) {
    var dateDiv = square.querySelector('.date'); // Get date div

    // Function to hide the date div with fade-out effect
    function hideDate() {
        dateDiv.classList.add('hidden');
    }

    // Function to show the date div with fade-in effect
    function showDate() {
        dateDiv.classList.remove('hidden');
    }

    // Add mouseenter event listener to the square
    square.addEventListener('mouseenter', function () {
        hideDate(); // Hide date div with fade-out effect when cursor enters the square
    });

    // Add mouseleave event listener to the square
    square.addEventListener('mouseleave', function () {
        showDate(); // Show date div with fade-in effect when cursor leaves the square
    });
});