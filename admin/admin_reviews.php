<?php
$conn = new mysqli("localhost", "root", "", "ar_hotels");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete Review
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM reviews WHERE id = $id");
    echo "<script>alert('Review deleted successfully!'); window.location.href='admin_reviews.php';</script>";
}

// Add Review
if (isset($_POST['add_review'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $created_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO reviews (name, email, rating, review, created_at)
            VALUES ('$name', '$email', '$rating', '$review', '$created_at')";

    if ($conn->query($sql)) {
        echo "<script>alert('Review added successfully!'); window.location.href='admin_reviews.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Reviews</title>
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
        textarea {
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
        <h1>Manage Reviews</h1>

        <h2>All Reviews</h2>
        <table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1;
                while ($row = $reviews->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Sr. No"><?= $sn++ ?></td>
                        <td data-label="Name"><?= $row['name'] ?></td>
                        <td data-label="Email"><?= $row['email'] ?></td>
                        <td data-label="Rating"><?= $row['rating'] ?></td>
                        <td data-label="Review"><?= $row['review'] ?></td>
                        <td data-label="Created"><?= $row['created_at'] ?></td>
                        <td data-label="Action">
                            <a href="admin_reviews.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this review?');" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Add New Review</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="email" name="email" placeholder="Customer Email" required>
            <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
            <textarea name="review" placeholder="Write the review..." required></textarea>
            <button type="submit" name="add_review" class="btn">Add Review</button>
        </form>
    </div>

</body>

</html>