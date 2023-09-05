function trackCurrentSquareIdentifier(identifierVariable) {
    // Function to update the current square identifier
    function updateCurrentSquare(input) {
        const square = input.closest('.square');
        if (square) {
            const identifier = square.getAttribute('data-uniqueidentafier');
            identifierVariable.value = identifier;
        }
    }

    // Add input event listeners to all input elements with class "note"
    const inputs = document.querySelectorAll('.note');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            updateCurrentSquare(input);
        });
        input.addEventListener('blur', () => {
            identifierVariable.value = null; // Reset when the input loses focus
        });
    });

    // Initially check for a focused input
    const focusedInput = document.querySelector('.note:focus');
    if (focusedInput) {
        updateCurrentSquare(focusedInput);
    }
}
function removeEmptyInputs(uniqueIdentifier) {
    // Find the square element with the specified unique identifier
    const square = document.querySelector(`.square[data-uniqueidentafier="${uniqueIdentifier}"]`);

    if (square) {
        // Find all input elements with the class "note" within the square
        const inputs = square.querySelectorAll('.note');

        // Get the currently focused element
        const focusedElement = document.activeElement;

        // Iterate through the inputs and remove the empty ones, if they are not focused
        inputs.forEach(input => {
            if (input.value.trim() === '' && input !== focusedElement) {
                input.remove();
            }
        });
    }
}
function addEmptyInputToSquare(identifier) {
    // Find the square element with the specified identifier
    const square = document.querySelector(`.square[data-uniqueidentafier="${identifier}"]`);

    if (square) {
        // Create a new empty input element
        const emptyInput = document.createElement('input');
        emptyInput.className = 'note';
        emptyInput.value = '';

        // Append the new input to the note-holder div within the square
        const noteHolder = square.querySelector('.note-holder');
        noteHolder.appendChild(emptyInput);
    }
}
let currentSquare = { value: null };
document.addEventListener('keyup', (event) => {
    trackCurrentSquareIdentifier(currentSquare);
    removeEmptyInputs(currentSquare.value);
    addEmptyInputToSquare(currentSquare.value);

});