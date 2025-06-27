<?php
include 'header.php';

if (isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true) {
    header('Location: admin/admin_pannel.php');
    exit();
} else if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) {
    header('Location: index.php');
    exit();
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $login_error = 'Please enter both email and password.';
    } else {


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $select = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = $conn->query($select);

        // If the user is found
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Check user role and set session accordingly
            if ($row['role'] == 'admin') {
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminId'] = $row['id'];
                $_SESSION['adminEmail'] = $row['email'];
                header('Location: admin/admin_pannel.php');
                exit();  // End the script here after redirecting
            } else {
                $_SESSION['userLogin'] = true;
                $_SESSION['userId'] = $row['id'];
                $_SESSION['userEmail'] = $row['email'];
                header('Location: index.php');
                exit();  // End the script here after redirecting
            }
        } else {
            // Error if the login details are incorrect
            $login_error = 'Invalid email or password. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AR HOTELS</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('1.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 450px;
            margin-top: 80px;
        }

        .login-container h2 {
            margin-bottom: 10px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -8px;
            margin-bottom: 5px;
            text-align: left;
        }

        .server-error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
            display: block;
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Welcome Back</h2>
        <p>Sign in to your AR Hotels account</p>

        <!-- Show error message if login failed -->
        <?php if (isset($login_error)): ?>
            <div class="server-error"><?php echo $login_error; ?></div>
        <?php endif; ?>

        <form id="loginForm" method="POST" action="login.php">
            <input type="email" id="email" name="email" placeholder="Email Address"
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

            <input type="password" id="password" name="password" placeholder="Password">

            <div class="forgot-password">
                <a href="forpass.php">Forgot password?</a>
            </div>

            <button name="login" type="submit">Log in</button>
        </form>

        <p>Don't have an account? <a href="Register.php">Sign up</a></p>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize form validation
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be at least 6 characters long"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("error");
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("error").removeClass("valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("error").addClass("valid");
                },
                submitHandler: function(form) {
                    // This will be called when the form is valid
                    form.submit();
                }
            });
        });
    </script>

</body>

</html>