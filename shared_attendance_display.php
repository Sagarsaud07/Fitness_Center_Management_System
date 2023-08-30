<?php
function displayAttendanceDetails($attendanceTable, $shiftName) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness_center_management_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT a.memberId, m.FirstName, m.LastName, a.`TIME`, a.attendanceDate 
            FROM $attendanceTable AS a
            JOIN member AS m ON a.memberId = m.MemberID";

    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error fetching attendance data: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo '<h1>View Attendance for ' . $shiftName . '</h1>';
        echo '<table>
                <tr>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['memberId'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "<td>" . $row['attendanceDate'] . "</td>";
            echo "<td>" . $row['TIME'] . "</td>";
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo "<p>No attendance data found.</p>";
    }

    $conn->close();
}
?>
