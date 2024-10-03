<?php
// Make sure this script is accessed via POST method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}

session_start(); // Start the PHP session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to the login page if not logged in
    exit;
}

// Extract the user ID from the session
$user_id = $_SESSION['user_id'];

// Validate and sanitize input data
$target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_STRING);
$location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_STRING);
$objectives = filter_input(INPUT_POST, "objectives", FILTER_SANITIZE_STRING);
$reward = filter_input(INPUT_POST, "reward", FILTER_VALIDATE_FLOAT); // Updated for decimal rewards
$level = filter_input(INPUT_POST, "level", FILTER_SANITIZE_STRING);
$deadline = filter_input(INPUT_POST, "deadline", FILTER_SANITIZE_STRING);
$contractType = filter_input(INPUT_POST, "contract-type", FILTER_SANITIZE_STRING);
$contractStatus = filter_input(INPUT_POST, "contract-status", FILTER_SANITIZE_STRING);

// Ensure required fields are not empty
if (empty($target) || empty($location) || $reward === false) {
    header("Location: create_contract.html?error=missing_fields");
    exit;
}

// Additional validation for specific fields (e.g., level, deadline)
if ($reward < 0 || !in_array($contractStatus, ["open", "closed"])) {
    header("Location: create_contract.html?error=invalid_data");
    exit;
}

// JSON-encode the contract data, including the user ID
$contractData = [
    "user_id" => $user_id, // Add the user's unique identifier
    "target" => $target,
    "location" => $location,
    "objectives" => $objectives,
    "reward" => $reward,
    "level" => $level,
    "deadline" => $deadline,
    "contract-type" => $contractType,
    "contract-status" => $contractStatus,
];

// Generate a unique filename for the contract
$filename = "contracts/contract_" . uniqid() . ".json";

// Save the contract data to the file
if (file_put_contents($filename, json_encode($contractData)) === false) {
    header("Location: create_contract.html?error=file_write_error");
    exit;
}

// Redirect to a success page
header("Location: create_contract.html?success=true");
exit;
?>


