//handles theoutput of the course offerings of TA
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Offering Details</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php
    include 'connectdb.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['coid'])) {
        $selectedCourseOffering = $_GET['coid'];

        // Query to retrieve course information
        $courseQuery = "SELECT * FROM courseoffer WHERE coid = '$selectedCourseOffering'";
        $courseResult = $conn->query($courseQuery);

        if ($courseResult->num_rows > 0) {
            $courseData = $courseResult->fetch_assoc();

            // Query to retrieve TAs who have worked on the selected course offering
            $taQuery = "SELECT h.tauserid, t.firstname, t.lastname FROM hasworkedon h
                        JOIN ta t ON h.tauserid = t.tauserid
                        WHERE h.coid = '$selectedCourseOffering'";

            $taResult = $conn->query($taQuery);

            // Display course information
            echo "<div class='container'>";
            echo "<h2>Course Offering Information</h2>";
            echo "<table class='course-table'>";
            echo "<tr>";
            echo "<td><strong>Course Offering ID:</strong></td>";
            echo "<td>{$courseData['coid']}</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><strong>Course Number:</strong></td>";
            echo "<td>{$courseData['whichcourse']}</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><strong>Course Name:</strong></td>";
            echo "<td>{$courseData['whichcourse']}</td>";
            echo "</tr>";
            echo "</table>";

            // Display TAs who have worked on the course offering
            echo "<h3>TAs who have worked on this course offering</h3>";
            if ($taResult->num_rows > 0) {
                echo "<table class='ta-table'>";
                echo "<tr>";
                echo "<th>User ID</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "</tr>";

                while ($row = $taResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['tauserid']}</td>";
                    echo "<td>{$row['firstname']}</td>";
                    echo "<td>{$row['lastname']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No TAs have worked on this course offering.</p>";
            }
            echo "</div>";
        } else {
            echo "<p>Course Offering not found.</p>";
        }
    }

    $conn->close();
    ?>

</body>

</html>
