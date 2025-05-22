<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Static username and password check
    if ($username === 'hospital' && $password === '123456') {
        header("Location: hospital.html");
        exit();
    } else {
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href = 'hospital_login.html';</script>";
    }
}
?>
