<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - listing-create.php
*/

$file = "listing-create.php";
$date = "10/24/2019";
$description = "listing create webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";
require ("./header.php");

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

if($_SESSION['user_type']!=AGENT && $_SESSION['user_type']!=ADMIN){

$_SESSION['unauthorized_access'] = "You are have no permission to access " . $file;

	if($_SESSION['user_type']==CLIENT){
		header("location:welcome.php?status=loggedin");
        	ob_flush();
	}elseif($_SESSION['user_type']==PENDING.AGENT){
		header("location:welcome.php?status=loggedin");
        	ob_flush();
	}else{
		header("location:login.php");
      		 	ob_flush();
	}
}else { //its an admin or a agent

	if ($_SERVER["REQUEST_METHOD"] == "GET"){
		$error = "";
		$user_id = $_SESSION['user_id'];
		$headline = "";
		$price = "";
		$status = "";
		$description = "";
		$property_type = "";
		$property_options = "";
		$transaction_type = "";
		$building_type = "";
		$heating_type = "";
		$bedrooms = "";
		$bathrooms = "";
		$living_room = "";
		$kitchen = "";
		$basement_feature = "";
		$parking_lot = "";
		$building_size = "";
		$land_size = "";
		$address = "";
		$city = "";
		$postal_code = "";
		$image = "0";//FOR NOW SINCE NO PICTURE
	} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$error = "";
	
		if(isset($_POST['submit'])){
			$price = trim($_POST['price']);
			$headline = trim($_POST['headline']);
			$description = pg_escape_string(trim($_POST['description']));
			$status = trim($_POST['status']);
			$postal_code = trim($_POST['postal_code']);
			$city = trim($_POST['city']);
	
			$sum = array();
			foreach($_POST["property_options"] as $selected){
				$sum[]=$selected;
			}

			$property_options = sum_check_box($sum);
			$property_type = trim($_POST['property_type']);
			$transaction_type = trim($_POST['transaction_type']);
			$building_type = trim($_POST['building_type']);
			$basement_feature = trim ($_POST['basement_feature']);
			$bedrooms = trim($_POST['bedrooms']);
			$bathrooms = trim($_POST['bathrooms']);
			$living_room = trim($_POST['living_room']);
			$building_size = trim($_POST['building_size']);
			$land_size = trim($_POST['land_size']);
			$kitchen = trim($_POST['kitchen']);
			$parking_lot = trim($_POST['parking_lot']);
			$address = trim($_POST['address']);

			$postal_code = trim ($_POST['postal_code']);
			$postal_code = str_replace(' ','',$postal_code);

			$heating_type = trim ($_POST['heating_type']);
			$image = "0";
    			$user_id = $_SESSION['user_id'];
			//echo $user_id. "<br>" .$headline ."<br>". $price . "<br>" . $status . "<br>" . $description . "<br>" . $property_type . "<br>" . $property_options . "<br>" . $transaction_type . "<br>" . $building_type . "<br>" . $heating_type . "<br>" . $bedrooms . "<br>" . $bathrooms . "<br>" . $living_room . "<br>" . $kitchen . "<br>" . $basement_feature . "<br>" . $parking_lot . "<br>" . $building_size . "<br>" . $land_size . "<br>" . $address . "<br>" . $city . "<br>" . $postal_code ;
	
    			if ($headline == "") {
				$error.= "You must enter the headline. ";
			} else if (strlen($headline) > MAX_HEADLINE_LENGTH) {
				$error.= "The maximum headline length is " . MAX_HEADLINE_LENGTH . ". ";
				$headline = "";
			}

			if ($price == "") {
				$error.= "You must enter the house's price.";
			} else if (!is_numeric($price)) {
				$error.= "Price should only contain numeric value.";
				$price = "";
			}

			if ($status == "") {
				$error.= "You must enter the listing status. ";
			}

			if ($transaction_type == "") {
			        $error.= "You must enter the transaction type. ";
			}

			if ($description == "") {
				$error.= "You must enter the description. ";
			} else if (strlen($description) > MAX_DESCRIPTION_LENGTH) {
				$error.= "The maximum description length is " . MAX_DESCRIPTION_LENGTH . ". ";
				$description = "";
			}

			if ($address == "") {
				$error.= "You must enter the house's address. ";
			} else if (strlen($address) > MAX_STREET_ADDRESS_LENGTH) {
				$error.= "The maximum address length is " . MAX_STREET_ADDRESS_LENGTH . ". ";
				$address = "";
			}

			if ($city == "") {
				$error.= "You must enter your city. ";
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

    			if (strlen($error) == 0) {
        			$connect = db_connect();
				$listing = array($user_id,$headline,$price,$status,$description,$property_type,$property_options,$transaction_type,$building_type,$heating_type,$bedrooms,$bathrooms,$living_room,$kitchen,$basement_feature,$parking_lot,$building_size,$land_size,$address,$city,$postal_code,$image);
				//print_r($listing);
				$listing_insert_result = pg_execute($connect, 'listing_insert', $listing);
				
				$min_price = "";
				$max_price = "";
				//$listing_search_sql = build_search_sql($min_price,$max_price,$property_type,$property_options,$transaction_type,$building_type,$heating_type,$bedrooms,$bathrooms,$living_room,$kitchen,$basement_feature,$parking_lot,$building_size,$land_size,$city);
				//echo $listing_search_sql;
				$find_listing_sql = "SELECT listing_id FROM listings WHERE user_id=$1 AND headline=$2 AND price=$3 AND city=$4;";
				$find_listing_prepare = pg_prepare($connect,'find_listing', $find_listing_sql);
				$find_listing_result = pg_execute($connect, 'find_listing', array($user_id,$headline,$price,$city));
				
				$listing_id=pg_fetch_result($find_listing_result, 0, "listing_id");

				//$search_result=pg_query($connect,$listing_search_sql);
				//$listing_id = array();
		
				//while($row = pg_fetch_array($search_result)){
				//	$listing_id[] = $row[0];
				//}

				header("Location:listing-display.php?listing_id=" . $listing_id);
				ob_flush();
			}else {
				echo "<b>" . $error . "</b>";
			}
		}
	}

?>
<form method="post" enctype="multipart/form-data">   
	<div id="bg">
      		<div id="img">
        		<img src="./image/logo2.jpg" width="400" height="200" alt="OVO Logo"/>
        	</div>
      		<div id="reg">
			<table width="900px">
				<tr>
					<td class="tt" width="200"><label for="headline">Headline: </label></td>
					<td class="tt" width="400"><input type="text" name="headline" size="35" class="input1" value="<?php echo $headline; ?>" id="headline"/></td>
				</tr>
				<tr>
					<td class="tt" width="200"><label for="price">Price: </label></td>
					<td class="tt" width="400"><input type="text" name="price" class="input1" value="<?php echo $price; ?>" id="price"/></td>
				</tr>
				<tr>
					<td class="tt" width="200"><label for="status">Status: </label></td>
					<td class="tt" width="400"><?php $status=build_radio("status",$status); echo $status; ?></td>
				</tr>
				<tr>
					<td class="tt" width="200"><label for="description">Description: </label></td>
					<td class="tt" width="400"><input type="text" name="description" class="input1" value="<?php echo $description; ?>" id="description"/></td>
				</tr>
				<tr>
                			<td class="tt" width="200"><label for="property_type">Property Type:</label></td>
                			<td class="tt" width="400"><?php $property_type = build_dropdown("property_type",$property_type); echo $property_type; ?></td>
       				</tr>
				<tr>
                			<td class="tt" width="200"><label for="property_options">Property Options:</label></td>
                			<td class="tt" width="400"><?php $property_options = build_checkbox("property_options",$property_options); echo $property_options; ?></td>
       				</tr>
				<tr>
					<td class="tt" width="200"><label>Transaction Type:</label></td>
					<td class="tt" width="400"><?php $transaction_type = build_radio("transaction_type",$transaction_type); echo $transaction_type; ?></td>
				</tr>
				<tr>
              				<td class="tt" width="200"><label for="building_type">Building Type:</label></td>
                			<td class="tt" width="400"><?php $building_type = build_dropdown('building_type',$building_type); echo $building_type;?></td>
            			</tr>  
				<tr>
              				<td class="tt" width="200"><label for="heating_type">Heating Type:</label></td>
                			<td class="tt" width="400"><?php $heating_type = build_dropdown('heating_type',$heating_type); echo $heating_type;?></td>
            			</tr>  
				<tr>
        				<td class="tt" width="200"><label for="bedrooms">Bedrooms: </label></td>
					<td class="tt" width="400"><?php $bedrooms = build_dropdown('bedrooms',$bedrooms); echo $bedrooms;?></td>
      				</tr>
	  			<tr>
        				<td class="tt" width="200"><label for="bathrooms">Bathrooms: </label></td>
        				<td class="tt" width="400"><?php $bathrooms = build_dropdown('bathrooms',$bathrooms); echo $bathrooms;?></td>
      				</tr>
	  			<tr>
       		 			<td class="tt" width="200"><label for="living_room">Living Room: </label></td>
        				<td class="tt" width="400"><?php $living_room = build_dropdown('living_room',$living_room); echo $living_room;?></td>
      				</tr>
	  			<tr>
        				<td class="tt" width="200"><label for="kitchen">Kitchen: </label></td>
        				<td class="tt" width="400"><?php $kitchen = build_dropdown('kitchen',$kitchen); echo $kitchen;?></td>
      				</tr>
	  			<tr>
        				<td class="tt" width="200"><label for="basement_feature">Basement Features: </label></td>
        				<td class="tt" width="400"><?php $basement_feature = build_dropdown('basement_feature',$basement_feature); echo $basement_feature;?></td>
      				</tr>
	  			<tr>
        				<td class="tt" width="200"><label for="parking_lot">Parking Lot: </label></td>
        				<td class="tt" width="400"><?php $parking_lot = build_dropdown('parking_lot',$parking_lot); echo $parking_lot;?></td>
      				</tr>
        			<tr>
        				<td class="tt" width="200"><label for="building_size">Building Size: </label></td>
        				<td class="tt" width="400"><?php $building_size = build_dropdown('building_size',$building_size); echo $building_size; ?></td>
      				</tr>
	  			<tr>
        				<td class="tt" width="200"><label for="land_size">Land Size: </label></td>
        				<td class="tt" width="400"><?php $land_size = build_dropdown('land_size',$land_size); echo $land_size; ?></td>
     				</tr>
				<tr>
    					<td class="tt" width="200" ><label for="address">Address </label></td>
    					<td class="tt" width="400" ><input type="text" class="input1" name="address" id="address" value="<?php echo $address; ?>"/></td>
    				</tr>
				<tr>
        				<td class="tt" width="200"><label for="city">City: </label></td>
        				<td class="tt" width="400" ><?php $city = build_dropdown('city',$city); echo $city;?></td>
      				</tr>
				<tr>
    					<td class="tt" width="200" ><label for="postal_code">Postal Code: </label></td>
    					<td class="tt" width="400" ><input type="text" class="input1" name="postal_code" id="postal_code" value="<?php echo $postal_code; ?>"/></td>
    				</tr>
				<tr>
				<td colspan="2" align="center">
					<input type="submit" name="submit" value="Create Listing"/>
    					<input type="reset" name="reset"  value="Reset"/>
				</td>
				</tr>
			</table>
		</div>
	</div>
</form>
  
<?php
}//end if of type of user type
require './footer.php';
?>
