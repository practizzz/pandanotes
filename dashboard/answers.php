<?php
include('includes/connection.php');
include('includes/adminheader.php');
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Delete the question from the database
    $delete_query = "DELETE FROM answers WHERE answer_id = '$delete_id'";
    $result = mysqli_query($conn, $delete_query);
    if($result) {
        // Success message
        echo "<script>alert('Answer deleted successfully!');</script>";
        // Redirect back to the same page to refresh the questions list
        echo "<script>window.location.href='answers.php';</script>";
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
                        Answers
                    </h1>

                    <div class="row">
                        <?php
                        // Check if question_id is provided in the URL
                        if(isset($_GET['question_id'])) {
                            $question_id = $_GET['question_id'];

                            // Query to retrieve question details
                            $question_query = "SELECT * FROM questions WHERE question_id = $question_id";
                            $question_result = mysqli_query($conn, $question_query);
                            if(mysqli_num_rows($question_result) > 0) {
                                $question_row = mysqli_fetch_assoc($question_result);
                                $question = $question_row['question'];
                                $chapter_name = $question_row['question_chapter_name'];
                                $description = $question_row['question_description'];
                                $question_uploader = $question_row['question_uploader'];
                                $question_uploaded_on = $question_row['question_uploaded_on'];
                                $question_image = $question_row['question_image'];

                                // Output question box
                                ?>
                                <div class="col">
                                    <div class="question-box">
                                        <div class="question-content">
                                            <div class="question-details">
                                                <p><strong>Question:</strong> <?php echo $question; ?></p>
                                                <p><strong>Chapter:</strong> <?php echo $chapter_name; ?></p>
                                                <p><strong>Description:</strong> <?php echo $description; ?></p>
                                                <p><strong>Uploaded by:</strong> <?php echo $question_uploader; ?></p>
                                                <p><strong>Uploaded on:</strong> <?php echo $question_uploaded_on; ?></p>
                                                <?php if(!empty($question_image)): ?>
                                                <img src="<?php echo $question_image; ?>" alt="Question Image" class="img-responsive">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo "<p>Question Answer not found.</p>";
                            }

                            // Query to retrieve answers for the question
                            $answers_query = "SELECT * FROM answers WHERE question_id = $question_id";
                            $answers_result = mysqli_query($conn, $answers_query);
                            if(mysqli_num_rows($answers_result) > 0) {
                                while($answer_row = mysqli_fetch_assoc($answers_result)) {
                                    $answer_uploader = $answer_row['answer_uploader'];
                                    $answer = $answer_row['answer'];
                                    $answer_id = $answer_row['answer_id'];
                                    $answer_uploaded_on = $answer_row['answer_uploaded_on'];
                                    $answer_image = $answer_row['answer_image'];
                                    ?>
                                    <div class="col">
                                        <div class="answer-box">
                                            <div class="answer-content">
                                                <div class="answer-details">
                                                    <?php
                                                    if($answer != NULL && $answer != "Not answered yet"){
                                                    echo "<p><strong>Answer by $answer_uploader</strong>: $answer</p>" ;
                                                    echo "<p><strong>Uploaded on:</strong> $answer_uploaded_on ";
                                                    if(!empty($answer_image)): ?>
                                                        <img src="<?php echo $answer_image; ?>" alt="Answer Image" class="img-responsive">
                                                    <?php endif; ?>
                                                    <?php
                                                      // Show delete button if the current user is the uploader of the question
                                                      echo '<br>';
                                                if($answer_uploader === $_SESSION['username'] || $_SESSION['role'] == 'admin') {?>
                                                    <a href="answers.php?delete_id=<?php echo $answer_id; ?>"
                                                    class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                                                <?php } ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }}

                            // Button to redirect to giveanswer.php
                            ?>
                            <div class="col">
                                <a href="giveanswer.php?question_id=<?php echo $question_id; ?>" class="btn btn-primary">Give Answer</a>
                            </div>
                            <?php
                        } else {
                            echo "<p>Question ID not provided.</p>";
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

/* Answer box container */
.answer-box {
    background-color: lightgray; /* Light gray background */
    border-radius: 10px;
    padding: 20px; /* Increased padding */
    margin: 20px auto; /* Center the box horizontally with some margin */
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
    font-family: 'Poppins', sans-serif; /* Poppins font style */
    max-width: 800px; /* Set maximum width */
}

.answer-content {
    position: relative;
    text-align: center; /* Align content to the center */
}

.answer-details p {
    margin: 0 0 10px;
    color: #333; /* Text color */
    text-align: center; /* Align text to the center */
}

/* Give Answer button */
.btn.btn-primary {
    /* display: block; */
    text-align: center;
    background-color: beige;
    padding: 5px;
    border-radius: 10px;
    text-decoration: none;
    margin: 0 auto 20px; /* Center the button horizontally with some bottom margin */
}

.btn-danger{
    background-color: lightcoral;
    padding: 7px;
    font-size: 18px;
    border-radius: 10px;
    text-decoration: none;
    color: white;
}

.btn-danger:hover{
    background-color: red;
}

.col{
    text-align: center;
    padding: 2px;
}

</style>