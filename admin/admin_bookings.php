<?php
$conn = new mysqli("localhost", "root", "", "ar_hotels");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cancel Booking
if (isset($_POST['cancel_booking'])) {
    $bookingId = $_POST['booking_id'];
    $conn->query("DELETE FROM bookings WHERE id = $bookingId");
    echo "<script>alert('Booking cancelled successfully!'); window.location.href='admin_bookings.php';</script>";
}

// Add New Booking
if (isset($_POST['add_booking'])) {
    $room_id = $_POST['room_id'];
    $room_type = $_POST['room_type'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $price = $_POST['price'];
    $payment_status = $_POST['payment_status'];
    $created_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO bookings (room_id, room_type, name, email, phone, check_in, check_out, price, created_at, payment_status)
            VALUES ('$room_id', '$room_type', '$name', '$email', '$phone', '$check_in', '$check_out', '$price', '$created_at', '$payment_status')";

    if ($conn->query($sql)) {
        echo "<script>alert('Booking added successfully!'); window.location.href='admin_bookings.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$bookings = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        h1,
        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-bottom: 40px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #eee;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
        }

        input,
        select {
            padding: 8px;
            width: 100%;
            margin: 5px 0 15px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            background: #3498db;
            color: white;
            cursor: pointer;
        }

        .btn-danger {
            background: #e74c3c;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            tr {
                margin-bottom: 15px;
                background: #fff;
                padding: 10px;
                border: 1px solid #ddd;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
            }

            th {
                display: none;
            }

            td {
                padding: 8px 5px;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <?php include 'admin_sidebar.php'; ?>

    <div class="main-content">
        <h1>Manage Bookings</h1>

        <h2>All Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Room Type</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1;
                while ($row = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Sr. No"><?= $sn++ ?></td>
                        <td data-label="Room Type"><?= $row['room_type'] ?></td>
                        <td data-label="Name"><?= $row['name'] ?></td>
                        <td data-label="Email"><?= $row['email'] ?></td>
                        <td data-label="Phone"><?= $row['phone'] ?></td>
                        <td data-label="Check-in"><?= $row['check_in'] ?></td>
                        <td data-label="Check-out"><?= $row['check_out'] ?></td>
                        <td data-label="Price">₹<?= $row['price'] ?></td>
                        <td data-label="Payment"><?= $row['payment_status'] ?></td>
                        <td data-label="Created"><?= $row['created_at'] ?></td>
                        <td data-label="Action">
                            <form method="POST" onsubmit="return confirm('Are you sure to cancel this booking?');">
                                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="cancel_booking" class="btn btn-danger">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Add New Booking</h2>
        <form method="POST">
            <input type="number" name="room_id" placeholder="Room ID" required>
            <input type="text" name="room_type" placeholder="Room Type" required>
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="email" name="email" placeholder="Customer Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="date" name="check_in" required>
            <input type="date" name="check_out" required>
            <input type="number" name="price" step="0.01" placeholder="Total Price" required>
            <select name="payment_status" required>
                <option value="PAID">PAID</option>
                <option value="PENDING">PENDING</option>
            </select>
            <button type="submit" name="add_booking" class="btn">Add Booking</button>
        </form>
    </div>

</body>

</html>