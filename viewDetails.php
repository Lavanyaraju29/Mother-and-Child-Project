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

// Get unique ID from URL
if (!isset($_GET['unique_id'])) {
    die("Unique ID not provided.");
}

$unique_id = $conn->real_escape_string($_GET['unique_id']);

// Fetch Birth Details
$sql = "SELECT * FROM BirthDetails WHERE unique_id = '$unique_id'";
$result = $conn->query($sql);

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "    <meta charset='UTF-8' />";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0' />";
echo "    <title>View Child Details</title>";
echo "    <style>";
echo "        body {";
echo "            font-family: sans-serif;";
echo "            display: flex;";
echo "            flex-direction: column;";
echo "            align-items: center;";
echo "            justify-content: center;";
echo "            height: auto;";
echo "            margin: 20px;"; // Add margin for spacing
echo "            background: linear-gradient(135deg, #6dd5ed, #2193b0);";
echo "            color: #333;";
echo "        }";
echo "        h2 {";
echo "            text-align: center;";
echo "            color: #fff;";
echo "            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);";
echo "            margin-bottom: 20px;";
echo "        }";
echo "        .details-container {";
echo "            background-color: rgba(255, 255, 255, 0.8);";
echo "            padding: 30px;";
echo "            border-radius: 8px;";
echo "            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);";
echo "            width: 500px;"; // Adjust width as needed
echo "        }";
echo "        .details-container p {";
echo "            margin-bottom: 10px;";
echo "        }";
echo "        hr {";
echo "            border: 1px solid #ddd;";
echo "            margin: 20px 0;";
echo "        }";
echo "        a {";
echo "            color: #007bff;";
echo "            text-decoration: none;";
echo "        }";
echo "        a:hover {";
echo "            text-decoration: underline;";
echo "        }";
echo "    </style>";
echo "</head>";
echo "<body>";
echo "    <div class='details-container'>";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>Child Details</h2>";
    echo "<p>Unique ID: " . $row["unique_id"] . "</p>";
    echo "<p>Child Name: " . $row["child_name"] . "</p>";
    echo "<p>Weight: " . $row["child_weight"] . " kg</p>";
    echo "<p>Hospital Name: " . $row["hospital_name"] . "</p>";
    echo "<p>Location: " . $row["location"] . "</p>";
    echo "<p>Birth Time: " . $row["birth_time"] . "</p>";
    echo "<p>Birth Date: " . $row["birth_date"] . "</p>";
    echo "<p>Parent's Email: " . $row["email"] . "</p><hr>";
} else {
    echo "<p>No birth details found with the given Unique ID.</p><hr>";
}

// Fetch Medical Records
$sql_med = "SELECT * FROM MedicalRecords WHERE unique_id = '$unique_id'";
$result_med = $conn->query($sql_med);

if ($result_med->num_rows > 0) {
    echo "<h2>Medical Records</h2>";
    while ($med = $result_med->fetch_assoc()) {
        echo "<p>Doctor Name: " . $med["doctor_name"] . "</p>";
        echo "<p>Diagnosis: " . $med["diagnosis"] . "</p>";
        echo "<p>Treatment: " . $med["treatment"] . "</p>";
        echo "<p>Prescription: " . $med["prescription"] . "</p>";
        
        // Check and display the uploaded file if available
        if (!empty($med["file_path"])) {
            echo "<p>Medical Report: <a href='" . $med["file_path"] . "' download>Download Report</a></p>";
        } else {
            echo "<p>Medical Report: Not Uploaded</p>";
        }
        echo "<hr>";
    }
} else {
    echo "<p>No medical records found for this Unique ID.</p>";
}

echo "    </div>";
echo "</body>";
echo "</html>";

$conn->close();
?>