<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - logout.php
*/
$file = "logout.php";
$date = "10/24/2019";
$description = "login webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

/*echoing the log out message*/
echo "You have been logged out!";
/*unseting the session and destroy session*/
session_start();
session_unset();
unset($_SESSION);
session_destroy();
/*direct user to login.php*/

session_start();
$_SESSION['logout_message']="You have been logged out!";
header("location:login.php?status=loggedout");
/*calling ob flush*/
ob_flush();
exit();

?>