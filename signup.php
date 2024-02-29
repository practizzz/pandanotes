<?php include 'includes/connection.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php
$errors = [];
if (isset($_POST['signup'])) {
    // Sanitize
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    $role = $_POST['role'];
    $course = $_POST['course'];
    $gender = $_POST['gender'];

    // Validate
    if (empty($username) || !ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 20) {
        $errors[] = "Username is required and must be alphanumeric between 4 to 20 characters.";
    }
    if (empty($name) || !ctype_alpha(str_replace(' ', '', $name)) || strlen($name) < 5 || strlen($name) > 30) {
        $errors[] = "Name is required and must contain only alphabets and spaces (5-30 characters).";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required.";
    }
    if (empty($password) || strlen($password) < 6 || strlen($password) > 50) {
        $errors[] = "Password is required and must be between 6 to 50 characters.";
    }
    if ($password !== $repassword) {
        $errors[] = "Passwords do not match.";
    }

    // Check
    $checkusername = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $checkusername);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errors[] = "Username is already taken. Please choose a different one.";
    }
    mysqli_stmt_close($stmt);

    $checkemail = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkemail);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errors[] = "Email is already taken. Please choose a different one.";
    }
    mysqli_stmt_close($stmt);

    // If no errors
    if (empty($errors)) {
        // $password = password_hash($password, PASSWORD_DEFAULT);
        $joindate = date("F j, Y");

        $query = "INSERT INTO users (username, name, email, password, role, course, gender, joindate, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '')";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $username, $name, $email, $password, $role, $course, $gender, $joindate);
        $result = mysqli_stmt_execute($stmt);
        if ($result && mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<script>alert('SUCCESSFULLY REGISTERED'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error occurred. Please try again.');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    }
}
?>


<br>

<div class="container">
    <div class="form">
        <form id="contactform" method="POST">
            <div class="row">
                <div class="col">
                    <p class="contact"><label for="name">Name</label></p>
                    <input id="name" name="name" placeholder="First and Last name" required="" tabindex="1" type="text"
                        value="<?php if (isset($_POST['signup'])) { echo $_POST['name']; } ?>">
                </div>
                <div class="col">
                    <p class="contact"><label for="email">Email</label></p>
                    <input id="email" name="email" placeholder="example@domain.com" required="" type="email"
                        value="<?php if (isset($_POST['signup'])) { echo $_POST['email']; } ?>">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="contact"><label for="username">Create a username</label></p>
                    <input id="username" name="username" placeholder="Username" required="" tabindex="2" type="text"
                        value="<?php if (isset($_POST['signup'])) { echo $_POST['username']; } ?>">
                </div>
                <div class="col">
                    <p class="contact"><label for="password">Create a password</label></p>
                    <input type="password" id="password" name="password" required="" placeholder="Password">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="contact"><label for="repassword">Confirm your password</label></p>
                    <input type="password" id="repassword" name="repassword" required="" placeholder="Confirm Password">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="contact"><label for="gender">Gender </label></p>
                    <select class="select-style gender" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col">
                    <p class="contact"><label for="role">I am a...</label></p>
                    <select class="select-style gender" name="role">
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="contact"><label for="course">I teach/study in...</label></p>
                    <select class="select-style gender" name="course">
                        <option value="Class-11">Class-11</option>
                        <option value="Class-12">Class-12</option>
                    </select>
                </div>
            </div>
            <input class="button" name="signup" id="submit" tabindex="5" value="Sign me up!" type="submit">
        </form>
    </div>
</div>


</body>

</html>