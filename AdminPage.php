<!-- 
	 Name of Work Unit:  AdminPage.php
	 Purpose of Work Unit:  A page that contains the Event Log.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page contains the event log that can only be viewed by the admin.
-->

<?php
//Start the session and include the files that creates the underlying database and also the other functions.
session_start();
include "SessionTime.php";
include "Utility.php";

// Check if the Admin is logged in, if not then redirect him to login page
if(!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] !== true){
    header("location: Login.php");
    exit;
}

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv="refresh" content="600;url=Logout.php" > <!-- After 600 seconds (10 mins) the page refreshes and executes the Logout.php script which logs out the user after 10 mins on inactivity. -->  
    <title>Admin</title>
    <?php
        if(strtoupper($_SESSION["username"]) == "ADMIN" ){
            echo "<link rel='stylesheet' type='text/css' href='Style2.css'>"; // Link to style Sheet for the Admin
        }
        else{
            echo "<link rel='stylesheet' type='text/css' href='Style3.css'>"; // Link to style Sheet for a regurlar user
        }
    ?>
</head>
<body>
    <div class="ContainerTwo">
    <h1 style="color: white; padding-bottom: 3%;">Log Table</h1>
        <?php
            // Create connection with our seccureappsdb database
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
            // Check the connection and print error message if it fails.
            if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
            }   

            //If connection is established retrieve the data using the sql statement.
            $sql = "SELECT id, username, datetime, ip, useragent, action, outcome, reason FROM admin";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<table><tr><th>ID </th><th>Username </th><th>Date&Time </th><th>IpAddress </th><th>UserAgent </th><th>Action </th><th>Outcome </th><th>Reason </th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . RemoveXSS($row["username"]). " " . "</td><td>" . $row["datetime"]. "</td><td>" . $row["ip"]. "</td><td>" . $row["useragent"]. "</td><td>" . $row["action"]. "</td><td>" . $row["outcome"]. "</td><td>" . $row["reason"]. "</td></tr>";
                }
                echo "</table>";
            } 
            else {
                echo "0 results";
            }
            $link->close();
            ?>
    </div>
    <p>
        <?php
            //Display the nav bar below for the Admin
            if(strtoupper($_SESSION["username"]) == "ADMIN" ){
            echo "
                <nav>
                    <a href='MainMenu.php'>Main Menu</a>
                    <a href='AdminPage.php'>Admin</a>
                    <a href='HomePage.php'>Home</a>
                    <a href='ProfilePage.php'>Profile</a>
                    <a href='SecretRecords.php'>Secret Records</a>
                    <a href='ChangePassword.php'>Change Password</a>
                    <a href='Logout.php'>Logout</a>
                    <div id='indicator'></div>
                </nav>
                ";
            }
            //Display the nav bar below for a normal user
            else{
            echo "
                <nav>
                    <a href='MainMenu.php'>Main Menu</a>
                    <a href='HomePage.php'>Home</a>
                    <a href='ProfilePage.php'>Profile</a>
                    <a href='ChangePassword.php'>Change Password</a>
                    <a href='Logout.php'>Logout</a>
                    <div id='indicator'></div>
                </nav>
                ";
            }
        ?>
    </p>
</body>
</html>