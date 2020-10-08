<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - header.php
*/
/*require all of the needed php pages*/
require_once './includes/constants.php';
require_once './includes/db.php';
require_once './includes/functions.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/*calling ob start*/
ob_start();
/*if session id is nothing*/
if (session_id() == "") {
	session_start();
}

$message = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
<!--
	Name: Group 8 
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	File: <?php echo $file . "\n"; ?>
	Date: <?php echo $date . "\n"; ?>
	Description: <?php echo $description . "\n"; ?>
-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title><?php echo $title ?></title>
<link rel ="icon" href="./image/logo3.jpg"/>
<link rel="stylesheet" type="text/css" href="./css/webd3201.css"/>
</head>
<body>
<!-- 
This is to remove $_GET from the url 
credit to : Sanne 
Get from :https://stackoverflow.com/questions/13789231/remove-get-parameter-in-url-after-processing-is-finishednot-using-post-php/13789628
<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>

-->


<div class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><img src="./image/logo3.jpg" alt="OVO Logo" width="90" height="60"/></a>
    </div>
    <ul class="nav navbar-nav">
	  <?php 
		/*if the user type is pending or disable*/
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != PENDING && $_SESSION['user_type'][0] != DISABLED && $_SESSION['user_type'][0] != INCOMPLETE) { ?>
		  <li><a href="logout.php">Log Out</a></li>
		  <li><a href="update.php">Update</a></li>
		  <li><a href="change-password.php">Change Password</a></li>
		  <?php /*if the user type is admin*/
			if ($_SESSION['user_type'] == ADMIN) { ?>
			<li><a href="admin.php">Admin Homepage</a></li>
			<li><a href="pending-users.php">Pending Users</a></li>
			<li><a href="disabled-users.php">Disabled Users</a></li>
			<li><a href="offense-listing.php">Offensive Listing</a></li>
			<!--<li><a href="dashboard.php">Dashboard Homepage</a></li>
			<li><a href="listing-create.php">Listing Create</a></li>
			<li><a href="listing-update.php">Listing Update</a></li>
			<li><a href="welcome.php">Welcome Homepage</a></li>-->
		  <?php /*if the user type is agent*/
    			} elseif ($_SESSION['user_type'] == AGENT) { ?>
			<li><a href="dashboard.php">Dashboard Homepage</a></li>
			<li><a href="listing-create.php">Listing Create</a></li>
			<li><a href="old-listing.php">Old Listing</a></li>
			<!--<li><a href="listing-update.php">Listing Update</a></li>-->
		  <?php /*if the user type is client*/
    			} elseif ($_SESSION['user_type'] == CLIENT || $_SESSION['user_type'] == PENDING.AGENT) { ?>
			<li><a href="welcome.php">Welcome Homepage</a></li>
		  <?php /*listing all of the pages for client*/
    			} ?>
		<!--<li><a href="listing-display.php">Listing Display</a></li>-->
		<li><a href="listing-select-city.php">Listing Search</a></li>
		<li><a href="listing-matches.php">Listing Search Result</a></li>
	  <?php
		} else {
		/*listing all of the pages on header if the user has not yet successfully log in*/
	 ?>
		<li><a href="register-user.php">Register</a></li>
		<li><a href="password-request.php">Forget password</a></li>
		<li><a href="login.php">Login</a></li>
		<li><a href="listing-select-city.php">Listing Search</a></li>
	  <?php
} ?>
    </ul>
  </div>
</div>
