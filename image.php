<!--// handles the modification of  a TAs image -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify TA Image URL</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include 'connectdb.php'; // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['tauserid']) && isset($_POST['new_image_url'])) {
            $tauserid = $_POST['tauserid'];
            $newImageUrl = $_POST['new_image_url'];

            // Update the image URL for the selected TA
            $updateQuery = "UPDATE ta SET image = '$newImageUrl' WHERE tauserid = '$tauserid'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "<p class='success-message'>Image URL for TA with User ID: $tauserid has been updated.</p>";
            } else {
                echo "<p class='error-message'>Error updating image URL: " . $conn->error . "</p>";
            }
        }
    }

    // Display form for modifying image URL
    echo "<h2>Modify TA Image URL</h2>";
    echo "<form action='image.php' method='post'>";
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

    echo "<label for='new_image_url'>New Image URL:</label>";
    echo "<input type='text' name='new_image_url' required>";

    echo "<input type='submit' value='Update Image URL'>";
    echo "</form>";

    $conn->close();
    ?>
</body>

</html>
