<nav class="navbar">
    <div class="navbar-logo">
        <a href="index.php"><img src="images/logo.png" alt="Logo" class="logo-image"></a>
    </div>
    <div class="navbar-text">
        <a href="index.php" class="navbar-brand">Study Share & Discuss</a>
    </div>
    <button class="navbar-toggle" aria-label="Toggle navigation">
        <span class="navbar-toggle-icon">&#9776;</span>
    </button>
    <ul class="navbar-nav">
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="dashboard/">Upload Notes</a></li>
        <li><a href="dashboard/">Discuss</a></li>
    </ul>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const navbarToggle = document.querySelector(".navbar-toggle");
        const navbarNav = document.querySelector(".navbar-nav");

        navbarToggle.addEventListener("click", function () {
            navbarNav.classList.toggle("active");
        });
    });


</script>