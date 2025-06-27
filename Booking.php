<?php
include_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_id   = (int)$_POST['room_id'];
    $room_type = $_POST['room_type'];
    $name      = $_POST['name'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $check_in  = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $price     = (float)$_POST['price'];

    if (
        empty($room_id) || empty($room_type) || empty($name) || empty($email) ||
        empty($phone) || empty($check_in) || empty($check_out) || empty($price)
    ) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        // 🔍 Check for room availability (no overlap with existing bookings)
        $conflict_query = "SELECT * FROM bookings 
                           WHERE room_id = $room_id 
                           AND (
                               ('$check_in' < check_out) AND ('$check_out' > check_in)
                           )";

        $conflict_result = $conn->query($conflict_query);

        if ($conflict_result && $conflict_result->num_rows > 0) {
            echo "<script>
                    alert('This room is already booked for the selected dates. Please choose different dates or another room.');
                  </script>";
        } else {
            // ✅ No conflict, insert booking with initial 'PENDING' payment status
            $sql = "INSERT INTO bookings (room_id, room_type, name, email, phone, check_in, check_out, price, payment_status)
                    VALUES (
                        $room_id,
                        '$room_type',
                        '$name',
                        '$email',
                        '$phone',
                        '$check_in',
                        '$check_out',
                        $price,
                        'PENDING'
                    )";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        alert('Booking created successfully! Proceeding to payment.');
                        window.location.href = 'payment.php';
                      </script>";
                exit;
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}

// Fetch room data
if (isset($_GET['id'])) {
    $uid = $_GET['id'];
    $select = "SELECT * FROM `rooms` WHERE `id`=$uid";
    $result = $conn->query($select);
    $room = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Confirm Your Booking</h2>
        <div class="card">
            <?php if (!empty($room)) { ?>
                <h4>Room Type: <?= $room['type'] ?></h4>
                <p><strong>Price per Day:</strong> $<?= ($room['discount_price']) ? $room['discount_price'] : $room['price']; ?></p>

                <form id="bookingForm" method="POST">
                    <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                    <input type="hidden" name="price" value="<?= ($room['discount_price']) ? $room['discount_price'] : $room['price']; ?>">

                    <label>Name:</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <span class="error" id="nameError"></span><br>

                    <label>Email:</label>
                    <input type="email" name="email" id="email" class="form-control">
                    <span class="error" id="emailError"></span><br>

                    <label>Room Type:</label>
                    <input type="text" name="room_type" value="<?= htmlspecialchars($room['type']) ?>" readonly class="form-control"><br>

                    <label>Phone:</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                    <span class="error" id="phoneError"></span><br>

                    <label>Check-in Date:</label>
                    <input type="date" name="check_in" id="check_in" class="form-control" min="<?= date('Y-m-d'); ?>">
                    <span class="error" id="checkInError"></span><br>

                    <label>Check-out Date:</label>
                    <input type="date" name="check_out" id="check_out" class="form-control" min="<?= date('Y-m-d', strtotime('+1 day')); ?>">
                    <span class="error" id="checkOutError"></span><br>

                    <button type="submit" class="btn btn-primary mt-3 w-100">Proceed to Payment</button>
                </form>
            <?php } else { ?>
                <p>Room not found.</p>
            <?php } ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Set minimum dates for check-in and check-out
            const today = new Date().toISOString().split('T')[0];
            $("#check_in").attr('min', today);

            // Update check-out min date when check-in changes
            $("#check_in").change(function() {
                const checkInDate = new Date($(this).val());
                const nextDay = new Date(checkInDate);
                nextDay.setDate(checkInDate.getDate() + 1);
                const nextDayStr = nextDay.toISOString().split('T')[0];
                $("#check_out").attr('min', nextDayStr);

                // If current check-out date is before new minimum, update it
                if ($("#check_out").val() && new Date($("#check_out").val()) <= checkInDate) {
                    $("#check_out").val(nextDayStr);
                }
            });

            $("#bookingForm").submit(function(event) {
                $(".error").text("");
                let isValid = true;

                let name = $("#name").val().trim();
                if (name === "") {
                    $("#nameError").text("Name is required.");
                    isValid = false;
                }

                let email = $("#email").val().trim();
                let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(email)) {
                    $("#emailError").text("Enter a valid email.");
                    isValid = false;
                }

                let phone = $("#phone").val().trim();
                let phonePattern = /^[0-9]{10}$/;
                if (!phonePattern.test(phone)) {
                    $("#phoneError").text("Enter a valid 10-digit phone number.");
                    isValid = false;
                }

                let checkIn = $("#check_in").val();
                let checkOut = $("#check_out").val();

                if (checkIn === "") {
                    $("#checkInError").text("Check-in date is required.");
                    isValid = false;
                }
                if (checkOut === "") {
                    $("#checkOutError").text("Check-out date is required.");
                    isValid = false;
                }
                if (checkIn !== "" && checkOut !== "" && checkIn >= checkOut) {
                    $("#checkOutError").text("Check-out date must be after check-in date.");
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>