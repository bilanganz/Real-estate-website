<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - register.php
*/

$file = "password-request.php";
$date = "10/24/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require_once 'header.php';

/*
password-request.php
*request new password page, enter user id and email address, check in database if its exist, if its generate random 8character/digits password, update the user password, and draft simple PHP mail()
*/

if(isset($_SESSION['user_type'])){

	if($_SESSION['user_type']==CLIENT || $_SESSION['user_type']==ADMIN || $_SESSION['user_type']==AGENT|| $_SESSION['user_type']==PENDING.AGENT){
		$_SESSION['unauthorized_access'] = "You are logged in and unable to create a new user ";
		header("location:index.php");
		ob_flush();
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET"){
		$user_id="";
		$email_address="";
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
if(isset($_POST['request'])){
	$connect = db_connect();		
	$error = "";
	$user_id = trim($_POST['user_id']);
	$email_address = trim($_POST['email_address']);
	
	//filter email address using fiter_var
	//generate random num
	if(!is_valid_email($email_address)){
		$error .= "Invalid Email Address. ";
		$email_address="";
	}else if($email_validation = pg_execute($connect, 'email_validate', array($user_id,$email_address))<0){
		$error .= "Email not found. ";
		$email_address="";	
	}

	echo "<br/>";
	
	//CHECK USER ID
	//use is_user_id from db.php
	if(!is_user_id($user_id)){
		$error .= "Invalid User ID. ";
		$user_id="";
	}

	if($error==""){
		//GENERATE NEW PASSWORD 
		$password = generatePassword(8);
		
		//UPDATE PASSWORD IN DATABASE
		//$password_update_result = pg_execute($connect, 'update_password', array(md5($password),$user_id,$email_address));
		if($password_update_result = pg_execute($connect, 'update_password', array(md5($password),$user_id,$email_address))){
			$greeting_info_result = pg_execute($connect, 'greeting_info', array($user_id));
			$greeting_info_row = pg_fetch_assoc($greeting_info_result);

			$salutation = $greeting_info_row["salutation"];
			$first_name = $greeting_info_row["first_name"];
			$last_name = $greeting_info_row["last_name"];

			$email_subject = "Password Change Request";
			$email_body .= "<html><body>";
			$email_body .= "<p>Hi " . $salutation . " " . $first_name . " " . $last_name . "</p>";
			$email_body .= "<p>We recieved a request to reset your password for your OVO account, Here is your new password :" . $password . ".</p>";
			$email_body .= "<p>If you did not make this request, please contact your local administrator.<p>";
			$email_body .= "</body></html>";
			mail($email_address,$email_subject,$email_body);		
		
			$_SESSION['unauthorized_access'] = "We have send your password request to your email at:". $email_address . ".";
		}else{
			$_SESSION['unauthorized_access'] = "Failed To Change Password";
		}
		header("location:login.php");
		ob_flush();
	}else{
		echo $error;
	}
}
}
?>
<form action='./password-request.php' method='post'>
	<table>
		<tr>
			<td>User Id</td>
			<td><input type="text" name="user_id" value="<?php echo $user_id; ?>"></td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td><input type="text" name="email_address" value="<?php echo $email_address; ?>"></td>
		</tr>
		<tr>
			<td colspan='2'><input type='submit' value='Request' name='request'></td>
		</tr>
	</table>
</form>

<?php
require_once 'footer.php';
?>