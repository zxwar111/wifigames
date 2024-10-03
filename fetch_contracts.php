<?php
// Set the response content type to JSON
header('Content-Type: application/json');

// Define the directory where contract files are stored
$contractDirectory = 'contracts/';

// Initialize an array to store contract data
$contracts = [];

// Open and read each contract JSON file in the directory
$files = scandir($contractDirectory);
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
        $contractData = file_get_contents($contractDirectory . $file);
        $contracts[] = json_decode($contractData, true); // true for associative arrays
    }
}

// Send the JSON response
echo json_encode($contracts);
