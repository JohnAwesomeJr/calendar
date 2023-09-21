// Hide all scrollbars when the page loads
const noteHolders = document.querySelectorAll('.note-holder');

noteHolders.forEach((noteHolder) => {
  noteHolder.style.overflowY = 'hidden';
});

// Add an event listener to each note-holder div
noteHolders.forEach((noteHolder) => {
  noteHolder.addEventListener('mouseenter', () => {
    noteHolder.style.overflowY = 'scroll';
  });

  noteHolder.addEventListener('mouseleave', () => {
    noteHolder.style.overflowY = 'hidden';
  });
});