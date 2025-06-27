<?php
include_once 'db_connect.php';
include_once 'config.php';

// Initialize Razorpay API
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Verify payment signature
  $success = false;

  if (isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_signature'])) {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $razorpay_payment_id = $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];

    // Create Razorpay API instance
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    // Build expected signature for verification
    // NOTE: orderId isn't passed in the form, generate it as needed or modify this to match your implementation
    $order_id = "order_" . $booking_id . "_" . time();

    try {
      // Verify signature
      $attributes = array(
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_order_id' => $order_id,
        'razorpay_signature' => $razorpay_signature
      );

      // This will throw an exception if invalid
      $api->utility->verifyPaymentSignature($attributes);
      $success = true;

      // Update booking payment status
      $update_sql = "UPDATE bookings SET 
                          payment_status = 'PAID', 
                          payment_id = '$razorpay_payment_id' 
                          WHERE id = $booking_id";

      if ($conn->query($update_sql) === TRUE) {
        // Store transaction details if needed
        $insert_transaction = "INSERT INTO transactions (booking_id, payment_id, amount, status) 
                                      VALUES ($booking_id, '$razorpay_payment_id', $amount/100, 'SUCCESS')";
        $conn->query($insert_transaction);

        echo "<script>
                        alert('Payment processed successfully!');
                        window.location.href = 'booking_confirmation.php?id=$booking_id';
                      </script>";
        exit;
      } else {
        echo "<script>alert('Error updating payment status: " . $conn->error . "');</script>";
      }
    } catch (SignatureVerificationError $e) {
      // Handle signature verification failure
      $error = 'Razorpay Error: ' . $e->getMessage();

      // Log payment failure
      $insert_transaction = "INSERT INTO transactions (booking_id, payment_id, amount, status, error) 
                                  VALUES ($booking_id, '$razorpay_payment_id', $amount/100, 'FAILED', '$error')";
      $conn->query($insert_transaction);

      echo "<script>
                    alert('Payment verification failed. Please try again.');
                    window.location.href = 'payment.php';
                  </script>";
      exit;
    }
  } else {
    echo "<script>
                alert('Payment information missing. Please try again.');
                window.location.href = 'payment.php';
              </script>";
    exit;
  }
} else {
  // If accessed directly without POST data
  echo "<script>
            alert('Invalid access. Please complete your booking first.');
            window.location.href = 'index.php';
          </script>";
  exit;
}
