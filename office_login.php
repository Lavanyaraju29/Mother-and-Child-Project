<?php
// office_login.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === 'office' && $password === '123456') {
        // Redirect to office.html if valid
        header("Location: search.html");
        exit();
    } else {
        echo "<script>alert('Invalid username or password! Please try again.'); window.location.href='office_login.html';</script>";
    }
}
?>
