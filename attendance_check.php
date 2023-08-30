<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT attendanceDate, COUNT(*) AS count FROM attendance GROUP BY attendanceDate";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Check Attendance</title>
    <!-- Add your stylesheet and other head elements here -->
</head>
<body>
    <h1>Check Attendance</h1>

    <?php
    if ($result === false) {
        echo "Error fetching attendance data: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>Date</th>
                    <th>Attendance Count</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='view_attendance.php?date=" . urlencode($row['attendanceDate']) . "'>" . $row['attendanceDate'] . "</a></td>";
            echo "<td>" . $row['count'] . "</td>";
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo "<p>No attendance data found.</p>";
    }

    $conn->close();
    ?>

    <a href="dashboard.html">Go back to Dashboard</a>
</body>
</html>
