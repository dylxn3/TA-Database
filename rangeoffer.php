<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Course Offerings by Year</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php'; // Include the database connection

    // Display form for selecting start and end years
    echo "<h2>Select Year Range:</h2>";
    echo "<form action='' method='post'>";
    echo "<label for='startyear'>Start Year:</label>";
    echo "<input type='number' name='startyear' id='startyear' required>";

    echo "<label for='endyear'>End Year:</label>";
    echo "<input type='number' name='endyear' id='endyear' required>";

    echo "<input type='submit' name='submit' value='View Course Offerings'>";
    echo "</form>";

    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $startYear = $_POST['startyear'];
        $endYear = $_POST['endyear'];

        // Display course offerings based on the selected year range
        echo "<h2>Course Offerings between $startYear and $endYear</h2>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Course Offering ID</th>";
        echo "<th>Number of Students</th>";
        echo "<th>Term</th>";
        echo "<th>Year</th>";
        echo "<th>Course Name</th>";  // Add the column for the course name
        echo "</tr>";

        $filteredCourseOfferingQuery = "SELECT co.*, c.coursename FROM courseoffer co JOIN course c ON co.whichcourse = c.coursenum WHERE co.year BETWEEN $startYear AND $endYear";
        $filteredCourseOfferingResult = $conn->query($filteredCourseOfferingQuery);

        if ($filteredCourseOfferingResult->num_rows > 0) {
            while ($row = $filteredCourseOfferingResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['coid']}</td>";
                echo "<td>{$row['numstudent']}</td>";
                echo "<td>{$row['term']}</td>";
                echo "<td>{$row['year']}</td>";
                echo "<td>{$row['coursename']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No course offerings found between $startYear and $endYear.</td></tr>";
        }

        echo "</table>";
    }

    $conn->close();
    ?>
<a href = "mainmenu.php">Return to Main Menu</a>
</body>

</html>
