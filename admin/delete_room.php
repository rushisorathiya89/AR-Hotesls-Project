<?php
$conn = new mysqli("localhost", "root", "", "ar_hotels");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room_id = $_POST['room_id'];
$conn->query("DELETE FROM rooms WHERE id = $room_id");

header("Location: admin_rooms.php");
