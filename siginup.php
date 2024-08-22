<?php
session_start();

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection configuration
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "rideoholic"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Register button logic
    if (isset($_POST['register'])) {
        $fullName = $_POST['fullName'];
        $phoneNumber = $_POST['phoneNumber'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate and sanitize input data
        if (empty($fullName) || empty($phoneNumber) || empty($email) || empty($password)) {
            echoAlert("All fields are required. Please fill in all the information.");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echoAlert("Invalid email format. Please enter a valid email address.");
        } elseif (strlen($password) < 8) {
            echoAlert("Password should be at least 8 characters long.");
        } else {
            // Check if the email already exists in the database
            $checkQuery = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($checkQuery);
            if ($result->num_rows > 0) {
                echoAlert("This email address is already registered. Please use a different email.");
            } else {
                // Insert data into the database
                $insertQuery = "INSERT INTO users (full_name, phone_number, email, password) VALUES ('$fullName', '$phoneNumber', '$email', '$password')";
                if ($conn->query($insertQuery) === TRUE) {
                    // Registration successful
                    $_SESSION['userFullName'] = $fullName; // Store user's full name in the session
                    echoScript("Registration successful. You can now log in with your credentials.");
                    redirectToIndex();
                } else {
                    echoAlert("Error: " . $insertQuery . "<br>" . $conn->error);
                }
            }
        }
    }

    // Login button logic
    if (isset($_POST['login'])) {
        $loginEmail = $_POST['loginEmail'];
        $loginPassword = $_POST['loginPassword'];

        // Validate and sanitize input data
        if (empty($loginEmail) || empty($loginPassword)) {
            echoAlert("Both email and password are required for login. Please fill in both fields.");
        } else {
            // Check if the email and password exist in the database
            $checkQuery = "SELECT * FROM users WHERE email='$loginEmail' AND password='$loginPassword'";
            $result = $conn->query($checkQuery);
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['userFullName'] = $user['full_name']; // Store user's full name in the session
                echoScript("Login successful. Welcome back!");
                redirectToIndex();
            } else {
                echoAlert("Invalid email or password. Please try again.");
            }
        }
    }

    $conn->close();
}

// Function to echo alert message
function echoAlert($message) {
    echo "<script>alert('$message');</script>";
}

// Function to echo script
function echoScript($script) {
    echo "<script>$script</script>";
}

// Function to redirect to index.html
function redirectToIndex() {
    echo '<script>window.location.href = "loggingin.html";</script>';
    exit();
}


?>
