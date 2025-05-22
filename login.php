<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'HospitalManagementSystem');
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo "<script>alert('Login successful!'); window.location.href='customer.html';</script>";
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='index.html';</script>";
    }
}

mysqli_close($conn);
?>
