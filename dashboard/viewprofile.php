<?php
include('includes/connection.php');
include('includes/adminheader.php');
?>

<div id="wrapper">


    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">

        <div class="container-fluid">
            <div class="row">

                    <?php
                    if (isset($_GET['name'])) {
                        $user = mysqli_real_escape_string($conn, $_GET['name']);
                        $query = "SELECT * FROM users WHERE username= '$user' ";
                        $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                        if (mysqli_num_rows($run_query) > 0) {
                            while ($row = mysqli_fetch_array($run_query)) {
                                $name = $row['name'];
                                $email = $row['email'];
                                $course = $row['course'];
                                $role = $row['role'];
                                $bio = $row['about'];
                                $image = $row['image'];
                                $joindate = $row['joindate'];
                                $gender = $row['gender'];
                            }
                        } else {
                            $name = "N/A";
                            $email = "N/A";
                            $course = "N/A";
                            $role = "N/A";
                            $bio = "N/A";
                            $image = "profile.jpg";
                            $gender = "N/A";
                            $joindate = "N/A";
                        }

                        ?>



                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-6">
                                    <div class="well well-sm profile-card">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <img src="profilepics/<?php echo $image; ?>" alt=""
                                                    class="img-rounded img-responsive profile-pic" />
                                            </div>
                                            <div class="col-6 col-md-8">
                                                <h4>
                                                    <?php echo $name; ?>
                                                </h4>
                                                <div class="profile-details">
                                                    <p>
                                                        <font color="brown">Department: </font>
                                                        <?php echo $course; ?>
                                                    </p>
                                                    <p>
                                                        <font color="brown">Role: </font>
                                                        <?php echo $role; ?>
                                                    </p>
                                                    <p>
                                                        <font color="brown">Gender: </font>
                                                        <?php echo $gender; ?>
                                                    </p>
                                                    <p>
                                                        <font color="brown">Email: </font>
                                                        <?php echo $email; ?>
                                                    </p>
                                                    <p>
                                                        <font color="brown">Join Date: </font>
                                                        <?php echo $joindate; ?>
                                                    </p>
                                                    <p>
                                                        <font color="brown">Bio: </font>
                                                        <?php echo $bio; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>

                        </body>
                        <link rel="stylesheet"
                            href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
                        <style>
                            /* Hide the default scrollbar */
                            body::-webkit-scrollbar {
                                width: 10px;
                                /* Width of the scrollbar */
                            }

                            /* Track */
                            body::-webkit-scrollbar-track {
                                background: #f1f1f1;
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
                                background: #555;
                                /* Color of the scrollbar handle on hover */
                            }

                            html {
                                background: linear-gradient(135deg, #4aa3df, #2ecc71);
                                font-family: 'Poppins', sans-serif;
                                margin: 0;
                                padding: 0;
                                height: 100%;
                            }

                            body {
                                margin-bottom: 60px;
                                /* Adjust margin-bottom to accommodate footer height */
                                overflow-x: hidden;
                                overflow-y: auto;
                            }

                            .container {
                                max-width: 1200px;
                                margin: 0 auto;
                                padding: 0 20px;
                            }

                            .profile-card {
                                margin-top: 20px;
                                background-color: #fff;
                                padding: 20px;
                                border-radius: 10px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }

                            .profile-pic {
                                max-width: 100%;
                                height: auto;
                                border-radius: 10px;
                            }

                            .profile-details {
                                margin-top: 20px;
                            }

                            .profile-details p {
                                margin-bottom: 10px;
                                font-size: 16px;
                            }

                            .profile-details font {
                                font-weight: bold;
                                color: #6c757d;
                            }

                            h4 {
                                margin-bottom: 20px;
                                color: #343a40;
                            }

                            /* Media query for smaller devices */
                            @media (max-width: 767.98px) {

                                .col-12,
                                .col-6 {
                                    padding: 0;
                                }

                                .profile-pic {
                                    border-radius: 0;
                                }
                            }

                            /* Styles for profile */
                            .profile-card {
                                margin-top: 20px;
                                background-color: #fff;
                                padding: 20px;
                                border-radius: 10px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }

                            .profile-pic {
                                width: 150px;
                                height: 150px;
                            }

                            .profile-details p {
                                margin-bottom: 5px;
                            }
                        </style>

                        </html>

                    <?php } else {
                        echo "<script>window.location.href= 'index.php';</script>";
                    } ?>