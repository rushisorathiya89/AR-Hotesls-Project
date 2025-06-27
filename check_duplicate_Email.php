<?php
include_once 'db_connect.php';

if (isset($_GET['email1'])) {
    $email = $_GET['email1'];
    $q = "SELECT * FROM `register` WHERE `email`='$email'";
    $result = $con->query($q);
    if ($result->num_rows > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
}
