<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$joindate = $_POST['joindate'] ?? '';

// Handle the file upload and assign the photo link to $photoLink variable
$photoLink = '';  // Define and initialize the variable

// Check if a file was uploaded successfully
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'photos/';
    $fileName = uniqid() . '_' . $_FILES['photo']['name'];
    $targetPath = $uploadDir . $fileName;
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        $photoLink = $targetPath;
    } else {
        echo "Error uploading photo.";
        // You can add additional error handling here if needed
    }
}

$sql = "INSERT INTO member (FirstName, LastName, Email, Phone, address, Joindate, photo_link) VALUES ('$firstName', '$lastName', '$email', '$phone', '$address', '$joindate', '$photoLink')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully. Redirecting to the dashboard...";
    // Wait for a moment before redirecting
    header("refresh:2;url=dashboard.html"); // Redirect after 2 seconds
} else {
    echo "Error inserting data: " . $conn->error;
}

$conn->close();
?>
