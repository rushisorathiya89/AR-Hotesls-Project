<?php
include_once('header.php');
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    $sql = "SELECT * FROM users WHERE email = '$email' AND verification_token = '$token'";
    $count = $conn->query($sql);
    $r = mysqli_fetch_assoc($count);
    if ($count->num_rows == 1) {
        if ($r['email_verified'] == 0) {
            $update = "UPDATE users SET email_verified = 1 WHERE email = '$email'";
            if ($conn->query($update)) {
                $_SESSION['userLogin'] = true;
                $_SESSION['userId'] = $r['id'];
                $_SESSION['userEmail'] = $r['email'];
                setcookie('success', 'Account Verification Successful', time() + 5);
            } else {
                setcookie('error', 'Error in verifying email', time() + 5);
            }
        } else {
            setcookie('success', 'Email already verified', time() + 5);
        }
    }
} else {
    setcookie('error', 'Email not registered', time() + 5);
}
?>
<script>
    window.location.href = 'index.php';
</script>