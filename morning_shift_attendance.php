<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['removeFromMorningShift']) && isset($_POST['removeMembers']) && is_array($_POST['removeMembers'])) {
        $removeMembers = $_POST['removeMembers'];

        foreach ($removeMembers as $memberID) {
            $removeQuery = "DELETE FROM morning_shift WHERE MemberID = '$memberID'";
            $conn->query($removeQuery);
        }

        echo "Members removed from morning shift successfully.";
    }

    if (isset($_POST['markMembership']) && isset($_POST['selectedMembers']) && is_array($_POST['selectedMembers']) && isset($_POST['durationDays'])) {
        $selectedMembers = $_POST['selectedMembers'];
        $durationDays = $_POST['durationDays'];

        foreach ($selectedMembers as $memberID) {
            $expiryDate = date("Y-m-d", strtotime("+$durationDays days"));
            $membershipStatus = (date("Y-m-d") <= $expiryDate) ? 'Active' : 'Expired';

            $insertQuery = "INSERT INTO morning_shift (MemberID, MembershipDurationDays, MembershipExpiryDate, MembershipStatus) VALUES ('$memberID', '$durationDays', '$expiryDate', '$membershipStatus')";
            $conn->query($insertQuery);
            echo "Member added to morning shift with membership successfully.";
        }
    }
}

$addedMembersSQL = "SELECT member.MemberID, member.FirstName, member.LastName, morning_shift.MembershipDurationDays, morning_shift.MembershipStatus FROM member INNER JOIN morning_shift ON member.MemberID = morning_shift.MemberID";
$addedMembersResult = $conn->query($addedMembersSQL);

$removeMembersSQL = "SELECT member.MemberID, member.FirstName, member.LastName, morning_shift.MembershipDurationDays, morning_shift.MembershipStatus FROM member LEFT JOIN morning_shift ON member.MemberID = morning_shift.MemberID WHERE morning_shift.MemberID IS NULL";
$removeMembersResult = $conn->query($removeMembersSQL);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Morning Shift Members</title>
    <!-- Add your stylesheet and other head elements here -->
</head>
<body>
    <h1>Morning Shift Members</h1>

    <h2>Add Members with Membership to Morning Shift</h2>
    <form action="morning_shift_attendance.php" method="post">
        <table>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Membership Duration (Days)</th>
                <th>Membership Status</th>
                <th>Add to Morning Shift</th>
            </tr>

            <?php
            if ($removeMembersResult && $removeMembersResult->num_rows > 0) {
                while ($row = $removeMembersResult->fetch_assoc()) {
                    $membershipStatus = ($row['MembershipStatus'] === 'Active') ? '<span style="color: green;">Active</span>' : '<span style="color: red;">Expired</span>';
                    echo "<tr>
                            <td>{$row['MemberID']}</td>
                            <td>{$row['FirstName']}</td>
                            <td>{$row['LastName']}</td>
                            <td>{$row['MembershipDurationDays']}</td>
                            <td>{$membershipStatus}</td>
                            <td><input type='checkbox' name='selectedMembers[]' value='" . $row['MemberID'] . "'></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>All members are already in the morning shift.</td></tr>";
            }
            ?>

        </table>
        <label for="durationDays">Membership Duration (Days): </label>
        <input type="number" name="durationDays" value="30">
        <input type="submit" name="markMembership" value="Add to Morning Shift with Membership">
    </form>

    <h2>Added Members in Morning Shift</h2>
    <form action="morning_shift_attendance.php" method="post">
        <table>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Membership Duration (Days)</th>
                <th>Membership Status</th>
                <th>Remove from Morning Shift</th>
            </tr>

            <?php
            if ($addedMembersResult && $addedMembersResult->num_rows > 0) {
                while ($row = $addedMembersResult->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['MemberID']}</td>
                            <td>{$row['FirstName']}</td>
                            <td>{$row['LastName']}</td>
                            <td>{$row['MembershipDurationDays']}</td>
                            <td>{$row['MembershipStatus']}</td>
                            <td><input type='checkbox' name='removeMembers[]' value='" . $row['MemberID'] . "'></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No member data found.</td></tr>";
            }
            ?>

        </table>
        <input type="submit" name="removeFromMorningShift" value="Remove from Morning Shift">
    </form>

    <a href="dashboard.html">Go back to Dashboard</a>
</body>
</html>
