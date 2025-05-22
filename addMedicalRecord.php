<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HospitalManagementSystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the 'uploads' directory exists
$uploadDir = "uploads/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = $conn->real_escape_string($_POST['unique_id']);
    $doctor_name = $conn->real_escape_string($_POST['doctor_name']);
    $diagnosis = $conn->real_escape_string($_POST['diagnosis']);
    $treatment = $conn->real_escape_string($_POST['treatment']);
    $prescription = $conn->real_escape_string($_POST['prescription']);
    $file_path = NULL; // Default if no file is uploaded

    // Handle file upload if provided
    if (!empty($_FILES['medical_file']['name'])) {
        $file_name = basename($_FILES["medical_file"]["name"]);
        $file_path = $uploadDir . $unique_id . "_" . $file_name;

        // Check file extension
        $fileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        if (!in_array($fileType, ["pdf", "doc", "docx"])) {
            die("Invalid file format. Only PDF, DOC, and DOCX are allowed.");
        }

        // Move the uploaded file
        if (!move_uploaded_file($_FILES["medical_file"]["tmp_name"], $file_path)) {
            die("File upload failed.");
        }
    }

    // Insert data into database
    $sql = "INSERT INTO MedicalRecords (unique_id, doctor_name, diagnosis, treatment, prescription, file_path)
                  VALUES ('$unique_id', '$doctor_name', '$diagnosis', '$treatment', '$prescription', '$file_path')";

    if ($conn->query($sql) === TRUE) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "    <meta charset='UTF-8'>";
        echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "    <title>Medical Record Added</title>";
        echo "    <style>";
        echo "        body {";
        echo "            font-family: sans-serif;";
        echo "            display: flex;";
        echo "            flex-direction: column;";
        echo "            align-items: center;";
        echo "            justify-content: center;";
        echo "            height: 100vh;";
        echo "            margin: 0;";
        echo "            background: linear-gradient(135deg, #6dd5ed, #2193b0);";
        echo "            color: #333;";
        echo "        }";
        echo "        .message-box {";
        echo "            background-color: rgba(255, 255, 255, 0.8);";
        echo "            padding: 30px;";
        echo "            border-radius: 8px;";
        echo "            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);";
        echo "            text-align: center;";
        echo "        }";
        echo "        a {";
        echo "            display: inline-block;";
        echo "            margin-top: 20px;";
        echo "            background-color: #007bff;";
        echo "            color: white;";
        echo "            padding: 12px 20px;";
        echo "            border: none;";
        echo "            border-radius: 4px;";
        echo "            text-decoration: none;";
        echo "        }";
        echo "        a:hover {";
        echo "            background-color: #0056b3;";
        echo "        }";
        echo "    </style>";
        echo "</head>";
        echo "<body>";
        echo "    <div class='message-box'>";
        echo "        <p>Medical record added successfully.</p>";
        echo "        <a href='viewDetails.php?unique_id=" . $unique_id . "'>View All Details</a>";
        echo "    </div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "    <meta charset='UTF-8'>";
        echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "    <title>Error</title>";
        echo "    <style>";
        echo "        body {";
        echo "            font-family: sans-serif;";
        echo "            display: flex;";
        echo "            align-items: center;";
        echo "            justify-content: center;";
        echo "            height: 100vh;";
        echo "            margin: 0;";
        echo "            background: linear-gradient(135deg, #6dd5ed, #2193b0);";
        echo "            color: #333;";
        echo "        }";
        echo "        .error-message {";
        echo "            background-color: rgba(255, 255, 255, 0.8);";
        echo "            padding: 20px;";
        echo "            border-radius: 8px;";
        echo "            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);";
        echo "            text-align: center;";
        echo "        }";
        echo "    </style>";
        echo "</head>";
        echo "<body>";
        echo "    <div class='error-message'>";
        echo "        <p>Error: " . $conn->error . "</p>";
        echo "    </div>";
        echo "</body>";
        echo "</html>";
    }
}

$conn->close();
?>