<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - listing-display.php
*/

$file = "listing-display.php";
$date = "10/24/2019";
$description = "listing display webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";
require "header.php";

$conn = db_connect();
$check_status_result = pg_execute($conn, 'check_status', array($_GET['listing_id']));
$check_status=pg_fetch_result($check_status_result, 0, "status");

if($_SESSION['user_type']==ADMIN){
	$offense_listing_result = pg_execute($connect,'get_offense_detail',array($_GET['listing_id']));
	$offense_listing = pg_fetch_assoc($offense_listing_result);
	
	$reported_by=$offense_listing['user_id'];
	$reported_on=$offense_listing['reported_on'];
	
	$greeting_info_result = pg_execute($connect, 'greeting_info', array($reported_by));
	$greeting_info_row = pg_fetch_assoc($greeting_info_result);

	$salutation = $greeting_info_row["salutation"];
	$first_name = $greeting_info_row["first_name"];
	$last_name = $greeting_info_row["last_name"];

	$report_data="";
	$report_data.="<table>";
	$report_data.="<tr><td>Reported By</td><td>" . $salutation . " " . $first_name . " " . $last_name . "</td></tr>";
	$report_data.="<tr><td>Reported On</td><td>" . $reported_on . "</td></tr>";
	$report_data.="<tr><td>Reporter ID</td><td>" . $reported_by . "</td></tr>";
	$report_data.="<tr><td colspan='2'><input type=\"submit\" value=\"Disable This Client\" name=\"btnDisableClient\" /></td></tr>";
	$report_data.="</table>";
	echo "<form method=\"post\" enctype=\"multipart/form-data\">";
	echo $report_data;
	echo "</form>";
	
	if(isset($_POST['btnDisableClient'])){
		if($disable_user_result = pg_execute($connect, 'disable_user', array($reported_by))){
			$remove_user_favorites_result=pg_execute($connect, 'remove_user_favorites', array($reported_by));
			$close_offensive_listing_result = pg_execute($connect, 'close_offensive_listing', array($_GET['listing_id']));
			$_SESSION['unauthorized_access'] = "Sucessfully Disabled";
			header('location:./offense-listing.php');
			ob_flush();
		}
	}

	if(isset($_POST['enable_listing'])){
		if($disable_user_result = pg_execute($connect, 'enable_listing', array($_GET['listing_id']))){
			$remove_offensive_listing_result = pg_execute($connect, 'remove_offensive_listing', array($_GET['listing_id']));
			$_SESSION['unauthorized_access']="Sucessfully Enable Listing!";
			header("location:admin.php");
			ob_flush();
		}
	}


if(isset($_POST['hide_listing'])){
	if($disable_listing_result = pg_execute($connect, 'disable_listing', array($_GET['listing_id']))){
		$get_agent_result = pg_execute($connect, 'get_agent', array($_GET['listing_id']));
		$get_agent=pg_fetch_result($get_agent_result, 0, "user_id");
		$disable_user_result = pg_execute($connect, 'disable_user', array($get_agent));
		$close_offensive_listing_result = pg_execute($connect, 'close_offensive_listing', array($_GET['listing_id']));
		rmdir("listings"."/".$_GET['listing_id']);
	}
	$_SESSION['unauthorized_access']="Sucessfully Disabled Agent!";
	header("location:admin.php");
	ob_flush();
	//echo $value;				
}

}


if(isset($_POST['favorites'])){
	$check_favorites_result=pg_execute($connect, 'check_favorites', array($_SESSION['user_id'],$_GET['listing_id']));
	$check_favorites=pg_fetch_result($check_favorites_result, 0, 0);
		
	if($check_favorites==1){
		$remove_favorites_execute=pg_execute($connect,'remove_favorites',array($_SESSION['user_id'],$_GET['listing_id']));
	}else if($check_favorites==0){
		$add_favorites_execute=pg_execute($connect,'add_favorites',array($_SESSION['user_id'],$_GET['listing_id']));
	}
	header("Refresh:0");
	ob_flush();
	//echo $value;				
}

if(isset($_POST['offensives'])){
	if($add_offensives_result = pg_execute($connect, 'add_offensives', array($_SESSION['user_id'],$_GET['listing_id']))){
		echo "Report Submitted!";
	}else{
		echo "Failed To Submit The Report!";
	}	
	header("Refresh:0");
	ob_flush();
	//echo $value;				
}

//print_r($_SESSION['list_listings']);
//echo $_SESSION['test_array'];
if(isset($_GET['listing_id'])){
	$listing_detail_execute = pg_execute($connect, 'listing_detail', array($_GET['listing_id']));
	$listing_detail_result = pg_fetch_assoc($listing_detail_execute);

	$headline = $listing_detail_result["headline"]; 	//headline
	$price = $listing_detail_result["price"]; 	//price
	$image = $listing_detail_result["image"]; 			//image
	$postal_code = $listing_detail_result["postal_code"];
	$description = $listing_detail_result["description"];
	$status = get_property("status",$listing_detail_result["status"]);
	$city = get_property("city",$listing_detail_result["city"]); 	//city
	$property_type = get_property("property_type",$listing_detail_result["property_type"]);
	$property_options = get_property("property_type",$listing_detail_result["property_options"]);
	
	$property_options = "";
	for($counter=0;$counter<=5;$counter++){
		if(is_bit_set($counter, $listing_detail_result["property_options"])){
			$property_options .= get_property("property_options",pow(2,$counter)) . ",";
		}	
	}
	$property_options = substr($property_options, 0, -1);
	
	$transaction_type = get_property("transaction_type",$listing_detail_result["transaction_type"]);
	$building_type = get_property("building_type",$listing_detail_result["building_type"]);
	$heating_type = get_property("heating_type",$listing_detail_result["heating_type"]);
	$bedrooms = get_property("bedrooms",$listing_detail_result["bedrooms"]);
	$bathrooms = get_property("bathrooms",$listing_detail_result["bathrooms"]);
	$living_room = get_property("living_room",$listing_detail_result["living_room"]);
	$kitchen = get_property("kitchen",$listing_detail_result["kitchen"]);
	$basement_feature = get_property("basement_feature",$listing_detail_result["basement_feature"]);
	$parking_lot = get_property("parking_lot",$listing_detail_result["parking_lot"]);
	$building_size = get_property("building_size",$listing_detail_result["building_size"]);
	$land_size = get_property("land_size",$listing_detail_result["land_size"]);
	$address = $listing_detail_result["address"]; 	//address	

	if($image == 0){
		$image = "NO IMAGE AVAILABLE";
	}else{
		$image = "<img src=\"./listings/" . $_GET['listing_id'] . "/". $_GET['listing_id'] . "_" . (1) .".jpg\" alt=\"Image\" style=\"width:128px;height:128px;\">";
	}
	
	if($status=='Sold'){
		$image = "<div style=\"transform:rotate(15deg)\">" . "<font color=\"red\">" . "SOLD" . "</font>" . "</div>";
	}

	//echo "<table>";
	//echo "<tr><td>" . $headline . "<br/>" . "$".number_format($price,2) . "<br/>" . $address . "," . $city . "<br/>" . $image . "</td></tr>";
	//echo "</table>";
} else if($_SESSION['user_type']!=ADMIN||$check_status==CLOSED||$check_status==HIDDEN||$check_status==DISABLED){
	header("location:listing-search.php");
	ob_flush();
} else {
	$_SESSION['unauthorized_access'] = "You haven't select any criteria!";
	header("location:listing-search.php");
	ob_flush();
}
?>
<table width="900px">
		<tr>
				<?php
				if(isset($_SESSION['user_type'])){
					echo "<td colspan=\"2\">";
					$check_favorites_result=pg_execute($connect, 'check_favorites', array($_SESSION['user_id'],$_GET['listing_id']));
					$check_favorites=pg_fetch_result($check_favorites_result, 0, 0);
				
					$check_offensive_result=pg_execute($connect, 'check_offensives', array($_SESSION['user_id'],$_GET['listing_id']));
					$check_offensive=pg_fetch_result($check_offensive_result, 0, 0);
				
					echo "<form method=\"post\">";
					if($check_favorites==1){
						echo "<input type=\"submit\" value=\"Remove favorites\" name=\"favorites\" />";
					}else if($check_favorites==0){
						echo "<input type=\"submit\" value=\"Add to favorites\" name=\"favorites\" />";
					}
					if($_SESSION['user_type']==ADMIN){
						echo "&nbsp;&nbsp;";
						echo "<input type=\"submit\" value=\"Offense Listing\" name=\"hide_listing\" />";
						echo "&nbsp;&nbsp;";
						echo "<input type=\"submit\" value=\"Not Offense Listing\" name=\"enable_listing\" />";
					}else{
						echo "&nbsp;&nbsp;";
						if($check_offensive==1){
							echo "Your Report have been submitted";
						}else if($check_offensive==0){
							echo "<input type=\"submit\" value=\"Report Listing\" name=\"offensives\" />";
						}
					}
					echo "</form>";
					echo "</td>";
				}
				?>
		</tr>
		<tr>
			<td width="200" >Title: </td>
			<td width="400" ><?php echo $headline; ?></td>
		</tr>
		<tr>
			<td width="200" >Price: </td>
			<td width="400" ><?php echo $price; ?></td>
		</tr>
		<tr>
			<td width="200" >Status: </td>
			<td width="400" ><?php echo $status; ?></td>
		</tr>
		<tr>
			<td width="200" >Description: </td>
			<td width="400" ><?php echo $description; ?></td>
		</tr>
		<tr>
                	<td width="200" >Property Type:</td>
                	<td width="400" ><?php echo $property_type; ?></td>
	        </tr>
		<tr>
                	<td width="200" >Property Options:</td>
                	<td width="400" ><?php echo $property_options; ?></td>
	        </tr>
		<tr>
			<td width="200" >Transaction Type:</td>
			<td width="400" ><?php echo $transaction_type; ?></td>
		</tr>
		<tr>
                	<td width="200" >Building Type:</td>
                	<td width="400" ><?php echo $building_type; ?></td>                     
     		</tr>
		<tr>
        		<td width="200" >Bedrooms: </td>
        		<td width="400" ><?php echo $bedrooms; ?></td>
     		</tr>
	  	<tr>
        		<td width="200" >Bathrooms: </td>
        		<td width="400" ><?php echo $bathrooms; ?></td>
      		</tr>
	  	<tr>
        		<td width="200" >Living Room: </td>
        		<td width="400" ><?php echo $living_room; ?></td>
      		</tr>
	  	<tr>
        		<td width="200" >Kitchen: </td>
        		<td width="400" ><?php echo $kitchen; ?></td>
     		</tr>
	  	<tr>
        		<td width="200" >Basement Features: </td>
        		<td width="400" ><?php echo $basement_feature; ?></td>
      		</tr>
	  	<tr>
        		<td width="200" >Parking Lot: </td>
        		<td width="400" ><?php echo $parking_lot; ?></td>
      		</tr>
	  	<tr>
        		<td width="200" >Estimate Property Taxes:</td>
        		<td width="400" >$ 50,000+</td>
		</tr>
        	<tr>
        		<td width="200" >Building Size: </td>
        		<td width="400" ><?php echo $building_size; ?></td>
      		</tr>
	  	<tr>
		        <td width="200" >Land Size: </td>
        		<td width="400" ><?php echo $land_size; ?></td>
      		</tr>
	 	<tr>
    			<td width="200" >Address:</td>
    			<td width="400" ><?php echo $address; ?></td>
    		</tr>
		<tr>
        		<td width="200" >City: </td>
        		<td width="400" ><?php echo $city; ?></td>
      		</tr>
	  	<tr>
   			<td width="200" >Postal Code: </td>
    			<td width="400" ><?php echo $postal_code; ?></td>
    		</tr>
		<tr>
    			<td width="200" >Image</td>
    			<td width="400" ><?php echo $image; ?></td>
    		</tr>
</table>
<br/>
<center><input type="button" style="width:60px;height:30px;" value="Back" onclick="window.history.back()" /> </center>
<?php 
require './footer.php'; 
?>
