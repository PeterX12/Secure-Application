<!-- 
	 Name of Work Unit:  db.include.php
	 Purpose of Work Unit:  Creates the database, the tables and any necessary data.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: Configures the projects database so it can work from any computer.
-->

<?php
/* Database credentials. For running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

//Hash admins password here
$salt = "";
$saltAndPassword = "";
$hashedPassword = "";
$password = "SAD_2021!";

//Generating the salt and pre pending it to the password and then hashing the two.
$salt = uniqid(mt_rand(), true);
$saltAndPassword = $salt . $password;
$hashedPassword = md5($saltAndPassword);

/* Establish a link to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
 
// Check connection and print error message if it fails.
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Make seccureappsdB the current database
$db_selected = mysqli_select_db($link, 'seccureappsdb');

if (!$db_selected) {
  // If we couldn't, then it either doesn't exist, or we can't see it.
  $sql = 'CREATE DATABASE IF NOT EXISTS seccureappsdb';

  //Error message if the sql query fails.
  if (!mysqli_query($link, $sql)) {
    echo 'Error creating database: ' . mysqli_error('seccureappsdb') . "\n";
  }
}

// Create connection with our seccureappsdb database
$link2 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, "seccureappsdb");
// Check connection and print error message if it fails.
if (!$link2) {
  die("Connection failed: " . mysqli_connect_error());
}

// sql to create table called users for seccureappsdb if it does not exist
$sql2 = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 " ;

//Error message when the table cannot be created due to an error
if (!mysqli_query($link2, $sql2)) {
  echo "Error creating table: " . mysqli_error($link2);
}

//Inserts the admin with a hashed passwrod and their salt into the database when it is first created if it does not exist
$sql3 = "INSERT IGNORE INTO users (username, hash, salt)
VALUES ('ADMIN', '$hashedPassword', '$salt')";

//Error message if the user cannot be created if it doesn't already exist
if (!mysqli_query($link2, $sql3)) {
  echo "Error: " . $sql3 . "<br>" . mysqli_error($link2);
}

// sql to create table called admin for seccureappsdb if it does not already exist. 
$sql4 = "CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `datetime` datetime(0) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `outcome` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 " ;

//Error message if the table does not exist and cannot be created
if (!mysqli_query($link2, $sql4)) {
  echo "Error creating table: " . mysqli_error($link2);
}

//Close the connection
mysqli_close($link);
?>
