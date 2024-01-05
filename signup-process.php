-- Active: 1704271055055@@127.0.0.1@3306@sign-up
<?php

$servername = "localhost";  
$username = "root";       
$password = "";             
$dbname = "sign-up";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);
    $password_confirmation = sanitize_input($_POST["passwordconfirmation"]);

    // Validate password and confirmation
    if ($password !== $password_confirmation) {
        echo "Passwords do not match. Please try again.";
        exit();
    }

    // Hash the password before storing in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Sign up successful! You can now <a href='signin.html'>sign in</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
