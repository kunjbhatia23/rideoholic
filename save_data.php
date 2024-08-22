<?php
// Set up connection parameters
$servername = "localhost"; // Change this to your server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "rideoholic"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$pincode = $_POST['pincode'];
$bike_company = $_POST['bike_company'];
$time_slot = $_POST['time_slot'];
$bike_service = $_POST['bike_service'];

// Validate form data
if (empty($full_name) || empty($email) || empty($phone_number)) {
    echo "<script>alert('Please fill all the required fields.');</script>";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format.');</script>";
} elseif (!preg_match("/^[0-9]{10}$/", $phone_number)) {
    echo "<script>alert('Invalid phone number format.');</script>";
} else {
    // Save data to the database
    $sql = "INSERT INTO BOOKASERVICE (full_name, email, phone_number, pincode, bike_company, time_slot, bike_service) VALUES ('$full_name', '$email', '$phone_number', '$pincode', '$bike_company', '$time_slot', '$bike_service')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var confirmationPopup = document.getElementById('confirmation-popup');
                var popupContent = document.querySelector('.popup-content');
                
                confirmationPopup.classList.add('active');
                popupContent.classList.add('active');
            });
          </script>";
    header("Refresh: 3; URL=index.html"); // Redirect after 3 seconds
    exit();
    } else {
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
    }
}

// Your existing PHP code here...

if ($conn->query($sql) === TRUE) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var confirmationPopup = document.getElementById('confirmation-popup');
                var popupContent = document.querySelector('.popup-content');
                
                confirmationPopup.classList.add('active');
                popupContent.classList.add('active');
            });
          </script>";
    header("Refresh: 1; URL=bookingservice.html"); // Redirect after 3 seconds
    exit();
} else {
    echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
}



$conn->close();
?>
