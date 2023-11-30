<!--// page that outputs the modifications of TAs-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Teaching Assistant</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php';

    // Code for deleting an existing TA
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['delete_ta'])) {
            $tauserid = $_POST['tauserid'];

            // Check if the TA is assigned to a course offering
            $courseCheckQuery = "SELECT * FROM courseofferings WHERE tauserid = '$tauserid'";
            $courseCheckResult = $conn->query($courseCheckQuery);

            // Check if the TA is present in the hasworkedon table
            $hasWorkedOnQuery = "SELECT * FROM hasworkedon WHERE tauserid = '$tauserid'";
            $hasWorkedOnResult = $conn->query($hasWorkedOnQuery);

            if ($courseCheckResult->num_rows > 0 || ($hasWorkedOnResult !== false && $hasWorkedOnResult->num_rows > 0)) {
                echo "<p class='error-message'>Cannot delete this TA. The TA is assigned to a course offering or has worked on a course.</p>";
            } else {
                // Display confirmation message and form for deletion
                echo "<h2>Confirm Deletion</h2>";
                echo "<p>Are you sure you want to delete the TA with User ID: $tauserid?</p>";
                echo "<form action='modifyTA.php' method='post'>";
                echo "<input type='hidden' name='tauserid' value='$tauserid'>";
                echo "<input type='submit' name='confirm_delete' value='Yes'>";
                echo "<input type='submit' name='cancel_delete' value='No'>";
                echo "</form>";
            }
        } elseif (isset($_POST['confirm_delete'])) {
            $tauserid = $_POST['tauserid'];

            // Perform the deletion
            $deleteQuery = "DELETE FROM ta WHERE tauserid = '$tauserid'";
            $conn->query($deleteQuery);

            echo "<p class='success-message'>The TA with User ID: $tauserid has been deleted.</p>";
        } elseif (isset($_POST['cancel_delete'])) {
            echo "<p class='info-message'>Deletion canceled.</p>";
        } elseif (isset($_POST['insert_ta'])) {        // Code for inserting a new TA remains unchanged
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $studentnum = $_POST['studentnum'];
            $degreetype = $_POST['degreetype'];
            $tauserid = $_POST['tauserid'];

            // Check if the tauserid or studentnum already exists
            $checkExistingQuery = "SELECT * FROM ta WHERE tauserid = '$tauserid' OR studentnum = '$studentnum'";
            $existingResult = $conn->query($checkExistingQuery);

            if ($existingResult->num_rows > 0) {
                echo "<p class='error-message'>A TA with the same User ID or Student Number already exists. Please choose a different User ID or Student Number.</p>";
            } else {
                // Perform the insertion
                $insertQuery = "INSERT INTO ta (tauserid, firstname, lastname, studentnum, degreetype) VALUES ('$tauserid', '$firstname', '$lastname', '$studentnum', '$degreetype')";
                $conn->query($insertQuery);

                echo "<p class='success-message'>New TA inserted successfully.</p>";
            }
        }
    }

    // Display form for inserting a new TA
    echo "<h2>Insert New TA</h2>";
    echo "<form action='modifyTA.php' method='post'>";
    echo "<label for='tauserid'>User ID:</label>";
    echo "<input type='text' name='tauserid' required>";

    echo "<label for='firstname'>First Name:</label>";
    echo "<input type='text' name='firstname' required>";

    echo "<label for='lastname'>Last Name:</label>";
    echo "<input type='text' name='lastname' required>";

    echo "<label for='studentnum'>Student Number:</label>";
    echo "<input type='text' name='studentnum' required>";

    echo "<label for='degreetype'>Degree Type:</label>";
    echo "<select name='degreetype' required>";
    echo "<option value='Masters'>Masters</option>";
    echo "<option value='PhD'>PhD</option>";
    echo "</select>";

    echo "<input type='submit' name='insert_ta' value='Insert TA'>";
    echo "</form>";

    // Display the list of TAs
    $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'lastname';
    $order_type = isset($_GET['order_type']) ? $_GET['order_type'] : 'asc';

    $orderQuery = "SELECT * FROM ta ORDER BY $order_by $order_type";
    $orderResult = $conn->query($orderQuery);

    if ($orderResult->num_rows > 0) {
        echo "<h2>List of TAs</h2>";
        echo "<table>";
        echo "<tr>";
        echo "<th>User ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Degree Type</th>";
        echo "<th>Student Number</th>";
        echo "<th>Action</th>"; // Added for delete button
        echo "</tr>";
        while ($row = $orderResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['tauserid']}</td>";
            echo "<td>{$row['firstname']}</td>";
            echo "<td>{$row['lastname']}</td>";
            echo "<td>{$row['degreetype']}</td>";
            echo "<td>{$row['studentnum']}</td>";
            echo "<td><form action='modifyTA.php' method='post'>";
            echo "<input type='hidden' name='tauserid' value='{$row['tauserid']}'>";
            echo "<input type='submit' name='delete_ta' value='Delete'>";
            echo "</form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No TAs found.</p>";
    }

    $conn->close();
    ?>
<a href = "mainmenu.php">Back to Main Menu</a>
</body>

</html>
