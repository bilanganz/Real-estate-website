<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - change-password.php
*/

$file = "change-password.php";
$date = "10/24/2019";
$description = "change password page for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing ♥";
require_once ("./header.php");

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

if($_SESSION['user_type']!=CLIENT && $_SESSION['user_type']!=ADMIN && $_SESSION['user_type']!=AGENT && $_SESSION['user_type']!=PENDING.AGENT){

	$_SESSION['unauthorized_access'] = "You are have no permission to access " . $file;
	header("location:login.php");
	ob_flush();

}else {	//its an admin or a client or agent or an client

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$current_password = "";
	$new_password = "";
	$conf_password = "";
	$error = "";
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$error = "";
	$current_password = trim($_POST['current_password']);
	$new_password = trim($_POST['new_password']);
	$conf_password = trim($_POST['confirm_new_password']);
	
	if ($current_password == "") {
        	$error.= "You must enter your current password. ";
    	}
 
	if (strlen($new_password) == 0) {
        	$error.= "You must enter a password. ";
    	} else if (strlen($new_password) > MAX_PASSWORD_LENGTH) {
        	$error.= "The maximun password length is " . MAX_PASSWORD_LENGTH . ". ";
    	} else if (strlen($new_password) < MIN_PASSWORD_LENGTH) {
        	$error.= "The minimun password length is " . MIN_PASSWORD_LENGTH . ". ";
        	$new_password = "";
    	}
    
	if ($new_password != $conf_password) {
        	$error.= "Passwords doesn't match. ";
    	}

	$user_id = $_SESSION['user_id'];

	/*use pg execute to find the record in the database*/
	$record_result = pg_execute($connect, 'user_login', array($user_id, hash(HASH_ALGORITHM, $current_password)));
	$count = pg_num_rows($record_result);
	if ($count > 0) {
		if ($new_password == $current_password) {
        		$error.= "Your old password can't be the same with your new password. ";
    		}

		if ($error=="") {
			$password = hash($hash_algorithm, $new_password);
			$record_result = pg_execute($connect, 'password_update', array(hash(HASH_ALGORITHM, $new_password),$user_id));
	
			$_SESSION['unauthorized_access'] = "Change Password success !";
			$user_type = $_SESSION['user_type'];
	
			$record_result = pg_execute($connect, 'user_get_type', array($user_id));
			$row = pg_fetch_assoc($record_result);
			$salutation = $row["salutation"];
			$last_access = $row["last_access"];
	
			$greeting_info_result = pg_execute($connect, 'greeting_info', array($user_id));
			$greeting_info_row = pg_fetch_assoc($greeting_info_result);
	
			$salutation = $greeting_info_row["salutation"];
			$first_name = $greeting_info_row["first_name"];
			$last_name = $greeting_info_row["last_name"];
	
			$_SESSION['salutation'] = $salutation;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['last_access'] = $last_access;
			if ($user_type == ADMIN) {
				header("location:admin.php?status=loggedin");
			        ob_flush();
			} elseif ($user_type == AGENT) {
				header("location:dashboard.php?status=loggedin");
				ob_flush();
			} elseif ($user_type == PENDING.AGENT) {
				header("location:welcome.php?status=loggedin");
				ob_flush();
			} elseif ($user_type == CLIENT) {
				header("location:welcome.php?status=loggedin");
				ob_flush();
			}
		}else{
			echo $error;
		}
	}else{
		$error .= "Your current password is incorrect. ";
		echo "<center><b>" . $error . "</b></center>";
	}

}

?>

<form action="change-password.php" method="post" enctype="multipart/form-data">
	<div id="bg">
		<div id="img">
			<img src="./image/logo2.jpg" width="400" height="200" alt="OVO Logo"/>      
		</div>
		<div id="reg">
			<table width="900px">
		 		<tr>
					<td colspan="2"><b>Change Password</b></td>
				</tr>
        	    		<tr>
        	      			<td class="tt" width="200"><label for="current_password">Current Password</label></td>
        	        		<td class="tt" width="400"><input type="password" name="current_password" class="input1" id="current_password"/></td>
        	      		</tr>
				<tr>
        	      			<td class="tt" width="200"><label for="new_password">New Password</label></td>
        	        		<td class="tt" width="400" ><input type="password" name="new_password" class="input1" id="new_password"/></td>
        	      		</tr>
        			<tr>
        				<td class="tt" width="200"><label for="confirm_new_password">Confirm New Password</label></td>
        				<td class="tt" width="400" ><input type="password" name="confirm_new_password" class="input1" id="confirm_new_password"/></td>
        			</tr>
    				<tr>
    					<td class="tt" colspan="2" align="center"><input type="submit" name="sm" class="bt" value="Change Password"/>
    					<input type="reset" name="cancel" class="bt" value="Cancel"/></td>
    				</tr>
   			</table>
		</div>
	</div>
</form>

<?php
}//end if of type of user

require_once './footer.php'; 
?>
