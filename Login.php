<!-- 
	 Name of Work Unit:  Login.php
	 Purpose of Work Unit:  Enables the User to log in securely into our web application.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page lets the user log in. The user is allowed 5 attempts to log in and if they fail to do so are locked out for 3 mins.
-->

<?php 
//Start the session and include the files that creates the underlying database and also the other functions.
include 'db.include.php';
include 'Utility.php';
session_start();

// If the counter for the number of login attempts is not set then set it to 0.
if (!isset($_SESSION['counter'])) { 
    $_SESSION['counter'] = 0;
}

//Checks if the number of loggin attments is not more than 5.
if($_SESSION['counter'] < 4){
    // Check if the user is already logged in and if they are redirect them to the HomePage.
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	    header("location: HomePage.php");
	    exit;
    }

    //Defined Variables that will be used and set to empty strings.
    $username = "";
    $password = "";
    $salt = "";
    $saltAndPassword = "";
    $hashedPassword = "";
    $errorMsg = "";
    $usernameErrorMsg = "";

    //Save the user agent and ip addreess into variables.
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $ip = $_SERVER['REMOTE_ADDR'];

    //Set the default timezone and save the current time into a variable.
    date_default_timezone_set('Europe/London');
    $date = date('Y/m/d H:i:s');

    //Once the form is submitted process it's data.
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Check if the username is empty.
        if(empty(trim($_POST["username"]))){
            $usernameErrorMsg = "Please enter a username";
        } else{
            $username = trim($_POST["username"]);
        }
            
        //Check if the password is empty.
        if(empty(trim($_POST["password"]))){
            $errorMsg = "Please enter a password.";

            // Create connection with our seccureappsdb database.
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
            // Check the connection and print error message if it fails.
            if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
            }

            //If connection is established insert the data into the admin table using the sql statement.
            $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                    VALUES ('$username', '$date', '$ip', '$userAgent', 'Login', 'Unsuccesfull', 'No Username/Password Entered')";
                
            //Error message if the sql query fails.
            if (!mysqli_query($link, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($link2);
            }
        } else{
            $password = trim($_POST["password"]);
        }
            
        //Validate the credentials.
        if(empty($errorMsg)){
            //If connection is established retrieve the data using the sql statement.
            $sql = "SELECT BINARY id, username, hash, salt FROM users WHERE username = ?";
                
            if($statement = mysqli_prepare($link2, $sql)){
                // Bind variables to the prepared statement as parameters.
                mysqli_stmt_bind_param($statement, "s", $param_username);
                    
                // Set the parameters.
                $param_username = $username;
                    
                // Attempt to execute the prepared statement.
                if(mysqli_stmt_execute($statement)){
                    // Store the result
                    mysqli_stmt_store_result($statement);
                        
                    // Check if the username exists, if yes then verify the password.
                    if(mysqli_stmt_num_rows($statement) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($statement, $id, $username, $hash, $salt);
                        if(mysqli_stmt_fetch($statement)){
                            //The salt from the databse is added to the password from the database.
                            $saltAndPassword = $salt . $password;
                            //The salt and password is hashed using md5 and saved into a varaible.
                            $hashedPassword = md5($saltAndPassword);
                            if($hashedPassword == $hash){
                                // Password is correct, so start a new session.
                                session_start();
                                    
                                // Store the data in session variables.
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                if (strtoupper($username) == "ADMIN"){
                                    $_SESSION["isAdmin"] = true;
                                }
                                    
                                // Create connection with our seccureappsdb database.
                                $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
                                // Check connection and print error message if it fails.
                                if (!$link) {
                                die("Connection failed: " . mysqli_connect_error());
                                }
                                
                                //If connection is established insert the data into the admin table using the sql statement.
                                $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome)
                                        VALUES ('$username', '$date', '$ip', '$userAgent', 'Login', 'Succesfull')";
                                    
                                //Error message if the sql query fails.
                                if (!mysqli_query($link, $sql)) {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($link2);
                                }
                                
                                header("location: MainMenu.php");
                                
                            } else{
                                // Create connection with our seccureappsdb database.
                                $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
                                // Check connection and print error message if it fails.
                                if (!$link) {
                                die("Connection failed: " . mysqli_connect_error());
                                }

                                // If connection is established insert the data into the admin table using the sql statement.
                                $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                                        VALUES ('$username', '$date', '$ip', '$userAgent', 'Login', 'Unsuccesfull', 'Wrong Username/Password')";
                                    
                                // Error message if the sql query fails.
                                if (!mysqli_query($link, $sql)) {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($link2);
                                }

                                // Display an error message if password is not valid. This error message is kept generic not to give information to an attacker.
                                $errorMsg = "The username " . $username . " and password can not be authenticated at the moment.";
                                // Increment the session counter.
                                $_SESSION['counter']++;
                            }
                        }
                    } else{
                        // Create connection with our seccureappsdb database.
                        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
                        // Check connection and print error message if it fails.
                        if (!$link) {
                        die("Connection failed: " . mysqli_connect_error());
                        }

                        //If connection is established insert the data into the admin table using the sql statement.
                        $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                            VALUES ('$username', '$date', '$ip', '$userAgent', 'Login', 'Unsuccesfull', 'Wrong Username/Password')";
                            
                        //Error message if the sql query fails.
                        if (!mysqli_query($link, $sql)) {
                            echo "Error: " . $sql . "<br>" . mysqli_error($link2);
                        }

                        // Display an error message if username doesn't exist. This error message is kept generic not to give information to an attacker.
                        $errorMsg = "The username " . $username . " and password can not be authenticated at the moment.";
                        // Increment the session counter.
                        $_SESSION['counter']++;
                    }
                } else{
                    echo "An error has occured. Please try again.";
                    $_SESSION['counter']++;
                }
                    
                // Close statement.
                mysqli_stmt_close($statement);
            }
        }
            
        // Close connection.
        mysqli_close($link2);
        mysqli_close($link);
    }
}
//If the user log in fails redirect to the Locked Page and log the user out. 
else{
    header("location: LockedPage.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <title>Login</title>
	<link rel="stylesheet" type="text/css" href="Style2.css">   <!-- Link to the style Sheet -->  
    <script type = "text/javascript" src="Functions.js"></script> <!-- Link to the javaScript file Sheet --> 
</head>

<body>
    <!-- When the form is submitted the ReomoveXSS function is called to check for and protect against any XSS attacks --> 
	<form class="Container" method="post" action="<?php echo RemoveXSS($_SERVER["PHP_SELF"]); ?>">
        <h1>Login</h1>
		<input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>">
        <span> <?php echo $usernameErrorMsg; ?></span>
		
		<input type="password" name="password" id="password" placeholder="Password"  value="<?php echo $password; ?>">
		<span> <?php echo $errorMsg; ?></span>
		
		<input type="checkbox" onclick="showPass()">Show Password
		
		<input type="submit" value="Login">

		<p>Sign Up Here! <a href="SignUp.php">Sign up now</a>.</p>
	</form>
</body>
</html>