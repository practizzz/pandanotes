<?php
include 'includes/connection.php';
include 'includes/adminheader.php';

?>

<div id="wrapper">
    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                    <h1 class="page-header">
                        UPLOAD NOTE
                    </h1>
                    <?php
                    if (isset($_POST['upload'])) {
                        // Sanitize input data
                        $file_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                        $file_description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

                        // Validate input data
                        $errors = [];
                        if (empty($file_title) || strlen($file_title) < 3 || strlen($file_title) > 60) {
                            $errors[] = "Title is required and must be between 3 to 60 characters.";
                        }
                        if (empty($file_description) || strlen($file_description) < 3 || strlen($file_description) > 150) {
                            $errors[] = "Description is required and must be between 3 to 150 characters.";
                        }

                        if (empty($_SESSION['id'])) {
                            $errors[] = "User session is not set.";
                        }

                        $file_uploader = $_SESSION['username'] ?? '';
                        $file_uploaded_to = $_SESSION['course'] ?? '';

                        // File validation
                        if (empty($_FILES['file']['name'])) {
                            $errors[] = "Please attach a file.";
                        } else {
                            $file = $_FILES['file']['name'];
                            $file_size = $_FILES['file']['size'];
                            $file_tmp = $_FILES['file']['tmp_name'];

                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                            $validExt = array('pdf', 'txt', 'doc', 'docx', 'ppt', 'zip', 'jpg', 'jpeg', 'png');

                            if ($file_size <= 0 || $file_size > 40000000) {
                                $errors[] = "File size is not proper.";
                            }
                            if (!in_array($ext, $validExt)) {
                                $errors[] = "Not a valid file.";
                            }
                        }

                        // If no errors, proceed with upload
                        if (empty($errors)) {
                            $folder = 'allfiles/';
                            $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $notefile = rand(1000, 1000000) . '.' . $fileext;

                            if (move_uploaded_file($file_tmp, $folder . $notefile)) {
                                $query = "INSERT INTO uploads(file_name, file_description, file_type, file_uploader, file_uploaded_to, file) VALUES ('$file_title' , '$file_description' , '$fileext' , '$file_uploader' , '$file_uploaded_to' , '$notefile')";
                                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                                if (mysqli_affected_rows($conn) > 0) {
                                    echo "<script> alert('File uploaded successfully. It will be published after admin approves it'); window.location.href='notes.php';</script>";
                                } else {
                                    echo "<script> alert('Error while uploading. Try again.');</script>";
                                }
                            }
                        } else {
                            // Display errors
                            foreach ($errors as $error) {
                                echo "<center><font color='red'>$error</font></center>";
                            }
                        }
                    }
                    ?>

                    <div class="row">
                        <div class="col">
                            <form role="form" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="title" for="post_title">Note Title</label>
                                    <input type="text" name="title" class="form-control"
                                        placeholder="Eg: Magnetism Note" value="<?php if (isset($_POST['upload'])) {
                                            echo $file_title;
                                        } ?>" required="">
                                </div>

                                <div class="form-group">
                                    <label class="title" for="post_tags">Short Note Description</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Eg: Magnetism Note includes basic concepts of magnetism and Lorentz force..."
                                        value="<?php if (isset($_POST['upload'])) {
                                            echo $file_description;
                                        } ?>" required="">
                                </div>

                                <div class="form-group">
                                    <label class="title" for="post_image">Select File</label>
                                    <input type="file" class="custom-file-upload" name="file">
                                </div>

                                <button class="title btn btn-primary" type="submit" name="upload"
                                    value="Upload Note">Upload
                                    Note</button>
                            </form>
                        </div>
                    </div>
            </div>
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

    .row{
        display: flex;
        flex-direction: column;
        align-items: center;
    }


    /* Form container */
    .col {
        background-color: lightgray;
        /* Light gray background */
        padding: 40px;
        width: 80vw;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        align-items: center;
        align-content: center;
        text-align: center;
        box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
    }

    /* Form heading */
    .page-header {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        /* Dark text color */
        font-size: 24px;
    }

    /* Form labels */
    label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
        color: #555;
        /* Medium-dark text color */
    }

    .title {
        padding-top: 5px;
        color: black;
    }

    /* Form inputs */
    .form-control {
        border-radius: 5px;
        border: 3px solid gray;
        /* Light gray border */
        padding: 15px;
        width: 60%;
        transition: border-color 0.3s ease;
        font-size: 16px;
        background-color: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #4CAF50;
        /* Green border on focus */
    }

    /* File input container */
    .file-input-container {
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }

    /* File input */
    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    /* Choose file button */
    .custom-file-upload {
        margin: 10px;
        cursor: pointer;
        padding: 15px 30px;
        background-color: green;
        /* Green background */
        color: #fff;
        /* White text color */
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        font-size: 16px;
    }

    .custom-file-upload:hover {
        background-color: #45a049;
        /* Darker green on hover */
    }

    /* Upload button */
    .btn-primary {
        background-color: #459bd4;
        /* Blue background */
        color: #fff;
        /* White text color */
        border: none;
        border-radius: 5px;
        padding: 15px 30px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #357ebd;
        /* Darker blue on hover */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col {
            /* width: 100%; */
            margin-bottom: 30px;
        }
    }
</style>