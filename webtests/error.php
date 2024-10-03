<?php
session_start();

// Check if an error parameter is set in the URL
if (isset($_GET['error'])) {
    $errorType = $_GET['error'];

    // Check if the error is "username_not_found"
    if ($errorType === "username_not_found") {
        // Log the IP, date, and time
        logError("username_not_found");
        logIP();
        // Check if the error has occurred three times
        if (checkErrorCount("username_not_found", 3)) {
            blockIP($_SERVER['REMOTE_ADDR']);
            // Send a notification email
            sendNotification("zxwar1111@gmail.com", "IP Blocked - Multiple Login Failures", "The IP address ".$_SERVER['REMOTE_ADDR']." has been blocked due to multiple login failures.");// For example, block the IP or send a notification
        }
    }
}

// Function to log errors
function logError($errorType) {
    $logFile = "error_log.txt"; // Define the log file name
    $ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $date = date("Y-m-d"); // Get the current date
    $time = date("H:i:s"); // Get the current time

    // Check if the log file exists, create it if not
    if (!file_exists($logFile)) {
        file_put_contents($logFile, "IP\tDate\tTime\tError Type\n");
    }

    // Log the IP, date, and time along with the error type
    file_put_contents($logFile, "$ip\t$date\t$time\t$errorType\n", FILE_APPEND);
}
// Function to log IP addresses
function logIP() {
    $ipLog = "logfile.html"; // Your log file name here (.txt or .html extensions are OK)

    // IP logging function
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("l dS of F Y h:i:s A");
    $log = fopen($ipLog, "a+");

    if (preg_match("/\\bhtm\\b/i", $ipLog) || preg_match("/\\bhtml\\b/i", $ipLog)) {
        fputs($log, "Logged IP address: $ip - Date logged: $date<br>");
    } else {
        fputs($log, "Logged IP address: $ip - Date logged: $date\n");
    }

    fclose($log);
}
function sendNotification($to, $subject, $message) {
    // Use PHP's mail function or a third-party library to send the email notification
    mail($to, $subject, $message);
}
// Function to check the error count
function checkErrorCount($errorType, $countThreshold) {
    $logFile = "error_log.txt"; // Define the log file name

    // Check if the log file exists
    if (file_exists($logFile)) {
        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Count the occurrences of the specified error type
        $errorCount = 0;
        foreach ($lines as $line) {
            if (strpos($line, $errorType) !== false) {
                $errorCount++;
            }
        }

        // Return true if the error count exceeds the threshold
        return $errorCount >= $countThreshold;
    }

    return false; // Return false if the log file doesn't exist or there are no errors
}


?>