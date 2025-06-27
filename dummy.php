<?php
$rooms = [
    1 => ["type" => "Deluxe Room", "price" => 120],
    2 => ["type" => "Standard Room", "price" => 80],
    3 => ["type" => "Suite", "price" => 200],
    4 => ["type" => "Family Room", "price" => 150],
    5 => ["type" => "Single Room", "price" => 60],
    6 => ["type" => "Presidential Suite", "price" => 500]
];

$discounted_rooms = [
    7 => ["type" => "Economy Room", "original_price" => 60, "price" => 45],
    8 => ["type" => "Compact Room", "original_price" => 80, "price" => 60],
    9 => ["type" => "Small Suite", "original_price" => 100, "price" => 75]
];

$all_rooms = $rooms + $discounted_rooms;  // Merge both room lists

$room_id = $_GET['id'] ?? 1;  // Get room ID from URL, default to 1
$room = $all_rooms[$room_id] ?? $rooms[1]; // If invalid, use default
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
            background-color: #f8f9fa;
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

        body {
            background-image: url('11.jpg');
            /* Update with the correct path */
            background-size: cover;
            /* Ensures the image covers the whole page */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents repetition */
            background-attachment: fixed;
            /* Makes the background stay fixed when scrolling */
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Confirm Your Booking</h2>
        <div class="card">
            <h4>Room Type: <?= $room['type'] ?></h4>
            <p>
                <?php if (isset($room['original_price'])): ?>
                    <strong>Original Price:</strong> <s>$<?= $room['original_price'] ?></s><br>
                    <strong>Discounted Price:</strong> <span style="color: green;">$<?= $room['price'] ?></span>
                <?php else: ?>
                    <strong>Price per Night:</strong> $<?= $room['price'] ?>
                <?php endif; ?>
            </p>

            <form id="bookingForm" action="process_booking.php" method="POST">
                <input type="hidden" name="room_id" value="<?= $room_id ?>">
                <input type="hidden" name="room_type" value="<?= $room['type'] ?>">
                <input type="hidden" name="price" value="<?= $room['price'] ?>">

                <label>Name:</label>
                <input type="text" name="name" id="name" class="form-control">
                <span class="error" id="nameError"></span>
                <br>

                <label>Email:</label>
                <input type="email" name="email" id="email" class="form-control">
                <span class="error" id="emailError"></span>
                <br>

                <label>Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control">
                <span class="error" id="phoneError"></span>
                <br>

                <label>Check-in Date:</label>
                <input type="date" name="check_in" id="check_in" class="form-control">
                <span class="error" id="checkInError"></span>
                <br>

                <label>Check-out Date:</label>
                <input type="date" name="check_out" id="check_out" class="form-control">
                <span class="error" id="checkOutError"></span>
                <br>

                <button type="submit" class="btn btn-primary mt-3">Confirm Booking</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#bookingForm").submit(function(event) {
                $(".error").text(""); // Clear previous errors
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