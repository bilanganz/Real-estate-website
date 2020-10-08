<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - listing-update.php
*/

$file = "listing-update.php";
$date = "10/24/2019";
$description = "listing update webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require ("./header.php");

//Output error message
if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

//Determine if current user type is an agent or an admin
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
	
	if($_SERVER['REQUEST_METHOD'] == "GET"){

		if(empty($_GET['listing_id'])&&!is_numeric($_GET['listing_id'])){
			$_SESSION['unauthorized_access'] = "You haven't selected any listing to update";
			header("location:dashboard.php");
			ob_flush();
		}else{

			$get_agent_result = pg_execute($connect, 'get_agent', array($_GET['listing_id']));
			$get_agent=pg_fetch_result($get_agent_result, 0, "user_id");
		
			if($get_agent!=$_SESSION['user_id']){
				$_SESSION['unauthorized_access'] = "You dont own that listing!";
				header("location:dashboard.php");
       				ob_flush();
			}

			$check_status_result = pg_execute($connect, 'check_status', array($_GET['listing_id']));
			$check_status=pg_fetch_result($check_status_result, 0, "status");

			if($check_status==CLOSED||$check_status==HIDDEN||$check_status==DISABLED){
				$_SESSION['unauthorized_access']="Unable to Make Changes to listing.";
				header("location:dashboard.php");
				ob_flush();
			}

			$listing_id = $_GET['listing_id'];
			$connect = db_connect();
			$listing_update_result = pg_execute($connect, 'listing_select', array($listing_id,$_SESSION['user_id']));
			$row = pg_fetch_assoc($listing_update_result);

			$headline = $row["headline"];
			$price = $row["price"];
			$status = $row["status"];
			$description = $row["description"];
			$property_type = $row["property_type"];
			$property_options = $row["property_options"];
			$transaction_type = $row["transaction_type"];
			$building_type = $row["building_type"];
			$heating_type = $row["heating_type"];
			$bedrooms = $row["bedrooms"];
			$bathrooms = $row["bathrooms"];
			$living_room = $row["living_room"];
			$kitchen = $row["kitchen"];
			$basement_feature = $row["basement_feature"];
			$parking_lot = $row["parking_lot"];
			$building_size = $row["building_size"];
			$land_size = $row["land_size"];
			$address= $row["address"];
			$city = $row["city"];
			$postal_code = $row["postal_code"];
			$image = $row["image"];
		}
	}else if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if(isset($_POST['submit'])){
			$output="";
			$listing_id = $_GET['listing_id'];
			$user_id = $_SESSION['user_id'];
			$headline = trim($_POST['headline']);
			$price = trim($_POST['price']);
			$status = trim($_POST['status']);
			$description = trim($_POST['description']);
			$property_type = trim($_POST['property_type']);
			
			$sum = array();
			foreach($_POST["property_options"] as $selected){
				$sum[]=$selected;
			}

			$property_options = sum_check_box($sum);
			$transaction_type = trim($_POST['transaction_type']);
			$building_type = trim($_POST['building_type']);
			$heating_type = trim($_POST['heating_type']);
			$bedrooms = trim($_POST['bedrooms']);
			$bathrooms = trim($_POST['bathrooms']);
			$living_room = trim($_POST['living_room']);
			$kitchen = trim($_POST['kitchen']);
			$basement_feature = trim ($_POST['basement_feature']);
			$parking_lot = trim($_POST['parking_lot']);
			$building_size = trim($_POST['building_size']);
			$land_size = trim($_POST['land_size']);
			$address = trim($_POST['address']);
			$city = trim($_POST['city']);
			$postal_code = trim($_POST['postal_code']);
			$image = trim($_POST['num_image']);
	
			if($listing_id==""){
				$output .= "Missing listing ID";
			}

			if($user_id==""){
				$output .= "Missing user ID";
			}

			if($headline==""){
				$output .= "You must input your listing headline!";
				$headline ="";
			}else if(strlen($headline)>MAX_HEADLINE_LENGTH){
				$output .= "Maximum character for headline is " . MAX_HEADLINE;
				$headline = "";
			}

			if($price==""){
				$output .= "You must input your listing price!";
				$price ="";
			}else if(!is_numeric($price)){
				$output .= "price should be numeric!";
				$price = "";
			}

			if($status==""){
				$output .= "You must input your listing status!";
				$status ="";
			}

			if($description==""){
				$output .= "You must input your listing description!";
				$description ="";
			}else if(strlen($description)>MAX_DESCRIPTION_LENGTH){
				$output .= "Maximum character for description is " . MAX_DESCRIPTION;
				$description ="";
			}

			if($property_type==""){
				$output .= "You must input your listing property type!";
				$property_type ="";
			}

			/*if($property_options==""){
				$output .= "You must input your listing property options!";
				$property_options ="";
			}*/

			if($transaction_type==""){
				$output .= "You must input your listing transaction type!";
				$transaction_type ="";
			}

			if($building_type==""){
				$output .= "You must input your listing building type!";
				$building_type ="";
			}

			if($heating_type==""){
				$output .= "You must input your listing heating type!";
				$heating_type ="";
			}

			if($bedrooms==""){
				$output .= "You must input your listing bedrooms!";
				$bedrooms ="";
			}

			if($bathrooms==""){
				$output .= "You must input your listing bathrooms!";
				$bathrooms ="";
			}

			if($living_room==""){
				$output .= "You must input your listing living room!";
				$living_room ="";
			}

			if($kitchen==""){
				$output .= "You must input your listing kitchen!";
				$kitchen ="";
			}

			if($basement_feature==""){
				$output .= "You must input your listing basement feature!";
				$basement_feature ="";
			}

			if($parking_lot==""){
				$output .= "You must input your listing parking lot!";
				$parking_lot ="";
			}

			if($building_size==""){
				$output .= "You must input your listing building size!";
				$building_size ="";
			}

			if($land_size==""){
				$output .= "You must input your listing land size!";
				$land_size ="";
			}

			if($address==""){
				$output .= "You must input your listing address!";
				$address ="";
			} else if(strlen($address)>MAX_STREET_ADDRESS_LENGTH){
				$output .= "Maximum address";
				$address = "";
			}

			if($city==""){
				$output .= "You must input your listing city!";
				$city ="";
			}

			if(strlen($postal_code)!=MAX_POSTAL_CODE_LENGTH){
				$output .= "Postal Code should be 6 digits";
				$postal_code = "";
			}else if(!is_valid_postal_code($postal_code)){
				$output .= "Not valid postal code!";
				$postal_code = "";
			}


			if($output==""){
				$connect = db_connect();
				$listing =  array($headline,$price,$status,$description,$property_type,$property_options,$transaction_type,$building_type,$heating_type,$bedrooms,$bathrooms,$living_room,$kitchen,$basement_feature,$parking_lot,$building_size,$land_size,$address,$city,$postal_code,$image,$listing_id,$user_id);
				//print_r($listing);
				$listing_update_result = pg_execute($connect, 'listing_update',$listing);
				header("location:./listing-display.php?listing_id=".$listing_id);
				ob_flush();
				echo ' Listing update successful';
			}else{
				echo $output;
			}
		}
	}
?>

<form method="POST" enctype="multipart/form-data">   
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
    					<td class="tt" width="200" ><label for="image">Number Of Image: </label></td>
    					<td class="tt" width="400"><input type="text" class="input1" name="num_image" value="<?php echo $image;?>" readonly/></td>
    					</tr>	
					<tr>
						<td class="tt" width="200" ><label for="modify_image">Select To Modify Image: </label></td>
    						<td class="tt" width="400"><input type="button" style="width:75px;height:30px;" value="Edit Image" onclick="location.href='listing-images.php?listing_id=<?php echo $_GET['listing_id']; ?>'" /></td>
					</tr>	
					<!--<tr>
    					<td class="tt" width="200" ><label for="upload_image">Select image to upload: </label></td>
    					<td class="tt" width="400"><input type="file" name="image" id="upload_image"/></td>
    					</tr>-->
					<tr>
					<td colspan="2" align="center">
						<input type="submit" name="submit" value="Update Listing"/>
    						<input type="reset" name="reset"  value="Reset"/>
					</td>
					</tr>
    			</table>
		</div>
    	</div>
  </form>
  
<?php
}//end if of type of users

require './footer.php';
?>
