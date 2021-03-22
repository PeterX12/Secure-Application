<!-- 
	 Name of Work Unit:  ChangePassword.php
	 Purpose of Work Unit:  Enables the admin or user to change their password.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This is page allows the user  or admin to change their password for our secure web application.
-->

<?php
//Start the session and include the filesz that creates the underlying database and also the other functions.
session_start();
include "SessionTime.php";
include 'Utility.php';
include 'CSRF.php';
require_once "db.include.php";
 
//Check if the user is logged in, otherwise redirect to the Login page.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login.php");
    exit;
}

 
// Define variables and initialize with empty values.
$password = "";
$password2 = "";
$confirm_password = "";
$passwordErrorMsg = "";
$password2ErrorMsg = "";

//Save the username and token into variables.
$username = $_SESSION["username"];
$token = $_SESSION['token'];

//Save the user agent and ip addreess into variables.
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];

//Set the default timezone and save the current time into a variable.
date_default_timezone_set('Europe/London');
$date = date('Y/m/d H:i:s');

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])){
 
    //Perfrom CSRF Check. If the hash of the token being sent via the GET request is not the same as the hash of the session token. Log out the user.
    if(!hash_equals($_SESSION['token'], $_GET['token'])){
      header("location: Logout.php");
      exit;
    }

    //Validate the password 
    if(empty(trim($_GET["password"]))){
        $passwordErrorMsg = "Please enter a password.";

         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
         // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

         //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'No Password/Confrim Password Entered')";
         
         //Error message if the sql query fails. 
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    elseif(strlen(trim($_GET["password"])) < 8){
        $passwordErrorMsg = "Password must be at least 8 characters.";

         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
         // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

        //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'Invalid Password')";
         
         //Error message if the sql query fails. 
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    elseif(!preg_match('@[A-Z]@',trim($_GET["password"]))){
        $passwordErrorMsg = "Password must contain at least one Uper Case Character";
        
         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
         // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

         //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'Invalid Password')";
         
         //Error message if the sql query fails.
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    elseif(!preg_match('@[a-z]@',trim($_GET["password"]))){
        $passwordErrorMsg = "Password must contain at least one Lower Case Character";  
        
         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
         // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

         //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'Invalid Password')";
         
         //Error message if the sql query fails. 
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    elseif(!preg_match('@[0-9]@',trim($_GET["password"]))){
        $passwordErrorMsg = "Pasword must contain at least one number";   

         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
         // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

         //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'Invalid Password')";
         
         //Error message if the sql query fails. 
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    elseif(!preg_match('@[^\w]@',trim($_GET["password"]))){
        $passwordErrorMsg = "Pasword must contain at least one Special character";   

         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
        // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

         //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'Invalid Password')";
         
         //Error message if the sql query fails. 
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    else{
        $password = trim($_GET["password"]);
    }    
    

    //Now Validate the confirm password field
    if(empty(trim($_GET["password2"]))){
        $password2ErrorMsg = "Please confirm your password.";   
        
         // Create connection with our seccureappsdb database
         $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
         // Check the connection and print error message if it fails.
         if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
         }

         //If connection is established insert the data into the admin table using the sql statement.
         $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                 VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'No Password/Confrim Password Entered')";
         
         //Error message if the sql query fails. 
         if (!mysqli_query($link, $sql)) {
             echo "Error: " . $sql . "<br>" . mysqli_error($link2);
         }
    }
    elseif(empty($password2ErrorMsg) && (trim($_GET["password"]) != trim($_GET["password2"]))){
        $password2ErrorMsg = "Passwords do not match.";

        // Create connection with our seccureappsdb database
        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
        // Check the connection and print error message if it fails.
        if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
        }

        //If connection is established insert the data into the admin table using the sql statement.
        $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'Passwords Did Not Match')";
        
        //Error message if the sql query fails. 
        if (!mysqli_query($link, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($link2);
        }
    }
    elseif(empty($passwordErrorMsg)){
        $password2 = trim($_GET["password2"]);
    }

    /*Generate a Random Salt, then prepend it to the password and then hash them both (Could use password_hash() function which auto generates the
    salt but doing it this way to demostrate the manual creation of a salt and prepending it to the password and then hashing them*/
    if(empty($usernameErrorMsg) && empty($passwordErrorMsg) && empty($password2ErrorMsg)){
        $salt = uniqid(mt_rand(), true);
        $saltAndPassword = $salt . $password;
        $hashedPassword = md5($saltAndPassword);
    }    
        
    //Check input errors before inserting in database
    if(empty($usernameErrorMsg) && empty($passwordErrorMsg) && empty($password2ErrorMsg) && !empty($hashedPassword) && !empty($salt)){
        // Prepare an update statement
        $sql = "UPDATE users SET hash = ?, salt = ? WHERE id = ?";
        
        if($statement = mysqli_prepare($link2, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($statement, "ssi", $param_hashedPassword, $param_salt, $param_id);
            
            // Set parameters
            $param_hashedPassword = $hashedPassword;
            $param_salt = $salt;
            $param_id = $_SESSION["id"];

            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($statement)){

                // Create connection with our seccureappsdb database
                $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
                // Check the connection and print error message if it fails.
                if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
                }

                //If connection is established insert the data into the admin table using the sql statement.
                $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome)
                        VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Succesfull')";
                
                //Error message if the sql query fails. 
                if (!mysqli_query($link, $sql)) {
                    echo "Error: " . $sql . "<br>" . mysqli_error($link2);
                }

                // Password updated successfully. Destroy the session, and redirect to login page
                $_SESSION = array();
                session_destroy();
                header("location: Login.php");
                exit();
            } else{
                echo "An Error has occured! Something went wrong. Please try again.";
            }

            // Close statement
            mysqli_stmt_close($statement);
        }
    }
    
    // Close connection
    mysqli_close($link2);
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- After 600 seconds (10 mins) the page refreshes and executes the Logout.php script which logs out the user after 10 mins on inactivity. -->
<meta charset="UTF-8" http-equiv="refresh" content="600;url=Logout.php" >
    <title>Change Password</title>
    <?php
        if(strtoupper($_SESSION["username"]) == "ADMIN" ){
            echo "<link rel='stylesheet' type='text/css' href='Style2.css'>"; // Link to style Sheet for the Admin
        }
        else{
            echo "<link rel='stylesheet' type='text/css' href='Style3.css'>"; // Link to style Sheet for a regurlar user     
        }
    ?>
    <script type = "text/javascript" src="Functions.js"></script> 
</head>
<body>
    <form class="Container" method="GET" action="<?php echo RemoveXSS($_SERVER["PHP_SELF"]); ?>">          
        <h1>Change Password</h1>

        <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>">
        <span><?php echo $passwordErrorMsg; ?></span>

        <input type="password" name="password2" id="password2" placeholder="Confirm Password" value="<?php echo $password2; ?>">
        <span><?php echo $password2ErrorMsg; ?></span>

        <input type="checkbox" onclick="showPassAndConfirm()">Show Password

        <!-- Token being submitted with the form using a hidden field. -->
        <input type="hidden" name="token" id="token" value="<?php echo $token ?>">

        <input type="submit" value="Change Password" name="submit">

        <p>Already Signed Up? <a href="Login.php">Login here</a>.</p>
      </form>
  </div>
  <p>
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
                ";
            }
        ?>
    </p>    
</body>
</html>