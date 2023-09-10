<style>
    #adminWindow {
        width: 500px;
        height: 500px;
        background: white;
        overflow: scroll;
        position: fixed;
        bottom: 0px;
        right: 0px;
        z-index: 3000;
        border: solid black 2px;
        padding: 20px;
        pointer-events: auto;
        user-select: text;
    }

    .admin-menu-button {
        position: fixed;
        bottom: 50%;
        right: 0px;
        border: solid black 1px;
        width: fit-content;
        height: fit-content;
        padding: 3px;
        pointer-events: auto;
    }
</style>

<pre id="adminWindow">
    <textarea style='width:400px;height:300px;pointer-events: auto;user-select: text;' name="saveSquare" id="saveSquare"></textarea>
</pre>

<div id="open-admin-menu" class="admin-menu-button" style="z-index:4000; background:green;">Open</div>
<div id="close-admin-menu" class="admin-menu-button" style="z-index:5000;background:red;">Close</div>

<script>
    var openButton = document.getElementById("open-admin-menu");
    var closeButton = document.getElementById("close-admin-menu");
    var adminMenu = document.getElementById('adminWindow');
    openButton.addEventListener("click", openAdminPanel);
    closeButton.addEventListener("click", closeAdminPanel);

    document.addEventListener("DOMContentLoaded", function () {
        var adminMenuState = localStorage.getItem('adminMenuState');
        if (adminMenuState === 'opened') {
            openAdminPanel();
        } else {
            closeAdminPanel();
        }
    });

    function openAdminPanel() {
        adminMenu.style.display = "block";
        closeButton.style.display = "block";
        openButton.style.display = "none";
        localStorage.setItem('adminMenuState', 'opened');
    }

    function closeAdminPanel() {
        adminMenu.style.display = "none";
        closeButton.style.display = "none";
        openButton.style.display = "block";
        localStorage.setItem('adminMenuState', 'closed');
    }
</script>