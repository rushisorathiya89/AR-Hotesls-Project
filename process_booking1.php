<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['booking_details'] = $_POST; // Store form data in session
    header("Location: payment.php"); // Redirect to payment page
    exit();
} else {
    echo "Invalid request!";
}
