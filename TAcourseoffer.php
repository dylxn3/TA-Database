<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TA Course Offerings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php
// Include database connection
include 'connectdb.php';

// Fetch TAs for dropdown
$result = $conn->query("SELECT tauserid, firstname, lastname FROM ta");
?>

<form method="post" action="">
    <label for="ta">Select TA:</label>
    <select name="ta" id="ta">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["tauserid"] . "'>" . $row["firstname"] . " " . $row["lastname"] . "</option>";
        }
        ?>
    </select>
    <input type="submit" value="Show Courses">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected TA
    $selectedTA = $_POST["ta"];

    // Fetch course offerings for the selected TA
    $query = "SELECT c.coursenum, c.coursename, co.term, co.year, h.hours,
                     CASE 
                        WHEN l.lcoursenum IS NOT NULL THEN '😊'  -- Loved the course
                        WHEN hi.hcoursenum IS NOT NULL THEN '☹️'  -- Hated the course
                        ELSE NULL
                     END AS emotion
              FROM hasworkedon h
              JOIN courseoffer co ON h.coid = co.coid
              JOIN course c ON co.whichcourse = c.coursenum
              LEFT JOIN loves l ON l.ltauserid = '$selectedTA' AND l.lcoursenum = co.coid
              LEFT JOIN hates hi ON hi.htauserid = '$selectedTA' AND hi.hcoursenum = c.coursenum
              WHERE h.tauserid = '$selectedTA'";

    $result = $conn->query($query);

    // Check for errors in the query
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Display the results
    echo "<h2>Course Offerings for TA: $selectedTA</h2>";
    echo "<table>";
    echo "<tr><th>Course Number</th><th>Course Name</th><th>Term</th><th>Year</th><th>Hours</th><th>Emotion</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["coursenum"] . "</td>";
        echo "<td>" . $row["coursename"] . "</td>";
        echo "<td>" . $row["term"] . "</td>";
        echo "<td>" . $row["year"] . "</td>";
        echo "<td>" . $row["hours"] . "</td>";
        echo "<td style='font-size: 1.5em;'>" . ($row["emotion"] !== null ? $row["emotion"] : "") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
<a href = "mainmenu.php">Return to Main Menu </a>
</body>
</html>
