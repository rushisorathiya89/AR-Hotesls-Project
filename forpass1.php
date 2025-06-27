<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - AR Hotels</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin: 0 15px;
        }

        .nav-links a {
            text-decoration: none;
            color: #555;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #111;
        }

        .forgot-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .forgot-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .forgot-header h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .forgot-header p {
            color: #777;
            font-size: 16px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .reset-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .reset-btn:hover {
            background-color: #0069d9;
        }

        .back-to-login {
            text-align: center;
            margin-top: 20px;
            color: #555;
            font-size: 14px;
        }

        .back-to-login a {
            color: #007bff;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .success-message {
            display: none;
            text-align: center;
            padding: 20px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .nav-links {
                display: none;
            }

            .forgot-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="#" class="logo">AR Hotels</a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Dining</a></li>
            <li><a href="#">Weddings</a></li>
            <li><a href="Booking.php">Offers</a></li>
            <li><a href="Review.php">Give review</a></li>
            <li><a href="Booking.php">Book a Room</a></li>
        </ul>
    </nav>

    <div class="forgot-container">
        <div class="forgot-card">
            <div class="forgot-header">
                <h2>Forgot Password</h2>
                <p>Enter your email address below and we'll send you instructions to reset your password.</p>
            </div>

            <div id="successMessage" class="success-message">
                Password reset instructions have been sent to your email. Please check your inbox.
            </div>

            <form id="forgotPasswordForm" action="#" method="post">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <button type="submit" class="reset-btn">Send Reset Link</button>
            </form>

            <div class="back-to-login">
                Remember your password? <a href="login.php">Back to Login</a>
            </div>
        </div>
    </div>


    
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;

            if (email && email.includes('@') && email.includes('.')) {
                document.getElementById('successMessage').style.display = 'block';

                this.style.display = 'none';

                console.log('Password reset requested for:', email);
            } else {
                alert('Please enter a valid email address');
            }
        });
    </script>
</body>

</html> 