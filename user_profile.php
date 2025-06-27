<?php
include 'Header.php';

if (!isset($_SESSION['userEmail'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['userEmail'];

if (isset($_POST['update_btn'])) {
    $fullName = $_POST['fullname'];
    $mobile = $_POST['mobile'];

    $q = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($q);
    $row = mysqli_fetch_assoc($result);

    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
        $profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $targetDir = "images/profile_picture/";
        $targetFilePath = $targetDir . $profile_picture;

        $oldPic = $row['profile_picture'];

        if (move_uploaded_file($profile_picture_tmp_name, $targetFilePath)) {
            if (!empty($oldPic) && file_exists($targetDir . $oldPic) && $oldPic !== "default.png") {
                unlink($targetDir . $oldPic);
            }
            $update = "UPDATE users SET name='$fullName', mobile_no='$mobile', profile_picture='$profile_picture' WHERE email='$email'";
        } else {
            setcookie("error", "Failed to upload profile picture!", time() + 5, "/");
            header("Location: user_profile.php");
            exit;
        }
    } else {
        $update = "UPDATE users SET name='$fullName', mobile_no='$mobile' WHERE email='$email'";
    }

    if ($conn->query($update)) {
        setcookie("success", "Profile updated successfully!", time() + 5, "/");
    } else {
        setcookie("error", "Error updating profile!", time() + 5, "/");
    }
    header("Location: user_profile.php");
    exit;
}


$q = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($q);
$row = mysqli_fetch_assoc($result);
?>

<style>
    .profile-image {
        object-fit: cover;
        border-radius: 50%;
    }

    .profile-card {
        border-radius: 15px;
    }

    @media (max-width: 576px) {
        .d-md-flex {
            flex-direction: column !important;
        }

        .d-md-flex .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card profile-card shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="images/profile_picture/<?php echo (!empty($row['profile_picture']) ? $row['profile_picture'] : 'default.png'); ?>"
                            alt="Profile Picture" class="profile-image shadow mb-3" width="150" height="150">
                        <h2 class="mb-1"><?php echo $row['name']; ?></h2>
                        <p class="text-muted"><?php echo $row['email']; ?></p>
                    </div>

                    <?php if (isset($_COOKIE['success'])) { ?>
                        <div class="alert alert-success"><?php echo $_COOKIE['success']; ?></div>
                    <?php } ?>
                    <?php if (isset($_COOKIE['error'])) { ?>
                        <div class="alert alert-danger"><?php echo $_COOKIE['error']; ?></div>
                    <?php } ?>

                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullname" value="<?php echo $row['name']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email (Read-Only)</label>
                                <input type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile_no']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="change_password.php" class="btn btn-outline-primary me-md-2">Change Password</a>
                            <button type="button" class="btn btn-outline-secondary me-md-2" onclick="window.location.href='user_view_profile.php';">Cancel</button>
                            <button type="submit" class="btn btn-outline-success" name="update_btn" onclick="window.location.href='user_view_profile.php';">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>