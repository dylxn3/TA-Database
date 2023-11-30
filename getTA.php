<!-- Handles the queries for modifying a TA -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Assistants</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php';

    // Code for deleting an existing TA
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['delete_ta'])) {
            $tauserid = $_POST['tauserid'];

            // Check if the TA is present in the hasworkedon table
            $hasWorkedOnQuery = "SELECT * FROM hasworkedon WHERE tauserid = '$tauserid'";
            $hasWorkedOnResult = $conn->query($hasWorkedOnQuery);

            if ($hasWorkedOnResult !== false) {
                if ($hasWorkedOnResult->num_rows > 0) {
                    echo "<p>Cannot delete this TA. The TA has worked on a course.</p>";
                } else {
                    // Display confirmation message and form for deletion
                    echo "<h2>Confirm Deletion</h2>";
                    echo "<p>Are you sure you want to delete the TA with User ID: $tauserid?</p>";
                    echo "<form action='getTA.php' method='post'>";
                    echo "<input type='hidden' name='tauserid' value='$tauserid'>";
                    echo "<input type='submit' name='confirm_delete' value='Yes'>";
                    echo "<input type='submit' name='cancel_delete' value='No'>";
                    echo "</form>";
                }
            } else {
                // Display an error message for debugging purposes
                echo "<p class='error-message'>Query failed: " . $conn->error . "</p>";
            }
        } elseif (isset($_POST['confirm_delete'])) {
            $tauserid = $_POST['tauserid'];

            // Check if the TA is present in the hasworkedon table again before deletion
            $checkWorkedOnQuery = "SELECT * FROM hasworkedon WHERE tauserid = '$tauserid'";
            $checkWorkedOnResult = $conn->query($checkWorkedOnQuery);

            if ($checkWorkedOnResult !== false && $checkWorkedOnResult->num_rows > 0) {
                echo "<p class='error-message'>Cannot delete this TA. The TA has worked on a course.</p>";
            } else {
                // Perform the deletion
                $deleteQuery = "DELETE FROM ta WHERE tauserid = '$tauserid'";
                if ($conn->query($deleteQuery) === TRUE) {
                    echo "<p class='success-message'>The TA with User ID: $tauserid has been deleted.</p>";
                } else {
                    // Display an error message for debugging purposes
                    echo "<p class='error-message'>Deletion failed: " . $conn->error . "</p>";
                }
            }
        } elseif (isset($_POST['cancel_delete'])) {
            echo "<p class='info-message'>Deletion canceled.</p>";
        }
    }

    // Code for inserting a new TA
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_ta'])) {
        $tauserid = $_POST['tauserid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $studentnum = $_POST['studentnum'];
        $degreetype = $_POST['degreetype'];

        // Check if the TA with the given User ID already exists
        $checkExistenceQuery = "SELECT * FROM ta WHERE tauserid = '$tauserid'";
        $existenceResult = $conn->query($checkExistenceQuery);

        if ($existenceResult !== false && $existenceResult->num_rows > 0) {
            echo "<p class='error-message'>TA with User ID $tauserid already exists.</p>";
        } else {
            // Perform the insertion
            $insertQuery = "INSERT INTO ta (tauserid, firstname, lastname, studentnum, degreetype) VALUES ('$tauserid', '$firstname', '$lastname', '$studentnum', '$degreetype')";
            if ($conn->query($insertQuery) === TRUE) {
                echo "<p class='success-message'>New TA inserted successfully.</p>";
            } else {
                // Display an error message for debugging purposes
                echo "<p class='error-message'>Insertion failed: " . $conn->error . "</p>";
            }
        }
    }

    // Display the list of TAs
    $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'lastname';
    $order_type = isset($_GET['order_type']) ? $_GET['order_type'] : 'asc';

    $orderQuery = "SELECT * FROM ta ORDER BY $order_by $order_type";
    $orderResult = $conn->query($orderQuery);

    if ($orderResult !== false) {
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
                echo "<td><form action='getTA.php' method='post'>";
                echo "<input type='hidden' name='tauserid' value='{$row['tauserid']}'>";
                echo "<input type='submit' name='delete_ta' value='Delete'>";
                echo "</form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No TAs found.</p>";
        }
    } else {
        // Display an error message for debugging purposes
        echo "<p class='error-message'>Query failed: " . $conn->error . "</p>";
    }

    $conn->close();
    ?>
</body>

</html>
