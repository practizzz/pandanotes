<nav class="navbar">
    <div class="navbar-logo">
        <?php $profile_image = isset($_SESSION['image']) ? $_SESSION['image'] : 'profile.jpg'; ?>
        <a href="index.php"><img src="profilepics/<?php echo $profile_image; ?>" alt="Profile Image" class="logo-image"></a>
    </div>
    <div class="navbar-text">
        <a href="index.php" class="navbar-brand">Notes & Answers</a>
    </div>
    <button class="navbar-toggle" onclick="toggleNav()">
        <span class="navbar-toggle-icon">&#9776;</span>
    </button>
    <ul class="navbar-nav" id="navbarNav">
        <li><a href="./index.php" class="dropdown-toggle" >Dashboard</a></li>
        <li>
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown('notesDropdown')">My Notes</a>
            <div class="dropdown-content" id="notesDropdown">
                <a href="./notes.php">View Notes</a>
                <a href="./uploadnote.php">Upload Note</a>
            </div>
        </li>
        <li>
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown('discussDropdown')">Discuss</a>
            <div class="dropdown-content" id="discussDropdown">
                <a href="./viewquestions.php">View Questions</a>
                <a href="./askquestion.php">Ask Question</a>
            </div>
        </li>
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <li><a href="./users.php" class="admin-link">Users</a></li>
        <?php } ?>
        <li>
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown('accountDropdown')"><?php echo $_SESSION['username']; ?></a>
            <div class="dropdown-content" id="accountDropdown">
                <a href="viewprofile.php?name=<?php echo $_SESSION['username']; ?>">View Profile</a>
                <a href="userprofile.php?section=<?php echo $_SESSION['username']; ?>">Edit Profile</a>
                <a href="../logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>

<script>
    function toggleNav() {
        var navbarNav = document.getElementById("navbarNav");
        navbarNav.classList.toggle("active");
    }

    

    function toggleDropdown(id) {
    var dropdown = document.getElementById(id);
    var dropdowns = document.getElementsByClassName("dropdown-content");

    // Close all dropdowns except the one clicked
    for (var i = 0; i < dropdowns.length; i++) {
        if (dropdowns[i] !== dropdown) {
            dropdowns[i].classList.remove("show");
        }
    }

    // Toggle the clicked dropdown
    dropdown.classList.toggle("show");
}

    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-toggle')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

<style>
    /* Navbar css */
    .navbar {
        background: linear-gradient(135deg, #459bd4, #27bb65);
        border: none;
        border-radius: 10px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Shadow added */
        transition: box-shadow 0.3s ease;
        /* Transition added */
    }

    .navbar-brand {
        color: #1d4363;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);
        text-decoration: none;
        font-size: 24px;
        margin-right: 20px;
        padding: 10px;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .navbar-brand:hover {
        background-color: #78bae6;
    }

    .navbar-logo {
        display: flex;
        align-items: center;
    }

    .logo-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
    }

    .navbar-text {
        display: flex;
        align-items: center;
    }

    .navbar-nav {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 10px;
    }

    .navbar-nav li {
        margin-left: 20px;
        color: #bad6ec;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .navbar-nav li a {
        color: black;
        padding: 10px;
        text-decoration: none;
        transition: color 0.3s ease, text-shadow 0.3s ease;
        border-radius: 5px;
    }

    .navbar-nav li a:hover {
        text-shadow: 1px 1px 3px #aeface;
        background-color: #78bae6;
    }

    .navbar-toggle {
        display: none;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
    }

    .show { /* Added this class */
        display: block !important;
    }

    .dropdown-toggle {
    position: relative;
    display: inline-block;
    color: #c0dcf3;
    text-decoration: none;
    cursor: pointer;
    border-radius: 10px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: red;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
}

.dropdown-content a {
    color: #1d4363;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #e9e9e9;
}

.dropdown-toggle.active + .dropdown-content {
    display: block;
    /* background-color: red; */
}

#accountDropdown {
    position: absolute;
    right: 0;
    z-index: 1;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
}

@media (max-width: 768px) {
    #accountDropdown {
        top: auto;
        bottom: calc(100% + 10px); /* Position above the username link */
    }
}


    @media (max-width: 768px) {
        /* Adjustments for smaller screens */
        .navbar-nav {
            display: none;
            margin: 10px;
        /* flex-direction: row; */
        position: absolute;
        top: 5px;
        left: 0;
        /* bottom: 60px; */
        /* width: 50vw; */
        background-color: #459bd4;
        padding: 10px 0;
        border-radius: 10px;
        overflow-y: auto; /* Added overflow-y property */
        max-height: calc(100vh - 60px); /* Added max-height property */
        z-index: 1000;
        }

        .navbar-nav.active {
            display: flex;
            flex-direction: row;
            position: absolute;
            align-items: center;
        }

        .navbar-toggle {
            display: block;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        .navbar-toggle-icon {
            display: inline-block;
            margin-right: 5px;
        }

        .navbar-brand {
            margin-right: 0;
        }

        .dropdown-content {
            position: static;
            background-color: transparent;
            box-shadow: none;
        }

        .dropdown-content a {
            color: black;
            /* position: fixed; */
            margin-left: 20px;
            padding: 12px 16px;
            box-shadow: #1d4363;
            text-decoration: none;
            display: block;
            color: #fff;
        }
        .navbar-nav li {
        margin-left: 0; /* Remove margin */
        margin-bottom: 10px; /* Add margin between items */
    }


    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }
    .dropdown-toggle.active + .dropdown-content {
    display: block;
    position: static;
    box-shadow: none;
}
#accountDropdown {
    position: relative;
    right: 0;
    z-index: 1111;
    background-color: #459bd4;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
}


    }











    @media (max-width: 480px) {
        /* Adjustments for even smaller screens */
        .navbar-brand {
            font-size: 18px;
            margin-right: 10px;
            padding: 8px;
        }

        .navbar-nav li {
            margin-left: 10px;
        }

        .navbar-nav li a {
            font-size: 14px;
        }
    }
</style>
