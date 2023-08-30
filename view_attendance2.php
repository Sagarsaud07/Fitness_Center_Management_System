<!DOCTYPE html>
<html>
<head>
    <title>View Attendance</title>
    <!-- Add your stylesheet and other head elements here -->
</head>
<body>
    <?php
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

    $selectedDate = ""; // Initialize the variable

    if (isset($_GET['date'])) {
        $selectedDate = $_GET['date'];
    }
    ?>

    <h1>View Attendance for <?php echo $selectedDate; ?></h1>

    <?php
    if (!empty($selectedDate)) {
        $sql = "SELECT a.memberId, m.FirstName, m.LastName, a.`TIME`, a.attendanceDate 
                FROM attendance2 AS a
                JOIN member AS m ON a.memberId = m.MemberID
                WHERE a.attendanceDate = '$selectedDate'";

        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error fetching attendance data: " . $conn->error;
        } elseif ($result->num_rows > 0) {
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
            echo "<p>No attendance data found for $selectedDate.</p>";
        }
    } else {
        echo "<p>No date selected.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
