<?php
include('includes/connection.php');
include('includes/adminheader.php');
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Delete the question from the database
    $delete_query = "DELETE FROM questions WHERE question_id = '$delete_id'";
    $result = mysqli_query($conn, $delete_query);
    if($result) {
        // Success message
        echo "<script>alert('Question deleted successfully!');</script>";
        // Redirect back to the same page to refresh the questions list
        echo "<script>window.location.href='viewquestions.php';</script>";
    } else {
        // Error message
        echo "<script>alert('Failed to delete question. Please try again.');</script>";
    }
}
?>

<div id="wrapper">
    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <h1 class="page-header">
                        Questions
                    </h1>

                    <div class="row">
                        <?php
                        $current_user_course = $_SESSION['course'];
                        $query = "SELECT * FROM questions WHERE question_uploaded_to = '$current_user_course' ORDER BY question_uploaded_on DESC";
                        $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                        if (mysqli_num_rows($run_query) > 0) {
                            while ($row = mysqli_fetch_array($run_query)) {
                                $question_id = $row['question_id'];
                                $question = $row['question'];
                                $chapter_name = $row['question_chapter_name'];
                                $description = $row['question_description'];
                                $question_uploader = $row['question_uploader'];
                                $question_image = $row['question_image'];

                                // Check if an answer exists for this question
                                $answer_query = "SELECT * FROM answers WHERE question_id = '$question_id' AND answer != 'Not answered yet'";
                                $answer_result = mysqli_query($conn, $answer_query);
                                $answer_exists = mysqli_num_rows($answer_result) > 0;
                                ?>
                                    <div class="question-box <?php echo $answer_exists ? 'answered' : 'unanswered'; ?>">
                                        <div class="question-content">
                                            <div class="question-details">
                                                <p><strong>Question:</strong>
                                                    <?php echo $question; ?>
                                                </p>
                                                <p><strong>Chapter:</strong>
                                                    <?php echo $chapter_name; ?>
                                                </p>
                                                <p><strong>Description:</strong>
                                                    <?php echo $description; ?>
                                                </p>
                                                <p><strong>Uploaded by:</strong>
                                                    <?php echo $question_uploader; ?>
                                                </p>
                                                <?php 
                                                if(!empty($question_image)){?>
                                                    <img class="img-responsive" width="200" height="auto"
                                                    src="<?php echo $question_image; ?>" alt="Photo">
                                                <?php } ?>
                                                
                                            </div>
                                            <div class="question-actions">
                                            <?php 
                                                // Show delete button if the current user is the uploader of the question
                                                if($question_uploader === $_SESSION['username'] || $_SESSION['role'] == 'admin') {?>
                                                    <a href="viewquestions.php?delete_id=<?php echo $question_id; ?>"
                                                    class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                                                <?php } ?>
                                                <a href="answers.php?question_id=<?php echo $question_id; ?>"
                                                    class="btn btn-primary">Answer</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        } else {
                            echo "<p>No questions available.</p>";
                        }
                        ?>
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

.col {
    align-items: center;
    text-align: center;
}

.img-responsive {
    width: 200px;
    height: auto;
    display: block;
    margin: 0 auto;
    /* Center the image horizontally */
}

/* Question box container */
.question-box {
    background-color: wheat;
    /* Light gray background */
    border-radius: 15px;
    padding: 15px;
    align-items: center;
    /* Reduced padding */
    margin: 0 auto;
    /* Center the box horizontally */
    margin-bottom: 15px;
    /* Adjusted margin */
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    /* Soft shadow effect */
    font-family: 'Poppins', sans-serif;
    /* Poppins font style */
    max-width: 500px;
    /* Set maximum width */
}

.question-box:hover {
    transform: translateY(-5px);
    /* Lift the box slightly on hover */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    /* Increase shadow on hover */
}

.question-content {
    position: relative;
}

.question-details p {
    margin: 0 0 10px;
    color: #333;
    /* Text color */
    text-align: center;
    /* Align text to center */
}

.question-actions {
    margin-top: 20px;
    text-align: center;
    /* Align buttons to center */
}

.btn {
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    /* Reduced padding */
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease;
    font-family: 'Poppins', sans-serif;
    /* Poppins font style */
}

.btn:hover {
    background-color: #45a049;
    /* Darker green on hover */
}

.btn-danger{
    background-color: red;
}

.btn-danger:hover{
    background-color: skyblue;
    color: black;
}

.btn-primary {
    background-color: #459bd4;
    /* Blue button for answer */
}

/* Styling for unanswered questions */
.question-box.unanswered {
    border: 2px solid red;
}

/* Styling for answered questions */
.question-box.answered {
    border: 2px solid green;
}

</style>
