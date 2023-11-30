<!-- page gandles specifc course info page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Offering Information</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Course Offering Information</h1>

    <!-- Form for selecting a course offering -->
    <form action="display_course_offering.php" method="get">
        <label for="coid">Select Course Offering:</label>
        <select name="coid" id="coid">
            <?php
            include 'connectdb.php';

            // Fetch course offerings
            $courseOfferingsQuery = "SELECT * FROM courseoffer";
            $courseOfferingsResult = $conn->query($courseOfferingsQuery);

            if ($courseOfferingsResult->num_rows > 0) {
                while ($row = $courseOfferingsResult->fetch_assoc()) {
                    echo "<option value='{$row['coid']}'>{$row['coid']} - {$row['whichcourse']}</option>";
                }
            } else {
                echo "<option value=''>No Course Offerings found</option>";
            }

            $conn->close();
            ?>
        </select>

        <input type="submit" value="Select Course Offering">
    </form>

    <?php
    // Display TA information for the selected course offering
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
            echo "<h2>Course Offering Information</h2>";
            echo "<table>";
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
                echo "<table>";
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
        } else {
            echo "<p>Course Offering not found.</p>";
        }
    }
    ?>
</body>

</html>
