<?php include 'header.php';
include 'db_connect.php';
$select = "SELECT * FROM `rooms` WHERE `is_discounted`=1";
$result = $conn->query($select);

if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) {
    $url = "Booking.php";
} else {
    $url = "login.php";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AR Hotels - Room Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .btn {
            border-radius: 5px;
            padding: 10px;
        }

        .discount-badge {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .room-details-img {
            max-height: 300px;
            width: 100%;
            object-fit: cover;
        }

        .amenities-list {
            list-style: none;
            padding: 0;
        }

        .amenities-list li {
            margin-bottom: 8px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .original-price {
            text-decoration: line-through;
            color: #6c757d;
        }

        .discounted-price {
            color: #28a745;
            font-weight: bold;
        }

        .section-title {
            color: #fff;
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 10px;
            margin: 30px 0;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center section-title">Discounted Rooms (25% OFF)</h2>
        <div class="row">
            <?php

            while ($room = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card border-success">
                        <div class="discount-badge">25% OFF</div>
                        <img src="images/' . $room['image'] . '" class="card-img-top" alt="' . $room['type'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $room['type'] . '</h5>
                            <p class="original-price">Original Price: $' . $room['price'] . '</p>
                            <p class="discounted-price">Discounted Price: $' . $room['discount_price'] . ' per night</p>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomModal' . $room['id'] . '">
                                    View Details
                                </button>
                                <a href="' . $url . '?id=' . $room['id'] . '" class="btn btn-success">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Discounted Room Details Modal -->
                <div class="modal fade" id="roomModal' . $room['id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">' . $room['type'] . ' Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="images/' . $room['image'] . '" class="room-details-img mb-4" alt="' . $room['type'] . '">
                                <div class="alert alert-success">
                                    <strong>Special Offer!</strong> 25% discount available for this room!
                                </div>
                                <h6>Description:</h6>
                                <p>' . $room['description'] . '</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Room Details:</h6>
                                        <p>Size: ' . $room['size'] . '<br>
                                        Capacity: ' . $room['capacity'] . '<br>
                                        View: ' . $room['view'] . '</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Amenities:</h6>
                                        <ul class="amenities-list">';

                $amenities = explode(',', $room['amenities']);
                foreach ($amenities as $amenity) {
                    echo '<li>✓ ' . trim($amenity) . '</li>';
                }

                echo '</ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="h4 mb-3">
                                        <span class="original-price">Original Price: $' . $room['price'] . '</span><br>
                                        <span class="discounted-price">Special Price: $' . $room['discount_price'] . ' per night</span>
                                    </p>
                                    <a href="' . $url . '?id=' . $room['id'] . '" class="btn btn-success">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>