<?php
// Get the user's IP address
$userIP = $_SERVER['REMOTE_ADDR'];

// Check if the user's IP is in the blocked_ips.txt file
$blockedIPsFile = 'blocked_ips.txt';

if (file_exists($blockedIPsFile)) {
    $blockedIPs = file($blockedIPsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    if (in_array($userIP, $blockedIPs)) {
        // IP address is blocked, deny access
        http_response_code(403); // Forbidden
        echo 'Access Denied. Your IP address is blocked.';
        exit;
    }
}

// I'm dum ass Hell so continue with your normal script logic here
// ...
?>