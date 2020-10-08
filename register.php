<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 29 October 2019
	WEB3201 - OVO - register.php
*/

$file = "register.php";
$date = "10/30/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require ("./header.php");

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

if(isset($_SESSION['user_type'])){
	if($_SESSION['user_type']==CLIENT || $_SESSION['user_type']==ADMIN || $_SESSION['user_type']==AGENT || $_SESSION['user_type']==PENDING.AGENT){
		$_SESSION['unauthorized_access'] = "You are logged in and unable to create a new user ";
		header("location:update.php");
		ob_flush();
	}
}

if($_SESSION['user_id']!=""){
	$user_id = $_SESSION['user_id'];//In the session
}else{
	//Not valid user id
	$user_id="";
	$error = "Invalid ID. ";
	$_SESSION['unauthorized_access'] = "You have to fill out this form before going to the next one. ";
	header("location:register-user.php");
	ob_flush();
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
	//$user_id = "";//In the session
	$salutations = "";
	$first_name = "";
	$last_name = "";
	$street_address1 = "";
	$street_address2 = "";
	$city = "";
	$province = "";
	$postal_code = "";
	$primary_phone_number = "";
	$secondary_phone_number = "";
	$fax_number = "";
	$preferred_contact_method = "";
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$error = "";
	$salutations = trim($_POST['salutations']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$street_address1 = trim($_POST['street_address1']);
	$street_address2 = trim($_POST['street_address2']);
	$city = trim($_POST['city']);
	$province = trim($_POST['provinces']);

	$postal_code = trim($_POST['postal_code']);
	$postal_code = str_replace(' ','',$postal_code);

	$primary_phone_number = trim($_POST['primary_phone_number']);
	$secondary_phone_number = trim($_POST['secondary_phone_number']);
	$fax_number = trim($_POST['fax_number']);
	
	if(isset($_POST['preferred_contact_methods'])){
		$preferred_contact_method = trim($_POST['preferred_contact_methods']);
	}else{
		$error.="Please enter your preferred contact method. ";
		$preferred_contact_method = "";
	}

	$connect = db_connect();

	if ($first_name == "") {
        	$error.= "You must enter your first name. ";
	} else if (strlen($first_name) > MAX_FIRST_NAME_LENGTH) {
        	$error.= "The maximum first name length is " . MAX_FIRST_NAME_LENGTH . ". ";
        	$first_name = "";
    	}
     
	if ($last_name == "") {
        	$error.= "You must enter your last name. ";
    	} else if (strlen($last_name) > MAX_LAST_NAME_LENGTH) {
    		$error.= "The maximum last name length is " . MAX_LAST_NAME_LENGTH . ". ";
    		$last_name = "";
	}
    
	if ($street_address1 == "") {
        	$error.= "You must enter your primary street address. ";
    	} else if (strlen($street_address1) > MAX_STREET_ADDRESS_LENGTH) {
        	$error.= "The maximum primary street address length is " . MAX_STREET_ADDRESS_LENGTH . ". ";
        	$street_address1 = "";
    	}
	
    	if (strlen($street_address2) > MAX_STREET_ADDRESS_LENGTH) {
    		$error.= "The maximum secondary street address length is " . MAX_STREET_ADDRESS_LENGTH . ". ";
        	$street_address2 = "";
    	}

    	if ($city == "") {
    		$error.= "You must enter your city. ";
    	} else if (strlen($city) > MAX_CITY_LENGTH) {
        	$error.= "The maximum city length is " . MAX_CITY_LENGTH . ". ";
        	$city = "";
    	}

    	if ($postal_code == "") {
        	$error.= "You must enter your postal code. ";
    	} else if (strlen($postal_code) != MAX_POSTAL_CODE_LENGTH) {
        	$error.= "Postal code length should be " . MAX_POSTAL_CODE_LENGTH . ". ";
        	$postal_code = "";
    	} else if(is_valid_postal_code($postal_code)==0) {
		$error.= "Postal code that you enter is not valid. ";
		$postal_code = "";
    	}

    	if ($primary_phone_number == "") {
        	$error.= "You must enter your primary phone number.";
    	} else if (!is_numeric($primary_phone_number)) {
        	$error.= "Primary phone number should only contain numeric value. ";
        	$primary_phone_number = "";
    	} else if (strlen($primary_phone_number) < MIN_PHONE_NUMBER_LENGTH) {
        	$error.= "The minimum primary phone number length is " . MIN_PHONE_NUMBER_LENGTH . ". ";
        	$primary_phone_number = "";
    	} else if (strlen($primary_phone_number) > MAX_PHONE_NUMBER_LENGTH) {
        	$error.= "The maximum primary phone number length is " . MAX_PHONE_NUMBER_LENGTH . ". ";
        	$primary_phone_number = "";
    	}

    	if (strlen($primary_phone_number) < MIN_PHONE_NUMBER_LENGTH) {
        	$error.= "The minimum secondary phone number length is " . MIN_PHONE_NUMBER_LENGTH . ". ";
        	$secondary_phone_number = "";
    	} else if (strlen($secondary_phone_number) > MAX_PHONE_NUMBER_LENGTH) {
        	$error.= "The maximum secondary phone number length is " . MAX_PHONE_NUMBER_LENGTH . ". ";
        	$secondary_phone_number = "";
    	} else if (!is_numeric($secondary_phone_number) && $secondary_phone_number!="") {
        	$error.= "Secondary phone number should only contain numeric value. ";
        	$secondary_phone_number = "";
    	}

    	if (strlen($fax_number) > MAX_PHONE_NUMBER_LENGTH) {
        	$error.= "The maximum fax number length is " . MAX_PHONE_NUMBER_LENGTH . ". ";
        	$fax_number = "";
	} else if (!is_numeric($fax_number) && $fax_number!="") {
        	$error.= "Fax phone number should only contain numeric value. ";
        	$fax_number = "";
	}

	if ($error == "") {
		$connect = db_connect();
		date_default_timezone_set("Canada/Newfoundland");
		$now = date("Y-m-d", time());
	
		//echo $user_id . " " . $salutations . " " . $first_name . " " . $last_name . " " . $street_address1 . " " . $street_address2 . " " . $city . " " . $province . " " . $postal_code . " " . $primary_phone_number . " " . $secondary_phone_number . " " . $fax_number . " " . $preferred_contact_method;
		$insert_result = pg_execute($connect, 'persons_insert', array($user_id, $salutations,$first_name,$last_name,$street_address1,$street_address2,$city,$province,$postal_code,$primary_phone_number,$secondary_phone_number,$fax_number,$preferred_contact_method));
		echo ' Register ' . $user_id . 'successful';
	
		$user_type=$_SESSION['user_type'];
		if($user_type==INCOMPLETE.AGENT){
			$user_type=PENDING.AGENT;
		}else if($user_type==INCOMPLETE.CLIENT){
			$user_type=CLIENT;
		}

		$user_type_update_sql = "UPDATE users SET user_type = $1 WHERE user_id = $2;";
		$user_type_update_prepare = pg_prepare($connect, 'user_type_update_incomplete', $user_type_update_sql);
		$user_type_update_result = pg_execute($connect, 'user_type_update_incomplete', array($user_type,$user_id));
	
		$_SESSION['unauthorized_access'] = "Registration success !";
		$_SESSION['user_type'] = $user_type;
	
		$record_result = pg_execute($connect, 'user_get_type', array($user_id));
		$row = pg_fetch_assoc($record_result);
		$last_access = $row["last_access"];
	
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

	}else {
		echo "<center><b>" . $error . "</b></center>";
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
                		<td><label>Salutations:</label></td>
                		<td><?php $salutations=build_simple_dropdown("salutations",$salutations); echo $salutations;?></td>
        		</tr>
			<tr>
                		<td><label for="first_name">First Name:</label></td>
                		<td><input type="text" name="first_name" class="input1" id="first_name" value="<?php echo $first_name;?>"/></td>
        		</tr>
			<tr>
                		<td><label for="last_name">Last Name:</label></td>
                		<td><input type="text" name="last_name" class="input1" id="last_name" value="<?php echo $last_name;?>"/></td>
        		</tr>       
			<tr>
	        		<td><label for="street_address1">Primary Street Address: </label></td>
	        		<td><input type="text" name="street_address1" class="input1" id="street_address1" value="<?php echo $street_address1;?>"/></td>
	      		</tr>
			<tr>
	        		<td><label for="street_address2">Seconday Street Address: </label></td>
	        		<td><input type="text" name="street_address2" class="input1" id="street_address2" value="<?php echo $street_address2;?>"/></td>
	      		</tr>
	      		<tr>
      				<td><label for="city">City: </label></td>
      				<td><input type="text" name="city" class="input1" id="city" value="<?php echo $city;?>"/></td>
			</tr>
    			<tr>
    				<td><label for="province">Province: </label></td>
    				<td><?php $province=build_simple_dropdown("provinces",$province); echo $province;?></td>
    			</tr>
			<tr>
    				<td><label for="postal_code">Postal Code: </label></td>
    				<td><input type="text" name="postal_code" class="input1" id="postal_code" value="<?php echo $postal_code;?>"/></td>
    			</tr>
    			<tr>
    				<td><label for="primary_phone_number">Primary Phone Number: </label></td>
    				<td><input type="text" name="primary_phone_number" class="input1" id="primary_phone_number" value="<?php echo $primary_phone_number;?>"/></td>
    			</tr>
			<tr>
    				<td><label for="secondary_phone_number">Secondary Phone Number: </label></td>
    				<td><input type="text" name="secondary_phone_number" class="input1" id="secondary_phone_number" value="<?php echo $secondary_phone_number;?>"/></td>
    			</tr>
			<tr>
    				<td><label for="fax_number">Fax Number: </label></td>
    				<td><input type="text" name="fax_number" class="input1" id="fax_number" value="<?php echo $fax_number;?>"/></td>
    			</tr>
			<tr>
    				<td><label for="preferred_contact_method">Preferred Contact Method: </label></td>
    				<td><?php $preferred_contact_method=build_radio(PREFERRED_CONTACT_METHOD,$preferred_contact_method); echo $preferred_contact_method;?></td>
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


