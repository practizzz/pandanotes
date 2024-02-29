<?php
include 'includes/connection.php';
include 'includes/adminheader.php';

$currentuser = $_SESSION['username'];

$query = "SELECT * FROM uploads WHERE file_uploader= '$currentuser' ORDER BY file_uploaded_on DESC";
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<div id="wrapper">
    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                    <h1 class="page-header">
                        <div class="col">
                            <a href="uploadnote.php" class="btn btn-primary">Add New Note</a>
                        </div>
                        MY NOTES
                    </h1>
                    <div class="row">
                        <?php
                        if (mysqli_num_rows($run_query) > 0) {
                            while ($row = mysqli_fetch_array($run_query)) {
                                $file_id = $row['file_id'];
                                $file_name = $row['file_name'];
                                $file_description = $row['file_description'];
                                $file_type = $row['file_type'];
                                $file_date = $row['file_uploaded_on'];
                                $file_status = $row['status'];
                                $file = $row['file'];
                                ?>
                                    <div class="note-box">
                                        <div class="note-content">
                                            <div class="note-details">
                                                <p><strong>Name:</strong>
                                                    <?php echo $file_name; ?>
                                                </p>
                                                <p><strong>Description:</strong>
                                                    <?php echo $file_description; ?>
                                                </p>
                                                <p><strong>Type:</strong>
                                                    <?php echo $file_type; ?>
                                                </p>
                                                <p><strong>Uploaded on:</strong>
                                                    <?php echo $file_date; ?>
                                                </p>
                                                <p><strong>Status:</strong>
                                                    <?php echo $file_status; ?>
                                                </p>
                                            </div>
                                            <div class="note-actions">
                                                <a href='allfiles/<?php echo $file; ?>' target='_blank' class="btn btn-success view-btn">View</a>
                                                <a onclick="return confirm('Are you sure you want to delete this post?')" href='?del=<?php echo $file_id; ?>' class="btn btn-danger delete-btn">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        } else {
                            echo "<script>if(confirm('No notes yet! Start uploading now?')) {
                                      window.location.href = 'uploadnote.php';
                                  }</script>";
                        }
                        ?>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_GET['del'])) {
    $note_del = mysqli_real_escape_string($conn, $_GET['del']);
    $del_query = "DELETE FROM uploads WHERE file_id='$note_del' AND file_uploader = '$currentuser'";
    $run_del_query = mysqli_query($conn, $del_query) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Note deleted successfully'); window.location.href='notes.php';</script>";
    } else {
        echo "<script>alert('Error occurred. Try again!');</script>";
    }
}
?>

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

    /* Form container */
    .col {
        /* background-color: #f8f9fa; */
        /* Light gray background */
        padding: 30px;
        border-radius: 10px;
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

    .col{
        margin-bottom: 10px;
    }

    .col .btn.btn-primary{
        background-color: green;
        color: wheat;
    }
    /* Form inputs */
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        /* Light gray border */
        padding: 15px;
        width: 100%;
        transition: border-color 0.3s ease;
        font-size: 16px;
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
        display: inline-block;
        cursor: pointer;
        padding: 15px 30px;
        background-color: #4CAF50;
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
    .btn.btn-primary {
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

    .btn.btn-primary:hover {
        background-color: #357ebd;
        /* Darker blue on hover */
    }

    /* Note box container */
    .note-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        /* Responsive grid layout */
        grid-gap: 30px;
        /* Gap between grid items */
    }
    /* Note box styles */
    .note-box {
        background-color: wheat;
        /* Light gray background */
        border-radius: 15px;
        padding: 15px;
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

    .note-box:hover {
        transform: translateY(-5px);
        /* Lift the box slightly on hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        /* Increase shadow on hover */
    }

    .note-box::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 70%;
        /* Initial width */
        height: 8px;
        background: linear-gradient(to right, #ff9f93, #ffbf73);
        /* Gradient background */
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: width 0.3s ease;
        /* Transition for width */
        z-index: -1;
        /* Move the line below the content */
    }

    .note-box:hover::before {
        width: 100%;
        /* Complete transition on hover */
    }

    .note-content {
        position: relative;
    }

    .note-details p {
        margin: 0 0 10px;
        color: #333;
        /* Text color */
        text-align: center;
        /* Align text to center */
    }

    .note-actions {
        margin-top: 20px;
        text-align: center;
        /* Align buttons to center */
    }

    .btn {
        background-color: #4CAF50;
        /* Green button */
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

    .btn.view-btn {
        background-color: #459bd4;
        /* Blue button for view */
    }

    .btn.download-btn {
        background-color: #ff9f43;
        /* Orange button for download */
        margin-left: 10px;
        /* Add some space between buttons */
    }

</style>
