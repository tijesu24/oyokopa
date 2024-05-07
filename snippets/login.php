<?php
include_once('connection.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the submitted username and password match 'admin'
    if ($username === 'admin' && $password === 'admin') {
        // Authentication successful
        header('location: ../home.php');
        exit();
    } else {
        header('location: ../loginerror.php');
        exit();
    }
} else {
    header('location: ../loginerror.php');
    exit();
}
?>
