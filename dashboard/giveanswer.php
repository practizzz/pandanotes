<?php
include('includes/connection.php');
include('includes/adminheader.php');

?>

<div id="wrapper">
    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                    <h1 class="page-header">
                        Give Answer
                    </h1>

                    <?php
                    // Check if question_id is provided in the URL
                    if (isset($_GET['question_id'])) {
                        $question_id = $_GET['question_id'];

                        // Query to retrieve question details
                        $question_query = "SELECT * FROM questions WHERE question_id = $question_id";
                        $question_result = mysqli_query($conn, $question_query);
                        if (mysqli_num_rows($question_result) > 0) {
                            $question_row = mysqli_fetch_assoc($question_result);
                            $question = $question_row['question'];
                            $question_uploader = $question_row['question_uploader'];
                            $chapter_name = $question_row['question_chapter_name'];
                            $description = $question_row['question_description'];
                            $question_image = $question_row['question_image'];
                            
                            // Display question details
                            ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="question-box">
                                        <div class="question-content">
                                            <div class="question-details">
                                                <p><strong>Question:</strong>
                                                    <?php echo $question; ?>
                                                </p>
                                                <p><strong>Chapter:</strong>
                                                    <?php echo $chapter_name; ?>
                                                </p>
                                                <p><strong>Question by:</strong>
                                                    <?php echo $question_uploader; ?>
                                                </p>
                                                <p><strong>Description:</strong>
                                                    <?php echo $description; ?>
                                                </p>
                                                
                                                <img class="img-responsive" width="200" height="auto"
                                                    src="<?php echo $question_image; ?>" alt="Photo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="answer-box">
                                    <form action="" method="POST" enctype="multipart/form-data" class="answer-form">
                                        <div class="form-group">
                                            <label for="answer">Your Answer</label>
                                            <textarea name="answer" class="form-control" rows="5" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="answer_image">Answer Image (Optional)</label>
                                            <input type="file" name="answer_image" class="form-control">
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Submit Answer</button>
                                    </form>
                                </div>
                            </div>
                            <?php
                        } else {
                            echo "<p>Question not found.</p>";
                        }
                    } else {
                        echo "<p>Question ID not provided.</p>";
                    }
                    ?>

                    <?php
                    // Handle form submission
                    if (isset($_POST['submit'])) {
                        // Get answer text
                        $answer = mysqli_real_escape_string($conn, $_POST['answer']);

                        // Get answer image if uploaded
                        $answer_image = '';
                        if (isset($_FILES['answer_image']) && $_FILES['answer_image']['error'] === UPLOAD_ERR_OK) {
                            $file_name = $_FILES['answer_image']['name'];
                            $file_tmp = $_FILES['answer_image']['tmp_name'];

                            // Move the uploaded image to the desired location
                            $target_dir = "answer_images/";
                            $target_file = $target_dir . basename($file_name);
                            move_uploaded_file($file_tmp, $target_file);
                            $answer_image = $target_file;
                        }

                        // Insert answer into database
                        $answer_uploader = $_SESSION['username'];
                        $query = "INSERT INTO answers (question_id, answer, answer_image, answer_uploader) VALUES ('$question_id', '$answer', '$answer_image', '$answer_uploader')";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            echo "<div class='alert alert-success'>Answer submitted successfully.</div>";

                            echo "<script>alert('Answer submitted successfully.');
                            window.location.href= 'viewquestions.php';</script>";
                        } else {
                            echo "<div class='alert alert-danger'>Error submitting answer. Please try again.</div>";
                        }
                    }
                    ?>
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

.img-responsive {
    width: 200px;
    height: auto;
    display: block;
    margin: 0 auto; /* Center the image horizontally */
}

/* Question box container */
.question-box {
    background-color: wheat; /* Light gray background */
    border-radius: 15px;
    padding: 15px; /* Reduced padding */
    margin: 0 auto; /* Center the box horizontally */
    margin-bottom: 15px; /* Adjusted margin */
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
    font-family: 'Poppins', sans-serif; /* Poppins font style */
    max-width: 500px; /* Set maximum width */
}

.question-content {
    position: relative;
    text-align: center; /* Center align content */
}

.question-details p {
    margin: 0 0 10px;
    color: #333; /* Text color */
}

.img-responsive {
    width: 200px;
    height: auto;
    display: block;
    margin: 0 auto; /* Center the image horizontally */
}

.row{
    /* display: block; */
    align-items: center;
    margin: 0 auto; /* Center the image horizontally */
}

/* Answer box container */
.answer-box {
    background-color: lightgray; /* Light gray background */
    border-radius: 10px;
    width: 60%;
    padding: 40px; /* Increased padding */
    border: 3px solid gray; /* Light gray border */
    align-items: center;
    align-content: center;
    text-align: center;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
    margin: 0 auto; /* Center the box horizontally */
}

/* Form heading */
.page-header {
    text-align: center;
    margin-bottom: 30px;
    color: #333; /* Dark text color */
    font-size: 24px;
}

/* Form labels */
label {
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
    color: #555; /* Medium-dark text color */
    text-align: center; /* Left align labels */
}

/* Form inputs */
.form-control {
    border-radius: 5px;
    border: 3px solid gray; /* Light gray border */
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

input[type="file"]{
    background-color: greenyellow;
    margin-bottom: 20px;
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