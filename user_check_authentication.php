<?php
$url = $_SERVER['REQUEST_URI'];
$parsed_url = parse_url($url);
$url1 = $parsed_url['path'];
$parts = explode("/", $url1);
$_SESSION['url'] = $parts[2];
if (!isset($_SESSION['user'])) {
?>
    <script>
        window.location.href = "login.php";
    </script>
<?php
}
