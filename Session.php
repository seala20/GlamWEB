<?php
// start the session
session_start();
// if the user is already logged in, then redirect user to welcome page
if(isset($_SESSION['user_name']))
{
	header('location: welcome.php');
    exit;
}
?>
