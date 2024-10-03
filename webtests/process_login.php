<?php
// Start a PHP session
session_start();

// Connect to the SQLite database
$db = new SQLite3('webdata.db'); // Replace with your SQLite database file path

// Get user input from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Query the database to retrieve user information
$query = "SELECT * FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();

// Check if a user with the given username exists
$userData = $result->fetchArray(SQLITE3_ASSOC);

if (!$userData) {
    // Username does not exist, redirect with an error message
    header("Location: login.html?error=username_not_found");
    exit;
}

// Verify the password (replace 'your_hashing_function' with your actual hashing method)
if (!password_verify($password, $userData['password'])) {
    // Password is incorrect, redirect with an error message
    header("Location: login.html?error=incorrect_password");
    exit;
}

// Authentication successful, set user ID in session
$_SESSION['user_id'] = $userData['id'];

// Redirect to the dashboard or a success page
header("Location: dashboard.html");
exit;
?>