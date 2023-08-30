<!DOCTYPE html>
<html>
<head>
    <title>Member List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .member-photo {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <h1>Member List</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness_center_management_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM member";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error fetching member data: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Join Date</th>
                    <th>Photo</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['MemberID'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Phone'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['JoinDate'] . "</td>";
            echo "<td><img class='member-photo' src='" . $row['photo_link'] . "' alt='Member Photo'></td>";
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo "<p>No member data found.</p>";
    }

    $conn->close();
    ?>

    <a href="dashboard.html">Go to Dashboard</a>
</body>
</html>
