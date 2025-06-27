<?php
// Step 1: Connect to the database
$conn = new mysqli("localhost", "root", "", "ar_hotels");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Get all form data
$type = $_POST['type'];
$price = $_POST['price'];
$discount_price = $_POST['discount_price'];
$description = $_POST['description'];
$size = $_POST['size'];
$capacity = $_POST['capacity'];
$amenities = $_POST['amenities'];
$view = $_POST['view'];
$is_discounted = $_POST['is_discounted'];

// Step 3: Handle image upload
$image = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

// Move image to 'images' folder
move_uploaded_file($tmp_name, "images/" . $image);

// Step 4: Insert data into rooms table
$sql = "INSERT INTO rooms (type, price, discount_price, image, description, size, capacity, amenities, view, is_discounted)
        VALUES ('$type', '$price', '$discount_price', '$image', '$description', '$size', '$capacity', '$amenities', '$view', '$is_discounted')";

// Step 5: Run the query and give feedback
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Room added successfully!'); window.location.href='admin_pannel.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
