<!-- 
	 Name of Work Unit:  CSRF.php.
	 Purpose of Work Unit:  Generates a CSRF Token.
	 Author: Peter Lucan	Student Number: C00228946	Date: 15/03/2021
	 Description: This page gennerates a token to be used for CSRF protection and stores it in a session variable.
-->

<?php
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>