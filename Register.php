<?php include 'Header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Hotels - Register</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('reg.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Navbar styling */
        .header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            margin-top: 80px;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error {
            color: red;
            font-size: 12px;
            display: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: darkblue;
        }

        .custom-alert {
            position: fixed;
            top: 25px;
            right: 25px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#registerForm").submit(function(event) {
                $(".error").hide();
                var fullName = $("#fullName").val().trim();
                var email = $("#email").val().trim();
                var password = $("#password").val().trim();
                var mobile = $("#mobile").val().trim();
                var valid = true;


                if (fullName.length < 3) {
                    $("#nameError").text("Full name must be at least 3 characters.").show();
                    valid = false;
                }

                var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(email)) {
                    $("#emailError").text("Please enter a valid email address.").show();
                    valid = false;
                }

                if (password.length < 6) {
                    $("#passwordError").text("Password must be at least 6 characters long.").show();
                    valid = false;
                }

                var mobilePattern = /^[0-9]{10}$/;
                if (!mobilePattern.test(mobile)) {
                    $("#mobileError").text("Enter a valid 10-digit mobile number.").show();
                    valid = false;
                }


                var file = $("#profile_picture").prop("files")[0];
                if (file) {
                    var fileType = file.type;
                    if (!fileType.startsWith("image/")) {
                        $("#profilePictureError").text("Only image files are allowed.").show();
                        valid = false;
                    }
                }


                if (!valid) {
                    event.preventDefault(); // Prevent form submission if validation fails
                }
            });
        });

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
                        if (response == 'true') {
                            $('#emailError').text('Email already registered.').show();
                            $('#email').addClass('is-invalid');
                            $('#email').removeClass('is-valid');
                            $('#emailError').addClass('text-danger');
                            $('#emailError').removeClass('text-success');
                        } else {
                            $('#emailError').text('This email is available').show();
                            $('#email').removeClass('is-invalid');
                            $('#email').addClass('is-valid');
                            $('#emailError').addClass('text-success');
                            $('#emailError').removeClass('text-danger');
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>


    <div class="container">
        <h2>Create an Account</h2>
        <form id="registerForm" action="Register.php" method="POST">
            <div class="input-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="full_name">
                <span class="error" id="nameError"></span>
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email">
                <span class="error" id="emailError"></span>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <span class="error" id="passwordError"></span>
            </div>

            <div class="input-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" id="mobile" name="mobile">
                <span class="error" id="mobileError"></span>
            </div>

            <div class="input-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                <span class="error" id="profilePictureError"></span>
            </div>

            <button name="register" type="submit">Register</button>
            <div class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

</body>


<?php

if (isset($_POST['register'])) {
    $fname = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $profile_picture = $_POST['profile_picture'];
    $token = md5(uniqid(rand(), true));

    $check_email = "SELECT `email` FROM `users` WHERE `email`='$email' LIMIT 1";
    $check_email_run = $conn->query($check_email);

    if ($check_email_run->num_rows > 0) {
        alert('error', 'Email Id already exists');
    } else {
        $register_query = "INSERT INTO `users`(`name`,`email`, `password`, `mobile_no`, `profile_picture`, `verification_token`) VALUES ('$fname','$email','$password','$mobile','$profile_picture','$token')";


        if ($conn->query($register_query)) {
            $link = 'http://localhost/ARHOTELS/CIE%202(k)1/CIE%202(k)/verify_email.php?email=' . $email . '&token=' . $token;
            $body = "<div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                        <h2 style='color: #dc3545; text-align: center;'>Account Verification</h2>
                        <p style='text-align: center;'>Click on the button below to verify your account</p>
                        <a href='" . $link . "' style='display: block; width: 200px; margin: 0 auto; text-align: center; background-color: #dc3545; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Account</a>
                    </div>";
            $subject = "Account Verification Mail";

            if (sendEmail($email, $subject, $body, "")) {
                echo '<br>';
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Registration Successful!</strong> Account verification link has been sent to your email. Verify your email to login.
                      </div>';
            } else {
                echo '<br>';
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Failed to send the registration link.
                      </div>';
            }
        } else {
            alert('error', 'Registration falied');
        }
    }

    // redirect('index.php');
    // alert('success', 'Registration Successfully! Please verify your email');


?>
    <!-- <script>
        window.location.href = 'register.php';
    </script> -->
<?php


}




?>

</html>