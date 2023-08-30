<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update membership duration and expiry date
$updateQuery = "UPDATE morning_shift SET MembershipDurationDays = MembershipDurationDays - 1, MembershipExpiryDate = DATE_ADD(MembershipExpiryDate, INTERVAL -1 DAY) WHERE MembershipStatus = 'Active'";
$conn->query($updateQuery);

// Update membership status to "Expired" for members whose expiry date is in the past
$expireQuery = "UPDATE morning_shift SET MembershipStatus = 'Expired' WHERE MembershipExpiryDate < CURDATE() AND MembershipStatus = 'Active'";
$conn->query($expireQuery);
?>
