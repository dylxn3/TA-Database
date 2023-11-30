<!DOCTYPE html>

<html>
<head>
	<title>TA Database</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    	<link rel="stylesheet" type="text/css" href="museum.css">
</head>
<body>
<?php
// The Page that allows users to control what they would like to do
   include "connectdb.php";
   include "getmenu.php";
?>
<h1>Welcome to the TA Database! </h1>

<a href = "alldata.php"> All TA Info</a>
<br>
<br>
<br>
<a href = "degree.php"> List of Master and Phd TAs</a>
<br>
<br>
<br>
<a href = "modifyTA.php">Insert/Delete TA</a>
<br>
<br>
<br>
<a href = "image.php">Modify TA Image</a>
<br>
<br>
<br>
<a href = "assigncourse.php">Assign TA to a Course Offering</a>
<br>
<br>
<br>
<a href = "courseoffer.php">Specific Course Info</a>
<br>
<br>
<br>
<a href ="rangeoffer.php">See Course Offers from a Year to Year </a>
<br>
<br>
<br>
<a href ="TAcourseoffer.php">See All the Course Offerings a TA worked on </a>
<br>
<br>
<br>
<a href = "courseoffer2.php">See the TAs who worked on a Specific Course Offer </a>


</body>
</html>

