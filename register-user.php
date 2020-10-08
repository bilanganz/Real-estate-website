<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - register.php
*/

$file = "register.php";
$date = "10/24/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require ("./header.php");

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

if(isset($_SESSION['user_type'])){

	if($_SESSION['user_type']==CLIENT || $_SESSION['user_type']==ADMIN || $_SESSION['user_type']==AGENT|| $_SESSION['user_type']==PENDING.AGENT){
		//$_SESSION['unauthorized_access'] = "You are logged in and unable to create a new user ";
		header("location:welcome.php");
		ob_flush();
	}
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$user_id="";
	$password="";
	$conf_password="";
	$user_type=INCOMPLETE.CLIENT;//default
	$email_address="";
	$enrol_date="";
	$last_access="";
	$error="";
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_POST["submit"])) {
		$error = "";
		$user_id = trim($_POST['user_id']);
		$password = trim($_POST['password']);
		$conf_password = trim($_POST['conf_password']);
		$user_type = trim($_POST['user_type']);
		$email_address = trim($_POST['email_address']);
		
		if ($user_id == "") {
        		$error.= "You must enter an user ID. ";
		} else if (strlen($user_id) < 0) {
        		$error.= "The minimum ID length is " . MIN_USER_ID_LENGTH . ". ";
        		$user_id = "";
		} else if (strlen($user_id) > MAX_USER_ID_LENGTH) {
        		$error.= "The maximum ID length is " . MAX_USER_ID_LENGTH . ". ";
        		$user_id = "";
		} else if (is_user_id($user_id)) {
			$error = "User ID already exists. ";
		}

		if (strlen($password) == 0) {
			$error.= "You must enter a password. ";
    		} else if (strlen($password) > MAX_PASSWORD_LENGTH) {
        		$error.= "The maximum password length is " . MAX_PASSWORD_LENGTH . ". ";
			$password = "";
		} else if (strlen($password) < MIN_PASSWORD_LENGTH) {
			$error.= "The minimum password length is " . MIN_PASSWORD_LENGTH . ". ";
			$password = "";
		} else if ($password != $conf_password) {
			$error.= "Passwords doesn't match. ";
			$password ="";
			$conf_password="";
    		}
	
		if($user_type==AGENT||$user_type==CLIENT){
			$user_type = substr_replace($user_type, INCOMPLETE, 0, 0 );
	    	}
	
	    	/*
	    	if (pg_num_rows(pg_query("SELECT email_address FROM users WHERE email_address='$email_address'")) > 0) {
	    	    $error = "Email already exists. ";
	    	} else 
	    	*/
		if (strlen($email_address) == 0) {
			$error.= "You must enter an email address. ";
		} else if (strlen($email_address) > MAX_EMAIL_LENGTH) {
			$error.= "The maximum email length is " . MAXIMUM_EMAIL_LENGTH;
		} else if (is_valid_email($email_address)==0) {
			$error.= "<em>" . $email_address . "</em> is not a valid email address. ";
			$email = "";
		}
	
		if ($error == "") {
			$connect = db_connect();
	   		date_default_timezone_set("Canada/Newfoundland");
			$now = date("Y-m-d", time());

			//echo $user_id . " " . $password . " " . $user_type . " " . $email_address . " " . $now . " " . $now;
			$insert_result = pg_execute($connect, 'users_insert', array($user_id, $password, $user_type, $email_address, $now, $now));
			echo ' Register ' . $user_id . 'successful';
			$_SESSION['user_id'] = $user_id;
			$_SESSION['user_type'] = $user_type;
		        header("Location:./register.php");
			ob_flush();
		}else {
			echo "<center><b>" . $error . "</b></center>";
		}

	}

}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<div id="bg">
	<div id="img">
		<img src="./image/logo2.jpg" width="400" height="200" alt="OVO Logo"/>
	</div>
		<table align="center">
            		<tr>
				<td><label for="user_id">User ID: </label></td>
				<td><input type="text" name="user_id" class="input1" id="user_id" value="<?php echo $user_id;?>"/></td>
			</tr>
			<tr>
				<td><label for="password">Password: </label></td>
				<td><input type="password" name="password" class="input1" id="password" /></td>
			</tr>
			<tr>
				<td><label for="confirm_password">Confirm Password:</label></td>
				<td><input type="password" name="conf_password" class="input1" id="confirm_password" /></td>
			</tr>
			<tr>
    				<td><label for="email">Email Address: </label></td>
    				<td><input type="text" name="email_address" class="input1" id="email" value="<?php echo $email_address;?>" /></td>
    			</tr>
			<tr>
				<td><label>You want to register as:</label></td>
				<td>
					<input type="radio" name="user_type" value=<?php echo "'" . CLIENT . "'"; ?> <?php if(strpos($user_type,CLIENT)) {?> checked="checked" <?php } ?>/> CLIENT
					<input type="radio" name="user_type" value=<?php echo "'" . AGENT . "'"; ?> <?php if(strpos($user_type,AGENT)) {?> checked="checked" <?php } ?> /> AGENT
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" class="bt" value="Register"/>
				<input type="reset" name="cancel" class="bt" value="Cancel"/></td>
			</tr>
		</table>
	</div>
</form>
<?php
require './footer.php';
?>


