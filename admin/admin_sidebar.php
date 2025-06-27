<!-- admin_sidebar.php -->
<style>
    .sidebar {
        width: 220px;
        height: 100vh;
        background-color: #2c3e50;
        color: #ecf0f1;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
        box-sizing: border-box;
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
        transition: 0.2s;
    }

    .sidebar a:hover {
        color: #3498db;
    }

    .main-content {
        margin-left: 240px;
        padding: 20px;
    }
</style>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_pannel.php">Dashboard</a>
    <a href="admin_rooms.php">Rooms</a>
    <a href="admin_bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="admin_reviews.php">Reviews</a>
    <a href="admin_logout.php">Logout</a>
</div>