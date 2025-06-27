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
    <?php include 'Header1.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center section-title">Available Rooms</h2>
        <div class="row">
            <?php
            $rooms = [
                [
                    "id" => 1,
                    "type" => "Deluxe Room",
                    "price" => 120,
                    "image" => "diluxroom.jpg",
                    "description" => "Spacious deluxe room with modern amenities and elegant decor",
                    "size" => "400 sq ft",
                    "capacity" => "2 Adults + 1 Child",
                    "amenities" => ["King-size bed", "Mini bar", "Smart TV", "Work desk", "Free Wi-Fi", "Air conditioning"],
                    "view" => "City view"
                ],
                [
                    "id" => 2,
                    "type" => "Standard Room",
                    "price" => 80,
                    "image" => "standared.jpg",
                    "description" => "Comfortable standard room with essential amenities",
                    "size" => "300 sq ft",
                    "capacity" => "2 Adults",
                    "amenities" => ["Queen-size bed", "TV", "Work desk", "Free Wi-Fi", "Air conditioning"],
                    "view" => "Garden view"
                ],
                [
                    "id" => 3,
                    "type" => "Suite",
                    "price" => 200,
                    "image" => "suit.jpg",
                    "description" => "Luxurious suite with separate living area and premium amenities",
                    "size" => "600 sq ft",
                    "capacity" => "2 Adults + 2 Children",
                    "amenities" => ["King-size bed", "Mini bar", "Smart TV", "Living room", "Kitchenette", "Premium Wi-Fi"],
                    "view" => "Ocean view"
                ],
                [
                    "id" => 4,
                    "type" => "Family Room",
                    "price" => 150,
                    "image" => "family.jpg",
                    "description" => "Spacious family room perfect for larger groups",
                    "size" => "500 sq ft",
                    "capacity" => "4 Adults",
                    "amenities" => ["2 Queen-size beds", "TV", "Mini fridge", "Free Wi-Fi", "Family seating area"],
                    "view" => "Pool view"
                ],
                [
                    "id" => 5,
                    "type" => "Single Room",
                    "price" => 60,
                    "image" => "single.jpg",
                    "description" => "Cozy single room ideal for solo travelers",
                    "size" => "200 sq ft",
                    "capacity" => "1 Adult",
                    "amenities" => ["Single bed", "TV", "Desk", "Wi-Fi", "Air conditioning"],
                    "view" => "City view"
                ],
                [
                    "id" => 6,
                    "type" => "Couple Room",
                    "price" => 500,
                    "image" => "couple.jpg",
                    "description" => "Romantic room designed for couples with luxury amenities",
                    "size" => "450 sq ft",
                    "capacity" => "2 Adults",
                    "amenities" => ["King-size bed", "Jacuzzi", "Smart TV", "Mini bar", "Premium Wi-Fi", "Balcony"],
                    "view" => "Ocean view"
                ]
            ];

            foreach ($rooms as $room) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/' . $room['image'] . '" class="card-img-top" alt="' . $room['type'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $room['type'] . '</h5>
                            <p class="card-text">Price: $' . $room['price'] . ' per night</p>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomModal' . $room['id'] . '">
                                    View Details
                                </button>
                                <a href="book_room1.php?id=' . $room['id'] . '" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Details Modal -->
                <div class="modal fade" id="roomModal' . $room['id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">' . $room['type'] . ' Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="images/' . $room['image'] . '" class="room-details-img mb-4" alt="' . $room['type'] . '">
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
                foreach ($room['amenities'] as $amenity) {
                    echo '<li>✓ ' . $amenity . '</li>';
                }
                echo '</ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="h4 mb-3">Price: $' . $room['price'] . ' per night</p>
                                    <a href="book_room.php?id=' . $room['id'] . '" class="btn btn-primary">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>

        <h2 class="text-center section-title">Discounted Rooms (25% OFF)</h2>
        <div class="row">
            <?php
            $discounted_rooms = [
                [
                    "id" => 7,
                    "type" => "Economy Room",
                    "original_price" => 60,
                    "discount_price" => 45,
                    "image" => "economy.jpg",
                    "description" => "Budget-friendly room with essential amenities",
                    "size" => "250 sq ft",
                    "capacity" => "2 Adults",
                    "amenities" => ["Double bed", "TV", "Basic Wi-Fi", "Air conditioning"],
                    "view" => "City view"
                ],
                [
                    "id" => 8,
                    "type" => "Compact Room",
                    "original_price" => 80,
                    "discount_price" => 60,
                    "image" => "compact.jpg",
                    "description" => "Efficiently designed compact room for short stays",
                    "size" => "200 sq ft",
                    "capacity" => "2 Adults",
                    "amenities" => ["Queen-size bed", "TV", "Wi-Fi", "Work corner"],
                    "view" => "Garden view"
                ],
                [
                    "id" => 9,
                    "type" => "Small Suite",
                    "original_price" => 100,
                    "discount_price" => 75,
                    "image" => "small.jpg",
                    "description" => "Cozy suite with modern amenities",
                    "size" => "300 sq ft",
                    "capacity" => "2 Adults + 1 Child",
                    "amenities" => ["Queen-size bed", "TV", "Mini fridge", "Wi-Fi", "Seating area"],
                    "view" => "Pool view"
                ]
            ];

            foreach ($discounted_rooms as $room) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card border-success">
                        <div class="discount-badge">25% OFF</div>
                        <img src="images/' . $room['image'] . '" class="card-img-top" alt="' . $room['type'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $room['type'] . '</h5>
                            <p class="original-price">Original Price: $' . $room['original_price'] . '</p>
                            <p class="discounted-price">Discounted Price: $' . $room['discount_price'] . ' per night</p>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomModal' . $room['id'] . '">
                                    View Details
                                </button>
                                <a href="book_room.php?id=' . $room['id'] . '" class="btn btn-success">Book Now</a>
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
                foreach ($room['amenities'] as $amenity) {
                    echo '<li>✓ ' . $amenity . '</li>';
                }
                echo '</ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="h4 mb-3">
                                        <span class="original-price">Original Price: $' . $room['original_price'] . '</span><br>
                                        <span class="discounted-price">Special Price: $' . $room['discount_price'] . ' per night</span>
                                    </p>
                                    <a href="book_room.php?id=' . $room['id'] . '" class="btn btn-success">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>