<?php include 'header.php';
include 'user_check_authentication.php';
?>
<script>
    $(document).ready(function() {
        $('#currentPassword').on('blur', function() {
            var curPwd = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'check_current_password.php',
                data: {
                    cpassword: curPwd
                },
                success: function(response) {
                    if (response == 'false') {
                        $('#current_passwordError').text('Incorrect Old Password').show();
                        $('#currentPassword').addClass('is-invalid');
                        $('#currentPassword').removeClass('is-valid');
                        $('#current_passwordError').addClass('text-danger');
                    }
                }
            });
        });
    });
</script>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Change Password</h3>
                    <form action="user_change_password.php" method="POST">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="current_password" data-validation="required">
                            <div class="error" id="current_passwordError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="new_password" data-validation="required strongPassword min max" data-min="8" data-max="25">

                            <div class="error" id="new_passwordError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" data-validation="required confirmPassword" data-password-id="newPassword">
                            <div class="error" id="confirm_passwordError"></div>
                        </div>
                        <button type="submit" class="btn btn-outline-danger w-100 btn-change-password" name="change_pwd_btn">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';

if (isset($_POST['change_pwd_btn'])) {
    $new_password = $_POST['new_password'];
    $email = $_SESSION['user'];
    // Code to update password in the database here

    $update = "UPDATE registration SET password='$new_password' WHERE email='$email'";
    if ($con->query($update)) {
        setcookie('success', 'Password updated successfully', time() + 5);
    } else {
        setcookie('error', 'Error in updating password', time() + 5);
    }
?>
    <script>
        window.location.href = "user_profile.php";
    </script>
<?php
}
