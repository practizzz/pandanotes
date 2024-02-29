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
                        ASK QUESTIONS
                    </h1>
                    <?php
                    if (isset($_POST['ask'])) {
                        // Sanitize input data
                        $question = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
                        $chapter_name = filter_var($_POST['chapter_name'], FILTER_SANITIZE_STRING);
                        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                        $question_uploaded_to = $_SESSION['course'] ?? '';

                        // Validate input data
                        $errors = [];
                        if (empty($question) || strlen($question) < 3 || strlen($question) > 150) {
                            $errors[] = "Question is required and must be between 3 to 150 characters.";
                        }
                        if (empty($chapter_name) || strlen($chapter_name) < 3 || strlen($chapter_name) > 60) {
                            $errors[] = "Chapter name is required and must be between 3 to 60 characters.";
                        }
                        if (empty($description) || strlen($description) < 3 || strlen($description) > 300) {
                            $errors[] = "Description is required and must be between 3 to 300 characters.";
                        }

                        // Check if an image is uploaded
                        $question_image = '';
                        if ($_FILES['question_image']['name']) {
                            $file_name = $_FILES['question_image']['name'];
                            $file_size = $_FILES['question_image']['size'];
                            $file_tmp = $_FILES['question_image']['tmp_name'];
                            $file_type = $_FILES['question_image']['type'];

                            // Get file extension
                            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                            $extensions = array("jpeg", "jpg", "png");

                            // Validate file type and size
                            if (in_array($file_ext, $extensions) === false) {
                                $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
                            }

                            if ($file_size > 12097152) {
                                $errors[] = 'File size must be less than 10 MB';
                            }

                            if (empty($errors) === true) {
                                // Move the uploaded image to the desired location
                                move_uploaded_file($file_tmp, "question_images/" . $file_name);
                                $question_image = "question_images/" . $file_name;
                            }
                        }

                        // If no errors, proceed with upload
                        if (empty($errors)) {
                            $question_uploader = $_SESSION['username'] ?? '';

                            // Insert data into database
                            $query = "INSERT INTO questions (question, question_chapter_name, question_description, question_uploaded_to, question_uploader, question_image) VALUES ('$question', '$chapter_name', '$description', '$question_uploaded_to', '$question_uploader', '$question_image')";
                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                            if (mysqli_affected_rows($conn) > 0) {
                                $question_id = mysqli_insert_id($conn); // Get the ID of the newly inserted question
                    
                                // Insert the answer into the Answers table
                                $answer = "Not answered yet"; // Default answer
                                $insert_answer_query = "INSERT INTO answers (question_id, answer, answer_uploader) VALUES ('$question_id', '$answer', '$question_uploader')";
                                $result_answer = mysqli_query($conn, $insert_answer_query) or die(mysqli_error($conn));

                                echo "<script> alert('Question asked successfully.'); window.location.href='viewquestions.php';</script>";
                            } else {
                                echo "<script> alert('Error while asking the question. Please try again.');</script>";
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
                                    <label for="question">Question</label>
                                    <textarea name="question" class="form-control" rows="3"
                                        placeholder="Enter your question here..." required=""><?php if (isset($_POST['ask'])) {
                                            echo $question;
                                        } ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="chapter_name">Chapter Name</label>
                                    <input type="text" name="chapter_name" class="form-control"
                                        placeholder="Eg: Magnetism, Electron..." value="<?php if (isset($_POST['ask'])) {
                                            echo $chapter_name;
                                        } ?>" required="">
                                </div>

                                <div class="form-group">
                                    <label for="description">Question Description</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Enter your question description and confusion part here..." required=""><?php if (isset($_POST['ask'])) {
                                            echo $description;
                                        } ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="question_image">Question Image</label>
                                    <input type="file" class="custom-file-upload" name="question_image" class="form-control">
                                </div>

                                <button type="submit" name="ask" class="btn btn-primary btn-block" value="Ask Question">Ask
                                    Question</button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">

<style>
    
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
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #343a40;
        min-height: 100vh;
    }
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
    /* Form container */
.col {
        background-color: lightgray;
        /* Light gray background */
        padding: 40px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
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
    color: #555; /* Medium-dark text color */
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
    border-color: #4CAF50; /* Green border on focus */
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
    display: inline-block;
    cursor: pointer;
    padding: 15px 30px;
    background-color: green; /* Green background */
    color: #fff; /* White text color */
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    font-size: 16px;
    margin-bottom: 10px;
}

.custom-file-upload:hover {
    background-color: #45a049; /* Darker green on hover */
}

/* Submit button */
.btn.btn-primary {
    background-color: #459bd4; /* Blue background */
    color: #fff; /* White text color */
    border: none;
    border-radius: 5px;
    padding: 15px 30px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 16px;
}

.btn.btn-primary:hover {
    background-color: #357ebd; /* Darker blue on hover */
}
</style>