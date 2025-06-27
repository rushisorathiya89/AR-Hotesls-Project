<?php
include_once 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "<script>
            alert('Invalid access. No booking ID provided.');
            window.location.href = 'index.php';
          </script>";
    exit;
}

$booking_id = $_GET['id'];
$sql = "SELECT b.*, r.type as room_type_name, r.description 
        FROM bookings b 
        JOIN rooms r ON b.room_id = r.id 
        WHERE b.id = $booking_id";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $booking = $result->fetch_assoc();

    // Check if payment is completed
    if ($booking['payment_status'] !== 'PAID') {
        echo "<script>
                alert('Booking payment is not completed. Redirecting to payment page.');
                window.location.href = 'payment.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Booking not found.');
            window.location.href = 'index.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('11.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            max-width: 700px;
            margin: auto;
            padding: 20px;
        }

        .card {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .confirmation-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .success-icon {
            color: #28a745;
            font-size: 60px;
        }

        .booking-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .booking-id {
            background-color: #e9ecef;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
        }

        .payment-details {
            background-color: #e8f4fc;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn-print {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="confirmation-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#28a745" class="bi bi-check-circle-fill mb-3" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <h2>Booking Confirmed!</h2>
                <p class="text-muted">Your reservation has been successfully processed.</p>
                <div class="booking-id d-inline-block">
                    Booking ID: #<?= $booking_id ?>
                </div>
            </div>

            <div class="booking-details">
                <h4>Booking Details</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Guest Name:</strong> <?= htmlspecialchars($booking['name']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($booking['phone']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Room Type:</strong> <?= htmlspecialchars($booking['room_type_name']) ?></p>
                        <p><strong>Check-in:</strong> <?= date('F j, Y', strtotime($booking['check_in'])) ?></p>
                        <p><strong>Check-out:</strong> <?= date('F j, Y', strtotime($booking['check_out'])) ?></p>
                    </div>
                </div>

                <?php
                // Calculate number of nights
                $check_in = new DateTime($booking['check_in']);
                $check_out = new DateTime($booking['check_out']);
                $nights = $check_in->diff($check_out)->days;

                // Calculate total amount
                $total_amount = $booking['price'] * $nights;
                ?>

                <div class="payment-details">
                    <h5>Payment Summary</h5>
                    <div class="row">
                        <div class="col-md-7">
                            <p><strong>Room Rate:</strong> $<?= number_format($booking['price'], 2) ?> per night</p>
                            <p><strong>Number of Nights:</strong> <?= $nights ?></p>
                            <p><strong>Payment Method:</strong> Razorpay</p>
                            <p><strong>Payment ID:</strong> <?= $booking['payment_id'] ?></p>
                        </div>
                        <div class="col-md-5 text-end">
                            <h4>Total: $<?= number_format($total_amount, 2) ?></h4>
                            <p class="text-success">Payment Status: PAID</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button class="btn btn-print me-2" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5z" />
                    </svg>
                    Print Receipt
                </button>
                <a href="index.php" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house me-2" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Return to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Email confirmation notification -->
    <script>
        $(document).ready(function() {
            // Simulating email confirmation
            setTimeout(function() {
                alert("A confirmation email has been sent to your email address.");
            }, 1500);
        });
    </script>
</body>

</html>