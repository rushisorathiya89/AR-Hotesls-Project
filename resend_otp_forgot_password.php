<?php
include_once("Header.php");
// session_start();
include 'db_connect.php';

if (isset($_SESSION['forgot_email'])) {
    $email = $_SESSION['forgot_email'];

    // Fetch OTP attempts and last resend time
    $query = "SELECT otp_attempts, last_resend FROM password_token WHERE email = '$email'";
    $result = $con->query($query);
    $row = mysqli_fetch_assoc($result);

    $attempts = $row['otp_attempts'];
    // $lastResend = strtotime($row['last_resend']);

    // // Check time difference (2 minutes = 120 seconds)
    // if (time() - $lastResend < 120) {
    //     echo "<script>alert('Please wait for 2 minutes before resending OTP.'); window.location.href='otp_form.php';</script>";
    //     exit();
    // }

    // Block further resends after 3 attempts
    if ($attempts >= 3) {
        setcookie('error', "OTP resend limit reached. you can generate a new OTP after 24 hours.", time() + 5, "/");
?>
        <script>
            window.location.href = 'login.php';
        </script>
        <?php
        exit();
    }
    $email_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime('+2 minutes'));
    // Generate a new OTP
    $new_otp = rand(100000, 999999);
    $updateQuery = "UPDATE password_token SET otp=$new_otp, otp_attempts=$attempts+1, last_resend=now(), created_at='$email_time', expires_at='$expiry_time' WHERE email='$email'";
    if ($con->query($updateQuery)) {
        $to = $email;
        $subject = "Reset password";
        $body = "<html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; }
                h1 { color: black; }
                .otp { font-size: 24px; font-weight: bold; color:  #dc3545; }
                .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Forgot Your Password?</h1>
                <p>We received a request to reset your password. Here is your One-Time Password (OTP):</p>
                <p class='otp'>$new_otp</p>
                <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                <p>If you did not request a password reset, please ignore this email.</p>
                <div class='footer'>
                    <p>This is an automated message, please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        if (sendEmail($to, $subject, $body, "")) {
            setcookie("success", "OTP for reset password is sent successfully", time() + 5, "/");
        ?>
            <script>
                window.location.href = "otp_form.php";
            </script>
        <?php
        } else {
            setcookie("error", "Error in sending OTP for reset password", time() + 5, "/");
        ?>
            <script>
                window.location.href = "forpass.php";
            </script>
<?php
        }
    }


    // Send OTP via email (replace with your mailing function)


    echo "<script>alert('New OTP sent.'); window.location.href='otp_form.php';</script>";
}
