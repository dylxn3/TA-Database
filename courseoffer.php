<!-- handles the php of the course offering page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Course Offerings for a Course</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php'; // Include the database connection

    // Fetch and display a list of courses for selection
    echo "<h2>Select a Course:</h2>";
    echo "<form action='' method='post'>";
    echo "<label for='whichcourse'>Course:</label>";
    echo "<select name='whichcourse' id='whichcourse'>";

    $courseQuery = "SELECT * FROM course";
    $courseResult = $conn->query($courseQuery);

    if ($courseResult->num_rows > 0) {
        while ($row = $courseResult->fetch_assoc()) {
            echo "<option value='{$row['coursenum']}'>{$row['coursename']}</option>";
        }
    } else {
        echo "<option value=''>No courses found</option>";
    }

    echo "</select>";

    // Submit button
    echo "<input type='submit' name='submit' value='View Course Offerings'>";
    echo "</form>";

    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $selectedCourse = $_POST['whichcourse'];

        // Fetch and display course offerings for the selected course
        echo "<h2>Course Offerings for $selectedCourse</h2>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Course Offering ID</th>";
        echo "<th>Number of Students</th>";
        echo "<th>Term</th>";
        echo "<th>Year</th>";
        echo "</tr>";

        $courseOfferingQuery = "SELECT * FROM courseoffer WHERE whichcourse = '$selectedCourse'";
        $courseOfferingResult = $conn->query($courseOfferingQuery);

        if ($courseOfferingResult->num_rows > 0) {
            while ($row = $courseOfferingResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['coid']}</td>";
                echo "<td>{$row['numstudent']}</td>";
                echo "<td>{$row['term']}</td>";
                echo "<td>{$row['year']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No course offerings found for $selectedCourse.</td></tr>";
        }

        echo "</table>";
    }

    $conn->close();
    ?>
<a href = "mainmenu.php"> Return to main menu</a>
</body>

</html>
