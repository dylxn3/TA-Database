<!--handles output for assigning TA a course offering -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign TA to Course Offering</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php'; // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['tauserid']) && isset($_POST['coid']) && isset($_POST['hours'])) {
            $tauserid = $_POST['tauserid'];
            $coid = $_POST['coid'];
            $hours = $_POST['hours'];

            // Check if the relationship already exists
            $checkExistQuery = "SELECT * FROM hasworkedon WHERE tauserid = '$tauserid' AND coid = '$coid'";
            $existResult = $conn->query($checkExistQuery);

            if ($existResult->num_rows > 0) {
                echo "<p class='error-message'>TA is already assigned to this course offering.</p>";
            } else {
                // Create the relationship
                $assignQuery = "INSERT INTO hasworkedon (tauserid, coid, hours) VALUES ('$tauserid', '$coid', '$hours')";
                if ($conn->query($assignQuery) === TRUE) {
                    echo "<p class='success-message'>TA has been successfully assigned to the course offering.</p>";
                } else {
                    echo "<p class='error-message'>Error assigning TA to course offering: " . $conn->error . "</p>";
                }
            }
        }
    }

    // Display form for assigning TA to course offering
    echo "<h2>Assign TA to Course Offering</h2>";
    echo "<form action='assigncourse.php' method='post'>";

    // Dropdown menu to select TA
    echo "<label for='tauserid'>Select TA:</label>";
    echo "<select name='tauserid' id='tauserid'>";

    // Fetch and display a list of TAs for selection
    $taQuery = "SELECT tauserid, firstname, lastname FROM ta";
    $taResult = $conn->query($taQuery);

    if ($taResult->num_rows > 0) {
        while ($row = $taResult->fetch_assoc()) {
            echo "<option value='{$row['tauserid']}'>{$row['firstname']} {$row['lastname']}</option>";
        }
    } else {
        echo "<option value=''>No TAs found</option>";
    }

    echo "</select>";

    // Dropdown menu to select Course Offering
    echo "<label for='coid'>Select Course Offering:</label>";
    echo "<select name='coid' id='coid'>";

    // Fetch and display a list of Course Offerings for selection
    $courseQuery = "SELECT coid, whichcourse, term FROM courseoffer";
    $courseResult = $conn->query($courseQuery);

    if ($courseResult->num_rows > 0) {
        while ($row = $courseResult->fetch_assoc()) {
            echo "<option value='{$row['coid']}'>{$row['term']} - {$row['whichcourse']}</option>";
        }
    } else {
        echo "<option value=''>No Course Offerings found</option>";
    }

    echo "</select>";

    // Input for the number of hours
    echo "<label for='hours'>Enter Number of Hours:</label>";
    echo "<input type='number' name='hours' required>";

    // Submit button
    echo "<input type='submit' value='Assign TA'>";
    echo "</form>";

    $conn->close();
    ?>
<a href ="mainmenu.php">Return to Main Menu</a>
</body>

</html>
