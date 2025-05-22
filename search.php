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

// Fetch data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = $conn->real_escape_string($_POST['unique_id']);
    
    // Query to fetch birth details
    $sql = "SELECT * FROM BirthDetails WHERE unique_id = '$unique_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "    <meta charset='UTF-8'>";
        echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "    <title>Child Details</title>";
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
        echo "        h2 {";
        echo "            text-align: center;";
        echo "            color: #fff;";
        echo "            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);";
        echo "        }";
        echo "        .details-container {";
        echo "            background-color: rgba(255, 255, 255, 0.8);";
        echo "            padding: 30px;";
        echo "            border-radius: 8px;";
        echo "            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);";
        echo "            width: 300px;";
        echo "        }";
        echo "        .details-container p {";
        echo "            margin-bottom: 10px;";
        echo "        }";
        echo "        .details-container a {";
        echo "            display: block;";
        echo "            margin-top: 20px;";
        echo "            background-color: #007bff;";
        echo "            color: white;";
        echo "            padding: 10px 15px;";
        echo "            text-align: center;";
        echo "            border-radius: 4px;";
        echo "            text-decoration: none;";
        echo "        }";
        echo "        .details-container a:hover {";
        echo "            background-color: #0056b3;";
        echo "        }";
        echo "    </style>";
        echo "</head>";
        echo "<body>";
        echo "    <h2>Child Details</h2>";
        echo "    <div class='details-container'>";
        echo "        <p>Unique ID: " . $row["unique_id"] . "</p>";
        echo "        <p>Child Name: " . $row["child_name"] . "</p>";
        echo "        <p>Weight: " . $row["child_weight"] . " kg</p>";
        echo "        <p>Hospital Name: " . $row["hospital_name"] . "</p>";
        echo "        <p>Location: " . $row["location"] . "</p>";
        echo "        <p>Birth Time: " . $row["birth_time"] . "</p>";
        echo "        <p>Birth Date: " . $row["birth_date"] . "</p>";
        echo "        <p>Parent's Email: " . $row["email"] . "</p>";
        echo "        <a href='addMedicalRecord.html?unique_id=" . $row["unique_id"] . "'>Add Medical Record</a>";
        echo "    </div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "    <meta charset='UTF-8'>";
        echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "    <title>No Record Found</title>";
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
        echo "        p {";
        echo "            background-color: rgba(255, 255, 255, 0.8);";
        echo "            padding: 20px;";
        echo "            border-radius: 8px;";
        echo "            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);";
        echo "            text-align: center;";
        echo "        }";
        echo "    </style>";
        echo "</head>";
        echo "<body>";
        echo "    <p>No record found with the given Unique ID.</p>";
        echo "</body>";
        echo "</html>";
    }
}

$conn->close();
?>