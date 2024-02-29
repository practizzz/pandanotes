<style>
.popup {
  position: fixed;
  margin-top: 50vh;
  left: 50%;
  transform: translateX(-50%);
  visibility: hidden;
  background-color: #f44336;
  color: white;
  text-align: center;
  border-radius: 20px;
  padding: 16px;
  z-index: 1;
}

.popup.show {
  visibility: visible;
}
</style>
<?php session_start(); ?>
  <?php include 'includes/connection.php'; ?>
  <?php include 'includes/header.php'; ?>
  <?php include 'includes/navbar.php'; ?>

  <?php
  if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $user = $row['username'];
        $pass = $row['password'];
        $name = $row['name'];
        $email = $row['email'];
        $role = $row['role'];
        $course = $row['course'];
        $image = $row['image'];
        // if (password_verify($password, $pass)) {
        if ($password == $pass) {
          $_SESSION['id'] = $id;
          $_SESSION['username'] = $username;
          $_SESSION['name'] = $name;
          $_SESSION['email'] = $email;
          $_SESSION['role'] = $role;
          $_SESSION['course'] = $course;
          $_SESSION['image'] = $image;
          echo "<script>window.location.href= 'dashboard/';</script>";
        } else {
          echo "<div class='popup'>
                  <span class='popuptext' id='myPopup'>Invalid username/password</span>
                </div>";
        }
      }
    } else {
      echo "<div class='popup'>
              <span class='popuptext' id='myPopup'>Invalid username/password</span>
            </div>";
    }
  }
  ?>

  <div class="login-card">
    <h1>Log-in</h1><br>
    <form method="POST">
      <input type="text" name="user" placeholder="Username" required="">
      <div class="password-container">
        <input type="password" name="pass" id="passwordInput" placeholder="Password" required="">
      </div>
      <input type="submit" name="login" class="login login-submit" value="Login">
    </form>

    <div class="login-help">
      <a href="signup.php">Register</a>
    </div>
  </div>

  <script>
var popup = document.querySelector(".popup");

popup.classList.add("show");

setTimeout(function () {
  popup.classList.remove("show");
}, 1500);

  </script>

</body>

</html>