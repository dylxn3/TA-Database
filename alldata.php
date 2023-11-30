<!DOCTYPE html>
<html lang="en">
<!--Page for allowing users to see all TA and sort -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Data</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>All Teaching Assistants</h1>

    <!-- Form for ordering -->
    <form action="getalldata.php" method="get">
        <label for="order_by">Order by:</label>
        <select name="order_by" id="order_by">
            <option value="lastname">Last Name</option>
            <option value="degreetype">Degree Type</option>
        </select>

        <label for="order_type">Order type:</label>
        <input type="radio" name="order_type" value="asc" checked> Ascending
        <input type="radio" name="order_type" value="desc"> Descending

        <input type="submit" value="Order">
    </form>

    <!-- Form for selecting a TA -->
    <form action="getalldata.php" method="get">
        <label for="tauserid">Select TA:</label>
        <select name="tauserid" id="tauserid">
            <?php
            include 'connectdb.php'; // Include the database connection
            $taQuery = "SELECT tauserid, firstname, lastname FROM ta";
            $taResult = $conn->query($taQuery);

            if ($taResult->num_rows > 0) {
                while ($row = $taResult->fetch_assoc()) {
                    echo "<option value='{$row['tauserid']}'>{$row['firstname']} {$row['lastname']}</option>";
                }
            } else {
                echo "<option value=''>No TAs found</option>";
            }

            $conn->close();
            ?>
        </select>

        <input type="submit" value="Select TA">
    </form>

    <!-- Display the list of TAs or TA details here -->
    <?php
    // Fetch and display a list of all TAs or TA details
    include 'getalldata.php';
    ?>

</body>

</html>
