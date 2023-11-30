<!--//SQL portion of alldata.php which handles all the queries-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Teaching Assistants</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php'; // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['tauserid'])) {
            // Handle the request to display information about a specific TA
            $tauserid = $_GET['tauserid'];

            // Fetch TA information
            $taQuery = "SELECT * FROM ta WHERE tauserid = '$tauserid'";
            $taResult = $conn->query($taQuery);

            if ($taResult->num_rows > 0) {
                $taData = $taResult->fetch_assoc();

                // Fetch courses the TA loves
                $loveQuery = "SELECT lcoursenum FROM loves WHERE ltauserid = '$tauserid'";
                $loveResult = $conn->query($loveQuery);
                $loves = $loveResult->fetch_all(MYSQLI_ASSOC);

                // Fetch courses the TA hates
                $hateQuery = "SELECT hcoursenum FROM hates WHERE htauserid = '$tauserid'";
                $hateResult = $conn->query($hateQuery);
                $hates = $hateResult->fetch_all(MYSQLI_ASSOC);

                // Display TA information
                echo "<h2>TA Information</h2>";
                echo "<table>";
                foreach ($taData as $key => $value) {
                    if ($key === 'image') {
                        // Display the image only when a TA is selected
                        echo "<tr>";
                        echo "<td><strong>" . ucfirst($key) . ":</strong></td>";
                        echo "<td><img src='" . ($value ? $value : 'https://www.americanconference.com/food-law/wp-content/uploads/sites/1993/2020/01/blank-headshot.png') . "' alt='TA Image' class='ta-image'></td>";
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        echo "<td><strong>" . ucfirst($key) . ":</strong></td>";
                        echo "<td>$value</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";

                // Display loved courses
                echo "<h3>Loves:</h3>";
                if (!empty($loves)) {
                    echo "<ul>";
                    foreach ($loves as $love) {
                        echo "<li>{$love['lcoursenum']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>This TA has not picked courses that they love.</p>";
                }

                // Display hated courses
                echo "<h3>Hates:</h3>";
                if (!empty($hates)) {
                    echo "<ul>";
                    foreach ($hates as $hate) {
                        echo "<li>{$hate['hcoursenum']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>This TA has not picked courses that they hate.</p>";
                }
            } else {
                echo "<p>TA not found.</p>";
            }
        } else {
            // Handle the request to list all TAs
            // Implement the logic to order by Last Name or Degree Type as requested
            $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'lastname';
            $order_type = isset($_GET['order_type']) ? $_GET['order_type'] : 'asc';

            $orderQuery = "SELECT * FROM ta ORDER BY $order_by $order_type";
            $orderResult = $conn->query($orderQuery);

            if ($orderResult->num_rows > 0) {
                echo "<h2>List of TAs</h2>";
                echo "<table>";
                echo "<tr>";
                echo "<th>User ID</th>"; // Label for tauserid
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Degree Type</th>";
                echo "<th>Student Number</th>";
                echo "</tr>";
                while ($row = $orderResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['tauserid']}</td>";
                    echo "<td>{$row['firstname']}</td>";
                    echo "<td>{$row['lastname']}</td>";
                    echo "<td>{$row['degreetype']}</td>";
                    echo "<td>{$row['studentnum']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No TAs found.</p>";
            }
        }
    }

    $conn->close();
    ?>
</body>

</html>
