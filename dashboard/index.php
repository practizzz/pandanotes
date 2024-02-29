<?php
    include('includes/connection.php');
    include('includes/adminheader.php');
    ?>
    <div id="wrapper">
        <?php include 'includes/adminnav.php'; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                        <h1 class="welcome-heading">
                            Welcome
                            <small>
                                <?php echo $_SESSION['name']; ?>
                            </small>
                        </h1>
                        <?php if ($_SESSION['role'] == 'admin') { ?>
                            <div class="marquee-container">
                                <marquee behavior="scroll" direction="left" scrollamount="10">
                                    <span class="marquee-text">Notes uploaded by various users...</span>
                                </marquee>
                            </div>
                            <div class="row">
                                <?php
                                $query = "SELECT * FROM uploads ORDER BY file_uploaded_on DESC";
                                $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                if (mysqli_num_rows($run_query) > 0) {
                                    while ($row = mysqli_fetch_array($run_query)) {
                                        $file_id = $row['file_id'];
                                        $file_name = $row['file_name'];
                                        $file_description = $row['file_description'];
                                        $file_type = $row['file_type'];
                                        $file_date = $row['file_uploaded_on'];
                                        $file_uploader = $row['file_uploader'];
                                        $file_status = $row['status'];
                                        $file = $row['file'];
                                ?>
                                        <div class="col-lg-4">
                                            <div class="note-box">
                                                <div class="note-content">
                                                    <div class="note-details">
                                                        <p><strong>Name:</strong> <?php echo $file_name; ?></p>
                                                        <p><strong>Description:</strong> <?php echo $file_description; ?></p>
                                                        <p><strong>Type:</strong> <?php echo $file_type; ?></p>
                                                        <p><strong>Uploaded on:</strong> <?php echo $file_date; ?></p>
                                                        <p><strong>Uploaded by:</strong> <a href='viewprofile.php?name=<?php echo $file_uploader; ?>' target='_blank'><?php echo $file_uploader; ?></a></p>
                                                        <p><strong>Status:</strong> <?php echo $file_status; ?></p>
                                                    </div>
                                                    <div class="note-actions">
                                                        <a href='allfiles/<?php echo $file; ?>' target='_blank' class="btn btn-primary">View</a>
                                                        <?php if ($file_status != "approved") { ?>
                                                            <a onClick="return confirm('Are you sure you want to approve this note?')" href='?approve=<?php echo $file_id; ?>' class="btn btn-success">Approve</a>
                                                        <?php } else { ?>
                                                            <p id="already-approved">Already <?php echo $file_status; ?></p>
                                                        <?php } ?>
                                                        <a onClick="return confirm('Are you sure you want to delete this post?')" href='?del=<?php echo $file_id; ?>' class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                            <?php

                                if (isset($_GET['del'])) {
                                $note_del = mysqli_real_escape_string($conn, $_GET['del']);
                                $file_uploader = $_SESSION['username'];
                                $del_query = "DELETE FROM uploads WHERE file_id='$note_del'";
                                $run_del_query = mysqli_query($conn, $del_query) or die(mysqli_error($conn));
                                if (mysqli_affected_rows($conn) > 0) {
                                    echo "<script>alert('note deleted successfully');
                            window.location.href='index.php';</script>";
                                } else {
                                    echo "<script>alert('error occured.try again!');</script>";
                                }
                                }

                                if (isset($_GET['approve'])) {
                            $note_approve = mysqli_real_escape_string($conn, $_GET['approve']);
                            $approve_query = "UPDATE uploads SET status='approved' WHERE file_id='$note_approve'";
                            $run_approve_query = mysqli_query($conn, $approve_query) or die(mysqli_error($conn));
                            if (mysqli_affected_rows($conn) > 0) {
                                echo "<script>alert('note approved successfully');
                        window.location.href='index.php';</script>";
                            } else {
                                echo "<script>alert('error occured.try again!');</script>";
                            }
                                }
                 
                                ?>
                            <?php } else { ?>
                            <div class="marquee-container">
                                <marquee behavior="scroll" direction="left" scrollamount="10">
                                    <b><span class="marquee-text"><?php echo $_SESSION['course']; ?> notes uploaded by various users...</span></b>
                                </marquee>
                            </div>
                            <div class="row">
                                <?php
                                $currentusercourse = $_SESSION['course'];
                                $query = "SELECT * FROM uploads WHERE file_uploaded_to = '$currentusercourse' AND status = 'approved' ORDER BY file_uploaded_on DESC";
                                $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                if (mysqli_num_rows($run_query) > 0) {
                                    while ($row = mysqli_fetch_array($run_query)) {
                                        $file_id = $row['file_id'];
                                        $file_name = $row['file_name'];
                                        $file_description = $row['file_description'];
                                        $file_type = $row['file_type'];
                                        $file_date = $row['file_uploaded_on'];
                                        $file = $row['file'];
                                        $file_uploader = $row['file_uploader'];
                                ?>
                                        <div class="col-lg-4">
                                            <div class="note-box">
                                                <div class="note-content">
                                                    <div class="note-details">
                                                        <p><strong>Name:</strong> <?php echo $file_name; ?></p>
                                                        <p><strong>Description:</strong> <?php echo $file_description; ?></p>
                                                        <p><strong>Type:</strong> <?php echo $file_type; ?></p>
                                                        <p><strong>Uploaded by:</strong> <a href='viewprofile.php?name=<?php echo $file_uploader; ?>' target='_blank'><?php echo $file_uploader; ?></a></p>
                                                        <p><strong>Uploaded on:</strong> <?php echo $file_date; ?></p>
                                                    </div>
                                                    <div class="note-actions">
                                                        <a href='allfiles/<?php echo $file; ?>' target='_blank' class="btn btn-primary">View</a>
                                                        <a href='allfiles/<?php echo $file; ?>' target='_blank' class="btn btn-primary">Download</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>

<script>
    // JavaScript code for responsiveness (optional)
window.addEventListener('resize', function() {
    // Check the window width
    if (window.innerWidth < 768) {
        // Code for smaller screens
    } else {
        // Code for larger screens
    }
});

</script>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
<style>
/* Html and body css */
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


/* Welcome heading styles */
.welcome-heading {
    text-align: center;
    color: wheat;
    margin-top: 20px;
}

.welcome-heading small {
    display: block;
    font-size: 16px;
}

/* Marquee styles */
.marquee-container {
    overflow: hidden;
}

.marquee-text {
    display: inline-block;
    /* animation: marquee-scroll 20s linear infinite; */
    white-space: nowrap;
    color: wheat;
    font-size: 18px;
    padding-right: 100%;
}

@keyframes marquee-scroll {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}




/* Note box styles */
.note-box {
    background-color: wheat; /* Light gray background */
    border-radius: 15px;
    padding: 15px; /* Reduced padding */
    margin-bottom: 15px; /* Reduced margin */
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
    font-family: 'Poppins', sans-serif; /* Poppins font style */
    max-width: 500px; /* Set maximum width */
    margin: 0 auto; /* Center the box horizontally */
    margin-bottom: 20px;
}

.note-box:hover {
    transform: translateY(-5px); /* Lift the box slightly on hover */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}

.note-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 70%; /* Initial width */
    height: 8px;
    background: linear-gradient(to right, #ff9f93, #ffbf73); /* Gradient background */
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    transition: width 0.3s ease; /* Transition for width */
    z-index: -1; /* Move the line below the content */
}

.note-box:hover::before {
    width: 100%; /* Complete transition on hover */
}

.note-content {
    position: relative;
}

.note-details p {
    margin: 0 0 10px;
    color: #333; /* Text color */
    text-align: center; /* Align text to center */
}

.note-actions {
    margin-top: 20px;
    text-align: center; /* Align buttons to center */
}

.btn {
    background-color: #4CAF50; /* Green button */
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px; /* Reduced padding */
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease;
    font-family: 'Poppins', sans-serif; /* Poppins font style */
}

.btn:hover {
    background-color: #45a049; /* Darker green on hover */
}

.btn.view-btn {
    background-color: #459bd4; /* Blue button for view */
}

.btn.download-btn {
    background-color: #ff9f43; /* Orange button for download */
    margin-left: 10px; /* Add some space between buttons */
}



/* Adjustments for smaller screens */
@media (max-width: 768px) {
    .note-box {
        width: 100%;
    }
}

</style>