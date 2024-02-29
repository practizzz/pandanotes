function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-250px";
    } else {
        sidebar.style.left = "0";
    }
}

function toggleDropdown(dropdownId) {
    var dropdown = document.getElementById(dropdownId);
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        if (dropdowns[i].id !== dropdownId) {
            dropdowns[i].style.display = "none";
        }
    }
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}

function toggleCollapse(id) {
    var collapse = document.getElementById(id);
    var collapses = document.querySelectorAll('.collapse');
    collapses.forEach(function (item) {
        if (item.id !== id) {
            item.style.display = "none";
        }
    });
    if (collapse.style.display === "block") {
        collapse.style.display = "none";
    } else {
        collapse.style.display = "block";
    }
}