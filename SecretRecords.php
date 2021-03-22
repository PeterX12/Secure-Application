<!-- 
	 Name of Work Unit:  SecretRecords.php
	 Purpose of Work Unit:  A page that contains Secret Records.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page contains secret records that can only be viewed by the admin.
-->

<?php
//Start the session and include the files that creates the underlying database and also the other functions.
session_start();
include "SessionTime.php";
include 'Utility.php';

 
// Check if the Admin is logged in, if not then redirect him to login page
if(!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] !== true){
    header("location: Login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" http-equiv="refresh" content="600;url=Logout.php" > <!-- After 600 seconds (10 mins) the page refreshes and executes the Logout.php script which logs out the user after 10 mins on inactivity. -->  
    <title>Secret Records</title>
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
    <div class="Container">
        <h1>Hi, <b><?php echo RemoveXSS($_SESSION["username"]); ?></b>. Welcome to my Secret Records.</h1>
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