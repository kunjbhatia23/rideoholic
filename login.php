<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation checks
    $full_name = test_input($_POST['full_name']);
    $phone_number = test_input($_POST['phone_number']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    // Basic input sanitization function
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check if the full name contains only letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/", $full_name)) {
        echo "Only letters and white space allowed in the full name";
    }
    // Check if the email format is valid
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    }
    // Check if the phone number contains only numbers
    elseif (!ctype_digit($phone_number)) {
        echo "Only numeric values allowed in the phone number";
    } else {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "localhost123";
        $dbname = "rideoholic";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the email already exists
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            echo "This email already exists. Please use a different email.";
        } else {
            // Insert data into the database
            $insert_query = "INSERT INTO users (full_name, phone_number, email, password)
            VALUES ('$full_name', '$phone_number', '$email', '$password')";

            if ($conn->query($insert_query) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $insert_query . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
}
?>
