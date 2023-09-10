
// Function to create JSON from inputs in a square
function createSquareJSON(square) {
    const date = square.getAttribute('data-date');
    const notes = square.querySelectorAll('.note');
    const noteData = [];

    notes.forEach(noteInput => {
        const value = noteInput.value;
        noteData.push({ date, note: value });
    });

    return JSON.stringify(noteData);
}

// Function to update the saveSquare input
function updateSaveSquareInput() {
    const focusedInput = document.querySelector('.note:focus');
    if (focusedInput) {
        const square = focusedInput.closest('.square');
        const saveSquareInput = document.getElementById('saveSquare');

        if (square && saveSquareInput) {
            const squareJSON = createSquareJSON(square);
            saveSquareInput.value = squareJSON;
            postData('saveSquare', '/month/uploadToServer.php');
        }
    }
}

// Timer to update the input after a 1-second pause
let timer;
document.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(updateSaveSquareInput, 100);
});

// Event listener for focusing on different inputs
document.addEventListener('focus', updateSaveSquareInput, true);
