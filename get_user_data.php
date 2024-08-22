<?php
$servername = "localhost";
$username = "root";
$password = " ";
$dbname = "rideoholic";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE email IN (SELECT email FROM test_rides) ORDER BY timestamp_column DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    echo json_encode($userData);
    echo "Test ride is booked";
} else {
    echo json_encode(array());
}

$sql2 = "SELECT * FROM users WHERE email IN (SELECT email FROM bookaservice) ORDER BY timestamp_column DESC";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    $userData2 = $result2->fetch_assoc();
    echo json_encode($userData2);
    echo "Service is booked";
} else {
    echo json_encode(array());
}

$sql3 = "SELECT *, (SELECT fullname FROM users WHERE users.email = bookaservice.email) AS fullname FROM users ORDER BY timestamp_column DESC";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) {
    $userData3 = $result3->fetch_assoc();
    echo json_encode($userData3);
    echo $row['fullname'];
} else {
    echo json_encode(array());
}
$conn->close();
