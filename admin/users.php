<?php
$conn = new mysqli("localhost", "root", "", "ar_hotels");

// Delete user
if (isset($_POST['delete'])) {
    $conn->query("DELETE FROM users WHERE id = " . $_POST['id']);
}

// Add new user
if (isset($_POST['add'])) {
    $conn->query("INSERT INTO users (name, email, password, role, email_verified, verification_token, created_at, mobile_no, profile_picture)
        VALUES (
            '{$_POST['name']}',
            '{$_POST['email']}',
            '{$_POST['password']}',
            '{$_POST['role']}',
            0,
            0,
            NOW(),
            '{$_POST['mobile_no']}',
            NULL
        )");
}

$users = $conn->query("SELECT * FROM users WHERE role != 'admin' ORDER BY created_at DESC");

?>

<?php include 'admin_sidebar.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Users</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            background: #f9f9f9;
        }

        .main {
            padding: 20px;
            margin-left: 220px;
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
        }

        th {
            background: #eee;
        }

        form {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
        }

        input,
        select {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
        }

        button {
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        .delete-btn {
            background: #e74c3c;
        }

        @media (max-width: 768px) {
            .main {
                margin: 0;
                padding: 10px;
            }

            table,
            tr,
            td,
            th {
                display: block;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                background: #fff;
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
        }
    </style>
</head>

<body>

    <div class="main">
        <h2>Registered Users</h2>
        <table>
            <tr>
                <th>Sr</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Role</th>
                <th>Profile</th>
                <th>Delete</th>
            </tr>
            <?php $sn = 1;
            while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td data-label="Sr"><?= $sn++ ?></td>
                    <td data-label="Name"><?= $row['name'] ?></td>
                    <td data-label="Email"><?= $row['email'] ?></td>
                    <td data-label="Mobile"><?= $row['mobile_no'] ?></td>
                    <td data-label="Role"><?= ucfirst($row['role']) ?></td>
                    <td data-label="Profile">
                        <?php if ($row['profile_picture']): ?>
                            <img src="images/<?= $row['profile_picture'] ?>" width="40" height="40" style="border-radius: 50%;">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button class="delete-btn" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h3>Add New User</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="password" placeholder="Password" required>
            <input type="text" name="mobile_no" placeholder="Mobile Number" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button name="add">Add User</button>
        </form>
    </div>

</body>

</html>