<!-- 
	 Name of Work Unit:  Logout.php
	 Purpose of Work Unit:  Logs the user out of the application.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page logs out the user and unsets the session variables.
-->

<?php
// Start the session and include the file that creates the underlying database
session_start();
include 'db.include.php';

//Save the user agent, ip addreess and username into variables.
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$username = $_SESSION["username"];

//Set the default timezone and save the current time into a variable.
date_default_timezone_set('Europe/London');
$date = date('Y/m/d H:i:s');

// Create connection with our seccureappsdb database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
// Check the connection and print error message if it fails.
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());

    //If connection is established insert the data into the admin table using the sql statement.
    $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome)
            VALUES ('$username', '$date', '$ip', '$userAgent', 'Logout', 'Unsucessful', 'Conncetion Failed')";
}

//If connection is established insert the data into the admin table using the sql statement.
$sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome)
        VALUES ('$username', '$date', '$ip', '$userAgent', 'Logout', 'Succesfull')";

//Error message if the sql query fails.
if (!mysqli_query($link, $sql)) {
    echo "Error: " . $sql . "<br>" . mysqli_error($link2);

    //If connection is established insert the data into the admin table using the sql statement.
    $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome)
            VALUES ('$username', '$date', '$ip', '$userAgent', 'Logout', 'Unsucessful', 'Execution Failed')";
}
 
// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: Login.php");
exit;
?>