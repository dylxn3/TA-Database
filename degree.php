<!-- page that allows users to see the masters and PHD students-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TA Information by Degree</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>TA Information by Degree</h1>

        <form action="getdegree.php" method="get">
            <label for="degree">Select Degree:</label>
            <select name="degree" id="degree">
                <option value="Masters">Masters</option>
                <option value="PhD">PhD</option>
            </select>

            <input type="submit" value="Get TA Information">
        </form>

        <!-- Display TA information here -->
        <?php
        // Include the getdegree.php file
        include 'getdegree.php';
        ?>
    </div>
</body>

</html>
