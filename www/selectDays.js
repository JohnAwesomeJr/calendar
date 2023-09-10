// ---------------------------------------------------------------------------
// Select Days
let selectedDataIds = [];
const divs = document.querySelectorAll('div[data-day-id]');
let lastClickedIndex = -1;
let isSelecting = false;

divs.forEach((div, index) => {
    div.addEventListener('click', (event) => {
        const dataDayId = div.getAttribute('data-day-id'); // Get the data-day-id attribute

        if (event.shiftKey) {
            isSelecting = true;
            const minIndex = Math.min(lastClickedIndex, index);
            const maxIndex = Math.max(lastClickedIndex, index);

            divs.forEach((d, i) => {
                if (i >= minIndex && i <= maxIndex) {
                    d.classList.add('selected');
                    // Add data-day-id to the selectedDataIds array
                    const id = d.getAttribute('data-day-id');
                    if (!selectedDataIds.includes(id)) {
                        selectedDataIds.push(id);
                    }
                }
            });
        } else if ((event.metaKey && navigator.platform.indexOf('Mac') !== -1) || event.ctrlKey) {
            // Toggle the selected class for the clicked div
            if (div.classList.contains('selected')) {
                div.classList.remove('selected');
                // Remove data-day-id from the selectedDataIds array
                const idIndex = selectedDataIds.indexOf(dataDayId);
                if (idIndex !== -1) {
                    selectedDataIds.splice(idIndex, 1);
                }
            } else {
                div.classList.add('selected');
                // Add data-day-id to the selectedDataIds array
                if (!selectedDataIds.includes(dataDayId)) {
                    selectedDataIds.push(dataDayId);
                }
            }
        } else {
            isSelecting = false;
            lastClickedIndex = index;

            // Deselect all divs except the clicked one
            divs.forEach((d, i) => {
                if (i !== index) {
                    d.classList.remove('selected');
                    // Remove data-day-id from the selectedDataIds array
                    const idIndex = selectedDataIds.indexOf(d.getAttribute('data-day-id'));
                    if (idIndex !== -1) {
                        selectedDataIds.splice(idIndex, 1);
                    }
                }
            });

            if (div.classList.contains('selected')) {
                div.classList.remove('selected');
                // Remove data-day-id from the selectedDataIds array
                const idIndex = selectedDataIds.indexOf(dataDayId);
                if (idIndex !== -1) {
                    selectedDataIds.splice(idIndex, 1);
                }
            } else {
                div.classList.add('selected');
                // Add data-day-id to the selectedDataIds array
                if (!selectedDataIds.includes(dataDayId)) {
                    selectedDataIds.push(dataDayId);
                }
            }
        }

        console.log(selectedDataIds); // Log the selectedDataIds array
    });
});


// ---------------------------------------------------------------------------
// apply styles to days
function applyStylesToSelectedDays(styles) {
    const selectedDays = document.querySelectorAll('.month-day.selected');

    selectedDays.forEach(function (day) {
        if (styles.backgroundColor === 'reset') {
            day.style.removeProperty('background-color');
        } else {
            day.style.backgroundColor = styles.backgroundColor;
        }

        if (styles.color === 'reset') {
            day.style.removeProperty('color');
        } else {
            day.style.color = styles.color;
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const colorKeys = document.querySelectorAll('.color-key');

    colorKeys.forEach(function (key) {
        key.addEventListener('click', function () {
            const dataColor = key.getAttribute('data-color');
            const colorKeyStyles = window.getComputedStyle(key.querySelector(
                '.color-key-color'));

            const styles = {
                backgroundColor: dataColor === 'reset' ? 'reset' : colorKeyStyles.backgroundColor.trim(),
                color: dataColor === 'reset' ? 'reset' : colorKeyStyles.color.trim(),
                border: "black"
            };

            applyStylesToSelectedDays(styles);
        });
    });
});



