<?php
include('includes/connection.php');
include('includes/adminheader.php'); ?>

<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $userid = $row['id'];
        $usernm = $row['username'];
        $userpassword = $row['password'];
        $useremail = $row['email'];
        $name = $row['name'];
        $profilepic = $row['image'];
        $bio = $row['about'];
    }

    if (isset($_POST['uploadphoto'])) {
        $image = $_FILES['image']['name'];
        $ext = $_FILES['image']['type'];
        $validExt = array("image/gif", "image/jpeg", "image/pjpeg", "image/png");
        if (empty($image)) {
            $picture = $profilepic;
        } else if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 1024000) {
            echo "<script>alert('Image size is not proper');
 window.location.href='userprofile.php';</script>";
        } else if (!in_array($ext, $validExt)) {
            echo "<script>alert('Not a valid image');
        window.location.href='userprofile.php';</script>";
        } else {
            $folder = 'profilepics/';
            $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $picture = rand(1000, 1000000) . '.' . $imgext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $folder . $picture)) {
                $queryupdate = "UPDATE users SET image = '$picture' WHERE id= '$userid' ";
                $result = mysqli_query($conn, $queryupdate) or die(mysqli_error($conn));
                if (mysqli_affected_rows($conn) > 0) {
                    echo "<script>alert('Profile Photo uploaded successfully');
        	window.location.href= 'userprofile.php';</script>";
                } else {
                    echo "<script>alert('Error! ..try again');</script>";
                }
            } else {
                echo "<script>alert('Error occured while uploading! ..try again');</script>";
            }
        }
    } else {
        $picture = $row['image'];
    }

    if (isset($_POST['update'])) {
        // Sanitize input data
        $_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $_POST['bio'] = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
        $_POST['currentpassword'] = trim($_POST['currentpassword']);
        $_POST['newpassword'] = trim($_POST['newpassword']);
        $_POST['confirmnewpassword'] = trim($_POST['confirmnewpassword']);

        // Validate input data
        $errors = [];
        if (empty($_POST['name']) || strlen($_POST['name']) < 2 || strlen($_POST['name']) > 30 || !ctype_alpha(str_replace(' ', '', $_POST['name']))) {
            $errors[] = "Name is required and must contain only alphabets and spaces (2-30 characters).";
        }
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email address is required.";
        }
        if (strlen($_POST['bio']) > 150) {
            $errors[] = "Bio should not exceed 150 characters.";
        }
        if (empty($_POST['currentpassword']) || strlen($_POST['currentpassword']) < 6 || strlen($_POST['currentpassword']) > 50) {
            $errors[] = "Current password is required and must be between 6 to 50 characters.";
        }
        // if (!password_verify($_POST['currentpassword'], $userpassword)) {
        if ($_POST['currentpassword'] != $userpassword) {
            $errors[] = "Current password is wrong.";
        }
        if (!empty($_POST['newpassword']) && ($_POST['newpassword'] !== $_POST['confirmnewpassword'])) {
            $errors[] = "New password and Confirm New password do not match.";
        }

        // If no errors, proceed with update
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $bio = $_POST['bio'];

            // If new password is provided, hash it
            if (!empty($_POST['newpassword'])) {
                // $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
                $newpassword = $_POST['newpassword'];
                $updatequery = "UPDATE users SET password = '$newpassword', name='$name', email= '$email', about='$bio' WHERE id='$userid'";
            } else {
                $updatequery = "UPDATE users SET name = '$name', email='$email', about='$bio' WHERE id = '$userid'";
            }

            $result = mysqli_query($conn, $updatequery);
            if ($result && mysqli_affected_rows($conn) > 0) {
                echo "<script>alert('PROFILE UPDATED SUCCESSFULLY'); window.location.href='userprofile.php';</script>";
            } else {
                echo "<script>alert('An error occurred, Try again!');</script>";
            }
        } else {
            // Display errors
            foreach ($errors as $error) {
                echo "<center><font color='red'>$error</font></center>";
            }
        }
    }

}
?>

<div id="wrapper">
    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                    <h1 class="page-header">
                        Welcome to your Profile -
                        <small>
                            <?php echo $_SESSION['name']; ?>
                        </small>
                    </h1>
                    <form role="form" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="post_image">Profile Image</label>
                            <img class="img-responsive" src="profilepics/<?php echo $picture; ?>" alt="Photo">
                            <input type="file" name="image">
                            <br>
                            <button type="submit" name="uploadphoto" class="btn btn-primary" value="upload photo">Upload
                                photo</button>
                        </div>
                    </form>
                    <form role="form" action="" method="POST" enctype="multipart/form-data">
                        <hr>
                        <div class="form-group">
                            <label for="user_title">User Name</label>
                            <input type="text" name="username" class="form-control" value=" <?php echo $username; ?>"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_author">Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="user_tag">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $useremail; ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="post_content">Bio</label>
                            <textarea class="form-control" name="bio" id="" cols="30" rows="10"><?php echo $bio; ?>
                    </textarea>
                        </div>

                        <div class="form-group">
                            <label for="usertag">Current Password</label>
                            <input type="password" name="currentpassword" class="form-control"
                                placeholder="Enter Current password" required>
                        </div>
                        <div class="form-group">
                            <label for="usertag">New Password <font color='brown'> (changing password is optional)
                                </font></label>
                            <input type="password" name="newpassword" class="form-control"
                                placeholder="Enter New Password">
                        </div>
                        <div class="form-group">
                            <label for="usertag">Confirm New Password</label>
                            <input type="password" name="confirmnewpassword" class="form-control"
                                placeholder="Re-Enter New Password">
                        </div>
                        <hr>
                        <button type="submit" name="update" class="btn btn-primary" value="Update User">Update
                            User</button>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <style>
        /* Html and body css */
        /* Hide the default scrollbar */
        body::-webkit-scrollbar {
            width: 10px;
            /* Width of the scrollbar */
        }

        /* Track */
        body::-webkit-scrollbar-track {
            background: wheat;
            /* Color of the track */
            border-radius: 10px;
        }

        /* Handle */
        body::-webkit-scrollbar-thumb {
            background: #888;
            /* Color of the scrollbar handle */
            border-radius: 10px;
        }

        /* Handle on hover */
        body::-webkit-scrollbar-thumb:hover {
            background: #494949;
            /* Color of the scrollbar handle on hover */
            border-radius: 10px;
        }

        html {
            background: linear-gradient(135deg, #4aa3df, #2ecc71);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            background: linear-gradient(135deg, #4aa3df, #2ecc71);
            margin-bottom: 60px;
            /* Adjust margin-bottom to accommodate footer height */
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Profile Page Styling */
        .container-fluid {
            width: 90%;
            max-width: 600px;
            /* Set maximum width */
            margin: 50px auto;
            background: linear-gradient(135deg, #4aa3df, #99b2c9, #2ecc71);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container-fluid form {
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 20px;
        }

        .container-fluid .profile-pic-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .img-responsive {
            width: 150px;
            height: auto;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        input[type="file"] {
            margin: 10px;
        }

        .container-fluid .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }

        .container-fluid .col {
            display: flex;
            flex-direction: column;
        }

        .container-fluid .contact {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .container-fluid input[type="text"],
        .container-fluid input[type="email"],
        .container-fluid input[type="password"],
        .container-fluid input[type="textarea"],
        .container-fluid select {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: wheat;
        }

        .container-fluid .select-style {
            appearance: none;
            color: #1b5835;
            background-color: wheat;
            font-size: 18px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn.btn-primary {
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #459bd4;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;

        }

        .btn.btn-primary:hover {
            background-color: #27bb65;
        }
    </style>
    </body>

    </html>