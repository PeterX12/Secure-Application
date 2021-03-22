<!-- 
	 Name of Work Unit:  SignUp.php
	 Purpose of Work Unit:  Enables the User to Register/SignUp for our web application.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This is page allows the user to sign up into our secure web application.
-->

<?php 
// Include the file that creates the underlying database and also the utility functions.
include 'db.include.php';
include 'Utility.php';

//Defined Variables that will be used and set to empty strings.
$username = "";
$password = "";
$password2 = "";
$salt = "";
$saltAndPassword = "";
$hashedPassword = "";
$usernameErrorMsg = "";
$passwordErrorMsg = "";
$password2ErrorMsg = "";

//Save the user agent and ip addreess into variables.
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];

//Set the default timezone and save the current time into a variable.
date_default_timezone_set('Europe/London');
$date = date('Y/m/d H:i:s');


//Once the form is submitted process it's data.
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //Check if the username is already taken and validate it
  if(empty(trim($_POST["username"]))){
    $usernameErrorMsg = "Please enter a username.";

    // Create connection with our seccureappsdb database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
    // Check the connection and print error message if it fails.
    if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
    }

    //If connection is established insert the data into the admin table using the sql statement.
    $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
            VALUES ('$username', '$date', '$ip', '$userAgent', 'Sign Up', 'Unsucessful', 'No Username/Password/Confrim Password Entered')";
    
    //Error message if the sql query fails. 
    if (!mysqli_query($link, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($link2);
    }
  }
  else{
    //If connection is established retrieve the data using the sql statement.
    $sql = "SELECT id FROM users WHERE username = ?";
    
    if($statement = mysqli_prepare($link2, $sql)){
        //Bind variables to the prepared statement as parameters.
        mysqli_stmt_bind_param($statement, "s", $paramUsername);
        
        //Set the parameters.
        $paramUsername = trim($_POST["username"]);

        //Execute the prepared statement.
        if(mysqli_stmt_execute($statement)){
          //Store the result
          mysqli_stmt_store_result($statement);
          
          //Check if the username is avaible and if it is display an error message. Otherwise create the user.
          if(mysqli_stmt_num_rows($statement) == 1){
              $usernameErrorMsg = "This username is already taken.";

              // Create connection with our seccureappsdb database.
              $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
              // Check the connection and print error message if it fails.
              if (!$link) {
              die("Connection failed: " . mysqli_connect_error());
              }

              //If connection is established insert the data into the admin table using the sql statement.
              $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
                      VALUES ('$username', '$date', '$ip', '$userAgent', 'Sign Up', 'Unsucessful', 'Username Already Taken')";
              
              //Error message if the sql query fails. 
              if (!mysqli_query($link, $sql)) {
                  echo "Error: " . $sql . "<br>" . mysqli_error($link2);
              }
          } else{
              $username = trim($_POST["username"]);
          }
      } else{
          echo "An error has occured. Please try again.";
      }

      // Close the statement.
      mysqli_stmt_close($statement);
    }
  }

  //Validate the password.
  if(empty(trim($_POST["password"]))){
    $passwordErrorMsg = "Please enter a password.";

    // Create connection with our seccureappsdb database.
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
    // Check the connection and print error message if it fails.
    if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
    }

    //If connection is established insert the data into the admin table using the sql statement.
    $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
            VALUES ('$username', '$date', '$ip', '$userAgent', 'Sign Up', 'Unsucessful', 'No Username/Password/Confrim Password Entered')";
    
    //Error message if the sql query fails. 
    if (!mysqli_query($link, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($link2);
    }
  }
  //Check if the password is less than 8 characters.
  elseif(strlen(trim($_POST["password"])) < 8){
    $passwordErrorMsg = "Password must be at least 8 characters.";

    // Create connection with our seccureappsdb database.
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
  //Check if the password contains at least one upper case char.
  elseif(!preg_match('@[A-Z]@',trim($_POST["password"]))){
    $passwordErrorMsg = "Password must contain at least one Upper Case Character";
    
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
  //Check if the password contains at least one lower case char.
  elseif(!preg_match('@[a-z]@',trim($_POST["password"]))){
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
  //Check if the password contains at least one number
  elseif(!preg_match('@[0-9]@',trim($_POST["password"]))){
    $passwordErrorMsg = "Password must contain at least one number";   

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
  //Check if the password contains at least one number
  elseif(!preg_match('@[^\w]@',trim($_POST["password"]))){
    $passwordErrorMsg = "Password must contain at least one Special character";   

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
    $password = trim($_POST["password"]);
  }

  //Now Validate the confirm password field
  if(empty(trim($_POST["password2"]))){
    $password2ErrorMsg = "Please confirm your password.";   
    
    // Create connection with our seccureappsdb database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
    // Check the connection and print error message if it fails.
    if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
    }
    //If connection is established insert the data into the admin table using the sql statement.
    $sql = "INSERT IGNORE INTO admin (username, datetime, ip, useragent, action, outcome, reason)
            VALUES ('$username', '$date', '$ip', '$userAgent', 'Change Password', 'Unsuccesfull', 'No Username/Password/Confrim Password Entered')";
    
    //Error message if the sql query fails. 
    if (!mysqli_query($link, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($link2);
    }
  }
  elseif(empty($password2ErrorMsg) && (trim($_POST["password"]) != trim($_POST["password2"]))){
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
    $password2 = trim($_POST["password2"]);
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
        
    //If connection is established insert the data into the users table using the sql statement.
    $sql = "INSERT INTO users (username, hash, salt) VALUES (?, ?, ?)";
     
    if($statement = mysqli_prepare($link2, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($statement, "sss", $param_username, $param_hashedPassword, $param_salt);
        
        // Set parameters
        $param_username = $username;
        $param_hashedPassword = $hashedPassword;
        $param_salt = $salt;
        
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
                  VALUES ('$username', '$date', '$ip', '$userAgent', 'Sign Up', 'Succesfull')";
          
          //Error message if the sql query fails. 
          if (!mysqli_query($link, $sql)) {
              echo "Error: " . $sql . "<br>" . mysqli_error($link2);
          }

          // Redirect to login page
          session_destroy();
          header("location: Login.php");
        } else{
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($statement);
    }
  }

  //Close connection
  mysqli_close($link2);
  mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="Style2.css">   <!-- Link to style Sheet -->
    <script type = "text/javascript" src="Functions.js"></script>  <!-- Link to javaScript Sheet -->
</head>

<body>
  <!-- When the form is submitted the ReomoveXSS function is called to check for and protect against any XSS attacks --> 
  <form class="Container" method="POST" action="<?php echo RemoveXSS($_SERVER["PHP_SELF"]); ?>">
    <h1>Sign Up</h1>

    <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>">
    <span><?php echo $usernameErrorMsg; ?></span>
          
    <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>">
    <span><?php echo $passwordErrorMsg; ?></span>

    <input type="password" name="password2" id="password2" placeholder="Confirm Password" value="<?php echo $password2; ?>">
    <span><?php echo $password2ErrorMsg; ?></span>

    <input type="checkbox" onclick="showPassAndConfirm()">Show Password

    <input type="submit" value="Create Account">

    <p>Already Signed Up? <a href="Login.php">Login here</a>.</p>
  </form>
</body>
</html>