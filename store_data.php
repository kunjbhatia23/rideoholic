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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $pincode = $_POST['pincode'];
    $bikeCompany = $_POST['bike_company'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO test_rides (full_name, email, phone_number, pincode, bike_company) 
            VALUES ('$fullName', '$email', '$phoneNumber', '$pincode', '$bikeCompany')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
        // Redirect to index.html after successful record insertion
        header("Location: bookingtestride.html");
        exit(); // Ensure that no further PHP code is executed after the redirect
    } else {
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
    }
}

$conn->close();
?>
