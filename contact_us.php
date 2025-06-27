<?php include 'Header.php'; ?>

<?php
// Fetch user data if logged in and session not already set
if (isset($_SESSION['userLogin']) && isset($_SESSION['userId'])) {
    if (!isset($_SESSION['userName']) || !isset($_SESSION['userEmail'])) {
        $uid = $_SESSION['userId'];
        $getUserQuery = "SELECT name, email FROM users WHERE id = $uid";
        $userResult = $conn->query($getUserQuery);

        if ($userResult && $userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $_SESSION['userName'] = $userRow['name'];
            $_SESSION['userEmail'] = $userRow['email'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - AR Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .h-font {
            font-family: "Merienda", cursive;
        }

        .hero-contact {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('1.jpg') no-repeat center center/cover;
            height: 50vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-contact h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-icon {
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 15px;
        }

        .contact-form {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #343a40;
            box-shadow: 0 0 0 0.25rem rgba(52, 58, 64, 0.25);
        }

        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-dark:hover {
            background-color: #23272b;
            border-color: #1d2124;
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <div class="hero-contact">
        <div class="text-center">
            <h1 class="h-font">Contact Us</h1>
            <p class="fs-4">We'd love to hear from you</p>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="contact-info h-100">
                        <h2 class="h-font mb-4">Get in Touch</h2>
                        <p>Have questions about our hotel, services, or reservations? Reach out to us through any of the channels below.</p>

                        <div class="d-flex align-items-start mb-4">
                            <i class="bi bi-geo-alt-fill contact-icon me-3"></i>
                            <div>
                                <h5 class="fw-bold">Address</h5>
                                <p>Vrindavan Society Main road, beside Pradhyuman Green City Tower, Kalavad Rd, Rajkot, Gujarat 360005</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <i class="bi bi-telephone-fill contact-icon me-3"></i>
                            <div>
                                <h5 class="fw-bold">Phone</h5>
                                <p>+91-63565****<br>+91-94094****</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <i class="bi bi-envelope-fill contact-icon me-3"></i>
                            <div>
                                <h5 class="fw-bold">Email</h5>
                                <p>rushisorathiya07@arhotels.com<br>adityadodiya10@arhotels.com</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <i class="bi bi-clock-fill contact-icon me-3"></i>
                            <div>
                                <h5 class="fw-bold">Reception Hours</h5>
                                <p>24/7<br>Our front desk is always open to serve you</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="contact-form">
                        <h2 class="h-font mb-4">Send Us a Message</h2>
                        <form method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" name="name" class="form-control" id="name" required
                                        value="<?php echo isset($_SESSION['userName']) ? $_SESSION['userName'] : ''; ?>"
                                        <?php echo isset($_SESSION['userName']) ? 'readonly' : ''; ?>>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" name="email" class="form-control" id="email" required
                                        value="<?php echo isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : ''; ?>"
                                        <?php echo isset($_SESSION['userEmail']) ? 'readonly' : ''; ?>>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" id="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="send_msg" class="btn btn-dark btn-lg">Send Message</button>
                                </div>
                            </div>
                        </form>

                        <?php
                        if (isset($_POST['send_msg'])) {
                            if (isset($_SESSION['userLogin'])) {
                                $uid = $_SESSION['userId'];
                                $name = $_POST['name'];
                                $email = $_SESSION['userEmail'];
                                $subject = $_POST['subject'];
                                $message = $_POST['message'];

                                $insert = "INSERT INTO contact_messages (user_id, name, email, subject, message)
                                           VALUES ($uid, '$name', '$email', '$subject', '$message')";

                                if ($conn->query($insert)) {
                                    echo "<div class='mt-3 alert alert-success'>Thank you! Your message has been sent successfully.</div>";
                                } else {
                                    echo "<div class='mt-3 alert alert-danger'>Something went wrong. Please try again later.</div>";
                                }
                            } else {
                                echo "<script>window.location.href='login.php';</script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Map Section -->
    <section class="pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="h-font text-center mb-4">Our Location</h2>
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14560.102915281716!2d70.76986921864394!3d22.29161489328521!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3beb33ff7b6c1e79%3A0x7e22b229dc8e5e9e!2sSayaji%20Hotel%20Rajkot!5e0!3m2!1sen!2sin!4v1707072976894!5m2!1sen!2sin"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>