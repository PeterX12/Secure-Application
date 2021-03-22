<!-- 
	 Name of Work Unit:  MainMenu.php
	 Purpose of Work Unit:  The Main Menu Page for this project.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: The Main Menu for this project.
-->

<?php

//Start the session and include the file that calculates the session time.
session_start();
include "SessionTime.php";
include "Utility.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- After 600 seconds (10 mins) the page refreshes and executes the Logout.php script which logs out the user after 10 mins on inactivity. -->  
	<meta charset="UTF-8" http-equiv="refresh" name="viewport" content="width=device-width, initial-scalre=1.0, 600;url=Logout.php">
    <title>Menu</title>
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
<h1 class="MenuHeader">Hi, <b><?php echo RemoveXSS($_SESSION["username"]); ?></b>. Welcome to the Main Menu.</h1>
<?php
    //Display the nav bar below and the menu below for the Admin
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

        <div class='center'>
            <ul class='menu'>
                <a class='menuCell' href='AdminPage.php'> 
                    <img class='menuCellImg' src='One.jpg'>
                    <div class='menuCellTitle'>Admin</div>
                </a>
            
                <a class='menuCell' href='HomePage.php'> 
                    <img class='menuCellImg' src=Two.gif>
                    <div class='menuCellTitle'>Home</div>
                </a>
                <a class=menuCell href=ProfilePage.php> 
                    <img class='menuCellImg' src='Three.jfif'>
                    <div class='menuCellTitle'>Profile</div>
                </a>
                <a class=menuCell href=SecretRecords.php> 
                    <img class='menuCellImg' src='Four.jpg'>
                    <div class='menuCellTitle'>Secret Records</div>
                </a>
                <!-- Hiddden Cell to help with layout -->  
                <li class='menuCell menuHidden'>
                </li>
                <a class='menuCell' href='ChangePassword.php'> 
                    <img class='menuCellImg' src='Five.gif'>
                    <div class='menuCellTitle'>Change Password</div>
                </a>
                <a class='menuCell' href='Logout.php'> 
                    <img class='menuCellImg' src='Six.jfif'>
                    <div class='menuCellTitle'>Logout</div>
                </a>
            </ul>
        </div>
        ";
    }
    //Display the nav bar below and the menu below for a normal user
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

                
        <ul class='menu'>
            <a class='menuCell' href='HomePage.php'> 
            <img class='menuCellImg' src=Two.gif>
            <div class='menuCellTitle'>Home</div>
            </a>
            <a class=menuCell href=ProfilePage.php> 
            <img class='menuCellImg' src='Three.jfif'>
            <div class='menuCellTitle'>Profile</div>
            </a>
            <a class='menuCell' href='ChangePassword.php'> 
            <img class='menuCellImg' src='Five.gif'>
            <div class='menuCellTitle'>Change Password</div>
            </a>
            <a class='menuCell' href='Logout.php'> 
            <img class='menuCellImg' src='Six.jfif'>
            <div class='menuCellTitle'>Logout</div>
            </a>
        </ul>";     
    }
?>  
</body>
</html>

