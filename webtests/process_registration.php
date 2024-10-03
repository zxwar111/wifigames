<?php
// Start a PHP session
session_start();

// Connect to the SQLite database
$db = new SQLite3('webdata.db');

// Get user input from the registration form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the username is already taken
$checkQuery = "SELECT * FROM users WHERE username = :username";
$stmt = $db->prepare($checkQuery);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result->fetchArray()) {
    // Username is already taken, redirect with an error message
    header("Location: registration.html?error=username_taken");
    exit;
}

// Hash the user's password (replace 'your_hashing_function' with an actual hashing method)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database
$insertQuery = "INSERT INTO users (username, password) VALUES (:username, :password)";
$stmt = $db->prepare($insertQuery);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
$stmt->execute();

// Redirect to a registration success page or login page
header("Location: login.html?registration_success=true");
exit;
?>
