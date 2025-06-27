<?php
// db connection
$conn = new mysqli("localhost", "root", "", "ar_hotels");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Stats
$total_rooms = $conn->query("SELECT COUNT(*) AS total FROM rooms")->fetch_assoc()['total'];
$active_bookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$new_reviews = $conn->query("SELECT COUNT(*) AS total FROM reviews WHERE created_at >= CURDATE() - INTERVAL 7 DAY")->fetch_assoc()['total'];
$registered_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

// Recent Bookings
$recent_activity = $conn->query("
    SELECT id, name, created_at FROM bookings 
    ORDER BY created_at DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - AR Hotels</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            flex-shrink: 0;
            min-height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .sidebar a:hover {
            color: #1abc9c;
        }

        .main {
            margin-left: 220px;
            padding: 20px;
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }

        .recent {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .recent h2 {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f0f0f0;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .stats {
                grid-template-columns: 1fr 1fr;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
            }

            tr {
                margin-bottom: 15px;
                padding: 10px;
                background: #fafafa;
                border-radius: 5px;
            }
        }
    </style>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="main">
        <div class="header">
            <h1>Dashboard</h1>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Rooms</h3>
                <p><?= $total_rooms ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <p><?= $active_bookings ?></p>
            </div>
            <div class="stat-card">
                <h3>New Reviews (7 Days)</h3>
                <p><?= $new_reviews ?></p>
            </div>
            <div class="stat-card">
                <h3>Registered Users</h3>
                <p><?= $registered_users ?></p>
            </div>
        </div>

        <div class="recent">
            <h2>Recent Bookings</h2>
            <table>
                <tr>
                    <th>Time</th>
                    <th>Activity</th>
                    <th>User</th>
                </tr>
                <?php while ($row = $recent_activity->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Time"><?= date("d M, H:i", strtotime($row['created_at'])) ?></td>
                        <td data-label="Activity">New booking #<?= $row['id'] ?></td>
                        <td data-label="User"><?= $row['name'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>

</html>