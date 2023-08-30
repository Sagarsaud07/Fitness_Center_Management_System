<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addMembers'])) {
    if (isset($_POST['selectedMembers']) && is_array($_POST['selectedMembers'])) {
        $selectedMembers = $_POST['selectedMembers'];

        foreach ($selectedMembers as $memberID) {
            $insertQuery = "INSERT INTO morning_shift (MemberID) VALUES ('$memberID')";
            $conn->query($insertQuery);
        }

        echo "Members added to morning shift successfully.";
    } else {
        echo "No members selected to add.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Members to Morning Shift</title>
    <!-- Add your stylesheet and other head elements here -->
</head>
<body>
    <h1>Add Members to Morning Shift</h1>

    <?php
    $sql = "SELECT * FROM member";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error fetching member data: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo '<form action="add_members_to_morning_shift.php" method="post">';
        echo '<table>
                <tr>
                    <th>Select</th>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='selectedMembers[]' value='" . $row['MemberID'] . "'></td>";
            echo "<td>" . $row['MemberID'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "</tr>";
        }

        echo '</table>';
        echo '<input type="submit" name="addMembers" value="Add Members">';
        echo '</form>';
    } else {
        echo "<p>No member data found.</p>";
    }

    $conn->close();
    ?>

    <a href="morning_shift_members.php">View Members in Morning Shift</a>
    <a href="attendance_check.php">Check Attendance</a>
    <a href="dashboard.html">Go back to Dashboard</a>
</body>
</html>
