<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - login.php
*/

$file = "login.php";
$date = "10/24/2019";
$description = "login webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

/*require the header.php in login.php*/
require "header.php";
/*calling db connect function and put it in variable*/
$connect = db_connect();
$id = "";
/*check if the status is not empty*/
if (isset($_SESSION['logout_message'])) {
    echo  $_SESSION['logout_message'];
    UNSET($_SESSION['logout_message']);
}

if(isset($_SESSION['unauthorized_access']))
{
echo $_SESSION['unauthorized_access'];
unset($_SESSION['unauthorized_access']);
}

/*check if cookies is exist */
if (isset($_COOKIE['LOGIN_COOKIE'])) {
    $id = $_COOKIE['LOGIN_COOKIE'];
}
/*if the form submiited as post method*/
if (isset($_POST["submit"])) {
	/*validate the username and password has been enteres*/
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $message = "Please input username and the password. ";
    } else {
	/*trim all of the user input*/
        $id = trim($_POST["username"]);
        $pwd = trim($_POST["password"]);
	/*use pg execute to find the record in the database*/
        $login_result = pg_execute($connect, 'user_login', array($id, hash(HASH_ALGORITHM, $pwd)));
        $count = pg_num_rows($login_result);
        if ($count > 0) {
		/*get user type from database*/
            $record_result = pg_execute($connect, 'user_get_type', array($id));
	    $row = pg_fetch_assoc($record_result);
            $user_type = $row["user_type"];
            $last_access = $row["last_access"];

            $now = date("Y-m-d", time());
		/*updat user's last access*/
            $update_result = pg_execute($connect, 'user_update', array($now, $id));
		/*set cookies under Login_cookie name*/
            setcookie('LOGIN_COOKIE', $id, time() + COOKIE_LIFESPAN);

	    $_SESSION['user_id'] = $id;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['last_access'] = $last_access;
            $message = "Login Success";
		/*the appropiate comments to show to the user depend on the user types*/
            if ($_SESSION['user_type'] == PENDING) {
                $message = "You account have not been approved yet";
            } elseif ($_SESSION['user_type'][0] == DISABLED) {
                $_SESSION['unauthorized_access'] = "Your account has been suspended due to violation of our Acceptable Use Policy!";
		header("location:aup.php");
                ob_flush();
            } elseif ($_SESSION['user_type'][0] == INCOMPLETE) {
		//incomplete user register, link to complete the registeration
		header("location:register.php?status=incomplete");
		ob_flush();
	    } elseif ($_SESSION['user_type'][0] != DISABLED) {
		$greeting_info_result = pg_execute($connect, 'greeting_info', array($id));
		$greeting_info_row = pg_fetch_assoc($greeting_info_result);

		$salutation = $greeting_info_row["salutation"];
		$first_name = $greeting_info_row["first_name"];
		$last_name = $greeting_info_row["last_name"];
		
		$_SESSION['salutation'] = $salutation;
		$_SESSION['first_name'] = $first_name;
		$_SESSION['last_name'] = $last_name;

                if ($_SESSION['user_type'] == ADMIN) {
                    header("location:admin.php?status=loggedin");
                    ob_flush();
                } elseif ($_SESSION['user_type'] == AGENT) {
                    header("location:dashboard.php?status=loggedin");
                    ob_flush();
                } elseif ($_SESSION['user_type'] == CLIENT||$_SESSION['user_type'] == PENDING.AGENT) {
                    header("location:welcome.php?status=loggedin");
                    ob_flush();
                }
	    }
        } else {
            $id = "";
            $message = "Enter a valid username with a correct password";
        }
    }
}
?>
<p><?php 
//showing the message variable if there is any
echo $message; 
?></p>
<h2>Please log in</h2>
<h4>Enter your username and password to connect to this system</h4>
<!-- form for user login to be sent out as post and to the same pages -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
	<table align="center">
		<tr>
			<td><b>Login ID</b></td>
			<td><input type="text" name="username" id="username" value="<?php echo $id; ?>" size="20" /></td>
		</tr>
			
		<tr>
			<td><b>Password</b></td>
			<td><input type="password" name="password" id="password" size="15" /></td>
		</tr>
			
		<tr>
			<td colspan="2">
				<button type="submit" name="submit" value="Log In">Log In</button>
				<button type="reset" name="reset" value="Reset">Reset</button>
			</td>
		</tr>
	</table>
</form> 
<?php include ("footer.php"); ?>