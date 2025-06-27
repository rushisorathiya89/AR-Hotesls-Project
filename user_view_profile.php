<?php
include 'Header.php';

if (!isset($_SESSION['userEmail'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['userEmail'];


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
        .text-end {
            text-align: center !important;
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
                            alt="Profile Picture" class="profile-image mb-3 shadow"
                            width="150" height="150">
                        <h2 class="mb-1"><?php echo $row['name']; ?></h2>
                        <p class="text-muted"><?php echo $row['email']; ?></p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="<?php echo $row['name']; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?php echo $row['email']; ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" value="<?php echo $row['mobile_no']; ?>" readonly>
                    </div>

                    <div class="text-end">
                        <a href="user_profile.php" class="btn btn-outline-primary">Edit Profile</a>
                        <a href="change_password.php" class="btn btn-outline-primary me-md-2">Change Password</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>