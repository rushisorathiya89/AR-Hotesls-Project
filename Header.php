<?php
session_start();
include 'db_connect.php';
include 'functions.php';
include 'mailer.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AR Hotels</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@100;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .h-font {
            font-family: "Merienda", cursive;
        }

        .header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        body {
            padding-top: 100px;
        }
    </style>
</head>

<body>
    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">AR Hotels</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- navbar content -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="dining.php">Dining</a></li>
                        <li class="nav-item"><a class="nav-link" href="wedding.php">Weddings</a></li>
                        <li class="nav-item"><a class="nav-link" href="offers.php">Offers</a></li>
                        <li class="nav-item"><a class="nav-link" href="book_room.php">Book a Room</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact_us.php">Contact Us</a></li>

                        <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) { ?>
                            <li class="nav-item"><a class="nav-link" href="Review.php">Give Review</a></li>
                        <?php } ?>
                    </ul>

                    <!-- login & register -->
                    <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) { ?>
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-2">
                            <a href="user_view_profile.php" class="btn btn-light text-dark">
                                <i class="bi bi-person-circle me-1"></i> Profile
                            </a>
                            <a href="logout.php" class="btn btn-light text-dark">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="d-flex flex-column flex-lg-row gap-2">
                            <button type="button" class="btn btn-outline-primary" onclick="window.location.href='login.php'">Log In</button>
                            <button type="button" class="btn btn-outline-success" onclick="window.location.href='Register.php'">Register</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>