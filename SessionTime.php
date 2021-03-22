<!-- 
	 Name of Work Unit:  SessionTime
	 Purpose of Work Unit:  Enables the User to log in to our web application.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page lets the user log in. The user is allowed 5 attempts to log in and if they fail to do so are kicked out.
-->

<?php
if (isSet($_SESSION['started'])){
    if((mktime() - $_SESSION['started'] - 3600) > 0){
        header("Refresh:0; url=Logout.php");
    }
}
else {
    $_SESSION['started'] = mktime();
}
?>