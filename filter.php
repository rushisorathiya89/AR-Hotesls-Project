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

        .filter-section {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .filter-section label {
            font-weight: bold;
            margin-right: 10px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <!-- Filter Section -->
        <div class="filter-section">
            <h3>Filter Rooms</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="roomType">Room Type:</label>
                    <select id="roomType" class="form-control">
                        <option value="">All</option>
                        <option value="Deluxe Room">Deluxe Room</option>
                        <option value="Standard Room">Standard Room</option>
                        <option value="Suite">Suite</option>
                        <option value="Family Room">Family Room</option>
                        <option value="Single Room">Single Room</option>
                        <option value="Couple Room">Couple Room</option>
                        <option value="Economy Room">Economy Room</option>
                        <option value="Compact Room">Compact Room</option>
                        <option value="Small Suite">Small Suite</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="priceRange">Price Range:</label>
                    <select id="priceRange" class="form-control">
                        <option value="">All</option>
                        <option value="0-100">$0 - $100</option>
                        <option value="100-200">$100 - $200</option>
                        <option value="200-500">$200 - $500</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="capacity">Capacity:</label>
                    <select id="capacity" class="form-control">
                        <option value="">All</option>
                        <option value="1 Adult">1 Adult</option>
                        <option value="2 Adults">2 Adults</option>
                        <option value="2 Adults + 1 Child">2 Adults + 1 Child</option>
                        <option value="4 Adults">4 Adults</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="view">View:</label>
                    <select id="view" class="form-control">
                        <option value="">All</option>
                        <option value="City view">City view</option>
                        <option value="Garden view">Garden view</option>
                        <option value="Ocean view">Ocean view</option>
                        <option value="Pool view">Pool view</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary mt-3" onclick="applyFilters()">Apply Filters</button>
            <button class="btn btn-secondary mt-3" onclick="clearFilters()">Clear Filters</button>
        </div>

        <!-- Rooms Section -->
        <h2 class="text-center section-title">Available Rooms</h2>
        <div class="row" id="roomContainer">
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
                ],


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

            // Combine all rooms into one array
            $all_rooms = $rooms;

            // Render all rooms
            foreach ($rooms as $room) {
                $price = isset($room['discount_price']) ? $room['discount_price'] : $room['price'];
                echo '
                <div class="col-md-4 mb-4 room-card" 
                     data-type="' . $room['type'] . '" 
                     data-price="' . $price . '" 
                     data-capacity="' . $room['capacity'] . '" 
                     data-view="' . $room['view'] . '">
                    <div class="card">
                        <img src="images/' . $room['image'] . '" class="card-img-top" alt="' . $room['type'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $room['type'] . '</h5>
                            <p class="card-text">Price: $' . $price . ' per night</p>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomModal' . $room['id'] . '">
                                    View Details
                                </button>
                                <a href="book_room.php?id=' . $room['id'] . '" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <script>
        function applyFilters() {
            const roomType = document.getElementById('roomType').value.toLowerCase();
            const priceRange = document.getElementById('priceRange').value;
            const capacity = document.getElementById('capacity').value.toLowerCase();
            const view = document.getElementById('view').value.toLowerCase();

            const rooms = document.querySelectorAll('.room-card');
            let visibleCount = 0;

            rooms.forEach(room => {
                const type = room.getAttribute('data-type').toLowerCase();
                const price = parseFloat(room.getAttribute('data-price'));
                const roomCapacity = room.getAttribute('data-capacity').toLowerCase();
                const roomView = room.getAttribute('data-view').toLowerCase();

                // Check room type
                const typeMatch = roomType === "" || type.includes(roomType);

                // Check price range
                let priceMatch = true;
                if (priceRange !== "") {
                    const [minPrice, maxPrice] = priceRange.split('-').map(Number);
                    priceMatch = price >= minPrice && price <= maxPrice;
                }

                // Check capacity
                const capacityMatch = capacity === "" || roomCapacity.includes(capacity);

                // Check view
                const viewMatch = view === "" || roomView.includes(view);

                // Show/hide room based on filters
                if (typeMatch && priceMatch && capacityMatch && viewMatch) {
                    room.classList.remove('hidden');
                    visibleCount++;
                } else {
                    room.classList.add('hidden');
                }
            });

            // Show no results message if no rooms match
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                if (!noResults) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.id = 'noResults';
                    noResultsDiv.className = 'text-center mt-4';
                    noResultsDiv.innerHTML = '<h4>No rooms match your filters.</h4>';
                    document.getElementById('roomContainer').appendChild(noResultsDiv);
                }
            } else if (noResults) {
                noResults.remove();
            }
        }

        function clearFilters() {
            document.getElementById('roomType').value = "";
            document.getElementById('priceRange').value = "";
            document.getElementById('capacity').value = "";
            document.getElementById('view').value = "";
            applyFilters(); // Reapply filters to show all rooms
        }

        // Apply filters on page load (optional)
        applyFilters();
    </script>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>