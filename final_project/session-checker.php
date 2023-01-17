<?php
	//check if session is existing
	session_start();
	if(!isset($_SESSION['username'])){
		header("location: login.php");
	}
?>