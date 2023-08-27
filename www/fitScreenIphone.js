// This is to set the body size for iphone
function adjustBodySize() {
    const body = document.body;

    const viewportHeight = window.innerHeight;
    const safeAreaTop = window.safeArea?.insetTop || 0;
    const safeAreaBottom = window.safeArea?.insetBottom || 0;

    body.style.paddingTop = safeAreaTop + 'px';
    body.style.paddingBottom = safeAreaBottom + 'px';
    body.style.height = (viewportHeight - safeAreaTop - safeAreaBottom) + 'px';
}

window.addEventListener('resize', adjustBodySize);
adjustBodySize(); // Call it initially