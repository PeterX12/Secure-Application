<!-- 
	 Name of Work Unit:  LockedPage.php
	 Purpose of Work Unit:  Countdown of 3 minutes before the user is allowed to try and log in once more.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page displays a 3 minute timer and counts down until the user is allowed to try and log in again. The user is redirected
    to this page from every other page until the counter is over.
-->

<?php
//Varaible initialization.
$page = $_SERVER['PHP_SELF'];
$sec = "1";
$msg = "";
$msg2 = "";

//Start the session.
session_start();

//Check to see if our countdown session variable has been set.
if(!isset($_SESSION['countdown'])){
    //If not set the countdown to 180 seconds.
    $_SESSION['countdown'] = 180;
    //Store the timestamp of when the countdown began.
    $_SESSION['time_started'] = time();
}

//If the countdown session variable has been set.
if(($_SESSION['countdown'])){
    //Get the current timestamp.
    $now = time();

    //Calculate how many seconds have passed since the countdown began.
    $timeSince = $now - $_SESSION['time_started'];

    //Calculate how many seconds are remaining.
    $remainingSeconds = abs($_SESSION['countdown'] - $timeSince);

    //Save the countdown messages into variables to be dispalyed in html.
    $msg = "Time Remaining: " . gmdate("H:i:s", $remainingSeconds);
    $msg2 = "There are $remainingSeconds seconds remaining.";
}


//Check if the countdown has finished.
if($remainingSeconds < 1){
    unset($_SESSION['countdown']);
    unset($_SESSION['counter']);
    header("location: Login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <title>Locked Page</title>
	<link rel="stylesheet" type="text/css" href="Style.css">   <!-- Link to style Sheet -->  
</head>
    <body>
    <div class="Container">
		<h1 class="Center">Too Many Login Attempts!</h1>
        <h3 class="Center">You have been locked out for 3 minutes!</h3>
			<div class="Center">
                <span class=""> <?php echo $msg; ?></span>
			</div>
            <div class="Center">
                <span class=""> <?php echo $msg2; ?></span>
            </div>
	</div>
    </body>
</html>