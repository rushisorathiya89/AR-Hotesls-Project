<?php
// db connection
$conn = new mysqli("localhost", "root", "", "ar_hotels");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rooms
$rooms = $conn->query("SELECT * FROM rooms");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Rooms - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            flex-shrink: 0;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .sidebar a:hover {
            color: #3498db;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
            flex-grow: 1;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 5px;
        }

        input,
        textarea {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background: #e74c3c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

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
                border: 1px solid #ccc;
                padding: 10px;
                background: #fff;
            }

            td,
            th {
                padding: 5px;
                text-align: left;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
            }

            td img {
                width: 100%;
                height: auto;
            }
        }
    </style>

</head>


<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="main-content">
        <h1>Manage Rooms</h1>

        <h2>Add New Room</h2>
        <form action="add_room.php" method="POST" enctype="multipart/form-data">

            <input type="text" name="type" placeholder="Room Type (e.g., Deluxe Room)" required>
            <input type="number" step="0.01" name="price" placeholder="Price per night" required>
            <input type="number" step="0.01" name="discount_price" placeholder="Discounted Price (optional)"><br>
            <br>
            Add Rooms image :<input type="file" name="image" accept="image/*" required>

            <textarea name="description" placeholder="Room Description" required></textarea>
            <input type="text" name="size" placeholder="Size (e.g., 400 sq ft)" required>
            <input type="text" name="capacity" placeholder="Capacity (e.g., 2 Adults + 1 Child)" required>
            <input type="text" name="amenities" placeholder="Amenities (comma separated)" required>
            <input type="text" name="view" placeholder="View (e.g., City view)" required>
            <select name="is_discounted" required>
                <option value="0">No Discount</option>
                <option value="1">Discounted</option>
            </select>
            <button type="submit" class="btn">Add Room</button>
        </form>


        <h2>Existing Rooms</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php while ($room = $rooms->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID"><?= $room['id'] ?></td>
                    <td data-label="Title"><?= $room['type'] ?></td>
                    <td data-label="Price">₹<?= $room['price'] ?></td>
                    <td data-label="Description"><?= $room['description'] ?></td>
                    <td data-label="Image"><img src="images/<?= $room['image'] ?>" alt="Room Image"></td>
                    <td data-label="Action">
                        <form method="POST" action="delete_room.php" onsubmit="return confirm('Delete this room?');">
                            <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>



</html>