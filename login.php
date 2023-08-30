<?php
// login.php

// Define the expected admin username and password
$expectedUsername = 'Sagar';
$expectedPassword = '12345678';

// Retrieve the submitted username and password
$submittedUsername = $_POST['username'] ?? '';
$submittedPassword = $_POST['password'] ?? '';

// Check if the submitted username and password match the expected values
if ($submittedUsername === $expectedUsername && $submittedPassword === $expectedPassword) {
    // Password matches, redirect to the dashboard
    header('Location: dashboard.html');
    exit(); // Terminate the script
} else {
    // Password doesn't match, redirect back to the login page with an error message
    header('Location: adminlogin.html?error=1');
    exit(); // Terminate the script
}
?>
