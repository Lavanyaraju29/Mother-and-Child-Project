<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "HospitalManagementSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $child_name = $_POST['child_name'];
    $child_weight = $_POST['child_weight'];
    $hospital_name = $_POST['hospital_name'];
    $location = $_POST['location'];
    $birth_time = $_POST['birth_time'];
    $birth_date = $_POST['birth_date'];
    $email = $_POST['email'];

    // Generate a unique ID (Example: BD-123456)
    $unique_id = "BD-" . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    // Insert into database
    $sql = "INSERT INTO BirthDetails (unique_id, child_name, child_weight, hospital_name, location, birth_time, birth_date, email)
            VALUES ('$unique_id', '$child_name', '$child_weight', '$hospital_name', '$location', '$birth_time', '$birth_date', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Birth Details Registered! Unique ID: $unique_id'); window.location.href='hospital.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
