<?php include 'header.php'; ?>

<script>
    $(document).ready(function() {
        $('#email').on('blur', function() {
            var email = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'check_duplicate_Email.php',
                data: {
                    email1: email
                },
                success: function(response) {
                    if (response == 'false') {
                        $('#emailError').text('Email is not registered. Please enter registered email addrerss').show();
                        $('#email').addClass('is-invalid');
                    }
                }
            });
        });
    });
</script>

<div class="container py-5">
    <div class="card forgot-card">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">Forgot Password</h2>
            <p class="text-muted text-center mb-4">Enter your email address and we'll send you instructions to reset your password.</p>

            <form action="forpass.php" method="post">
                <div class="mb-4">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" data-validation="required email">
                    <div class="error" id="emailError"></div>
                </div>

                <button type="submit" class="btn btn-outline-danger w-100 mb-3" name="forgot_btn">Reset Password</button>

                <div class="text-center">
                    <a href="login.php" class="text-danger text-decoration-none">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php';

if (isset($_POST['forgot_btn'])) {
    $email = $_POST['email'];

    $query = "SELECT * FROM password_token WHERE email = '$email'";
    $result = mysqli_fetch_assoc($conn->query($query));
    $otp = rand(100000, 999999);
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
                <p class='otp'>$otp</p>
                <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                <p>If you did not request a password reset, please ignore this email.</p>
                <div class='footer'>
                    <p>This is an automated message, please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";

    $subject = "Password Reset - OTP";
    $email_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime('+2 minutes'));
    if ($result) {
        $attempts = $result['otp_attempts'];
        if ($attempts >= 3) {
            // Email exists, display error message and redirect to OTP form
            setcookie('error', "The maximum limit for generating OTP is reached you can generate a new OTP after 24 hours from the last OTP generated time.", time() + 5, "/");
?>
            <script>
                window.location.href = "login.php";
            </script>
        <?php
        } else {
            $q = "UPDATE password_token SET otp=$otp, otp_attempts=$attempts+1, last_resend=now(), created_at = '$email_time', expires_at='$expiry_time' WHERE email='$email'";
        }
    } else {
        $attempts = 0;
        $q = "INSERT INTO  password_token  (email, otp, created_at,expires_at,otp_attempts,last_resend) VALUES ('$email', '$otp', '$email_time','$expiry_time',$attempts,now())";
    }
    if (sendEmail($email, $subject, $body, "")) {
        if ($conn->query($q)) {
            $_SESSION['forgot_email'] = $email;
            setcookie('success', 'OTP sent to registered email address. the OTP will expire in 2 Minutes.', time() + 5);
        ?>
            <script>
                window.location.href = "otp_form.php";
            </script>
<?php
        } else {
            setcookie('error', 'Failed to generate OTP and store it in the database', time() + 5);
        }
    } else {
        setcookie('error', 'Failed to send the OTP in mail. Please try after sometime.', time() + 5);
    }
}
?>