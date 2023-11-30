<!--// page handles the queries and database of displaying studeents based on type of degree-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TA Information by Degree</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    // Include the connectdb.php file
    include 'connectdb.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['degree'])) {
            // Handle the request to list TAs by degree
            $selectedDegree = $_GET['degree'];

            // Fetch TA information for the selected degree
            $degreeQuery = "SELECT * FROM ta WHERE degreetype = '$selectedDegree'";
            $degreeResult = $conn->query($degreeQuery);

            if ($degreeResult->num_rows > 0) {
                echo "<div class='result-container'>";
                echo "<h2>List of TAs studying for $selectedDegree</h2>";
                echo "<table>";
                echo "<tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Student Number</th><th>Degree Type</th></tr>";
                while ($row = $degreeResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['tauserid']}</td>";
                    echo "<td>{$row['firstname']}</td>";
                    echo "<td>{$row['lastname']}</td>";
                    echo "<td>{$row['studentnum']}</td>";
                    echo "<td>{$row['degreetype']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p class='error-message'>No TAs found for $selectedDegree.</p>";
            }
        } else {
            echo "<p class='error-message'>Please select a degree.</p>";
        }
    }

    $conn->close();
    ?>
</body>

</html>
