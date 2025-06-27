<?php
include 'Header.php';

if (!isset($_SESSION['userEmail'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['userEmail'];
$error = "";

if (isset($_POST['change_password_btn'])) {
    $current_password = $_POST['current_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $q = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($q);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if ($current_password === $row['password']) {
            if ($new_password === $confirm_password) {
                $update = "UPDATE users SET password='$new_password' WHERE email='$email'";
                if ($conn->query($update)) {
                    setcookie("success", "Password changed successfully!", time() + 5, "/");
                    header("Location: user_profile.php");
                    exit;
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            } else {
                $error = "New password and confirmation do not match.";
            }
        } else {
            $error = "Current password is incorrect.";
        }
    } else {
        $error = "User not found.";
    }
}
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>


<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4">Change Password</h3>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form id="changePasswordForm" method="POST" action="">
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="change_password_btn" class="btn btn-outline-danger">Change Password</button>
                <a href="user_profile.php" class="btn btn-secondary">Back to Profile</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#changePasswordForm").validate({
            rules: {
                current_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: 6,
                    notEqualTo: "#current_password"
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter your current password",
                    minlength: "Password must be at least 6 characters long"
                },
                new_password: {
                    required: "Please enter a new password",
                    minlength: "Password must be at least 6 characters long",
                    notEqualTo: "New password must be different from current password"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    minlength: "Password must be at least 6 characters long",
                    equalTo: "Passwords do not match"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass("is-invalid").addClass("is-valid");
            },
            submitHandler: function(form) {
                // This will be called when the form is valid
                form.submit();
            }
        });

        // Add custom method to check if new password is different from current
        $.validator.addMethod("notEqualTo", function(value, element, param) {
            return this.optional(element) || value !== $(param).val();
        }, "New password must be different from current password");
    });
</script>

<?php include 'footer.php'; ?>