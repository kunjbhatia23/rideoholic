<?php
// Set your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rideoholic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['bike_company'])) {
    $bikeCompany = $_GET['bike_company'];

    // Prevent SQL injection by using prepared statements
    $sql = "SELECT id, name FROM dealers WHERE bike_company_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bikeCompany);
    $stmt->execute();
    $result = $stmt->get_result();

    $dealers = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dealers[] = $row;
        }
    }

    echo json_encode($dealers);
}

$conn->close();
?>
