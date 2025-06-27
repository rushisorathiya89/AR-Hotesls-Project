<?php
include_once 'db_connect.php';
include_once 'config.php'; // Include config file for Razorpay keys

// Fetch the most recent booking for display
$sql = "SELECT * FROM bookings ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$booking = null;

if ($result && $result->num_rows > 0) {
    $booking = $result->fetch_assoc();
}

// Calculate booking details
if ($booking) {
    // Calculate number of nights
    $check_in = new DateTime($booking['check_in']);
    $check_out = new DateTime($booking['check_out']);
    $nights = $check_in->diff($check_out)->days;

    // Calculate total amount
    $amount = $booking['price'] * $nights;
    $amount_in_paise = $amount * 100; // Razorpay requires amount in paise
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .booking-summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .pay-btn {
            background-color: #528FF0;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Payment</h2>

        <div class="card">
            <?php if ($booking) { ?>
                <!-- Booking Summary -->
                <div class="booking-summary">
                    <h5>Booking Summary</h5>
                    <p><strong>Name:</strong> <?= $booking['name'] ?></p>
                    <p><strong>Room Type:</strong> <?= $booking['room_type'] ?></p>
                    <p><strong>Check-in:</strong> <?= $booking['check_in'] ?></p>
                    <p><strong>Check-out:</strong> <?= $booking['check_out'] ?></p>
                    <p><strong>Number of Nights:</strong> <?= $nights ?></p>
                    <p><strong>Total Amount:</strong> $<?= number_format($amount, 2) ?></p>
                </div>

                <!-- Razorpay Payment Button -->
                <div class="text-center">
                    <button id="rzp-button" class="pay-btn">Pay Now $<?= number_format($amount, 2) ?></button>
                </div>

                <!-- Hidden form for verification -->
                <form name="razorpayform" id="razorpayform" action="confirm_payment.php" method="POST">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <input type="hidden" name="amount" value="<?= $amount_in_paise ?>">
                </form>
            <?php } else { ?>
                <p>No booking found. Please <a href="index.php">make a booking</a> first.</p>
            <?php } ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Razorpay payment initialization
            var options = {
                "key": "<?php echo RAZORPAY_KEY_ID; ?>", // Enter the Key ID generated from the Dashboard
                "amount": "<?php echo $amount_in_paise; ?>", // Amount is in currency subunits. Default currency is INR
                "currency": "USD",
                "name": "Hotel Booking",
                "description": "Room Booking Payment",
                "image": "logo.png", // Add your logo image
                "handler": function(response) {
                    // On payment success
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    document.razorpayform.submit();
                },
                "prefill": {
                    "name": "<?php echo $booking['name']; ?>",
                    "email": "<?php echo $booking['email']; ?>",
                    "contact": "<?php echo $booking['phone']; ?>"
                },
                "theme": {
                    "color": "#528FF0"
                }
            };

            var rzp1 = new Razorpay(options);
            document.getElementById('rzp-button').onclick = function(e) {
                rzp1.open();
                e.preventDefault();
            }
        });
    </script>
</body>

</html>