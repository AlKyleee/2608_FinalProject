<?php
/* Database credentials.*/
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'kyle');
define('DB_PASSWORD', '1234');
define('DB_NAME', 'ics2608');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>