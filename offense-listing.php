<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - register.php
*/

$file = "offense-listing.php";
$date = "10/24/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require_once 'header.php';

if(isset($_SESSION['unauthorized_access'])){
echo $_SESSION['unauthorized_access'];
unset($_SESSION['unauthorized_access']);
}

//TO-DO
//ONLY ADMIN CAN ACCESS
//MODIFY NAVBAR FOR ADMIN IN HEADER.PHP

if($_SESSION['user_type']!=ADMIN){

	$_SESSION['unauthorized_access'] = "You are have no permission to access " . $file;

	if($_SESSION['user_type']==CLIENT){
		header("location:welcome.php?status=loggedin");
       		ob_flush();
	}else if($_SESSION['user_type']==AGENT){
		header("location:dashboard.php?status=loggedin");
       		ob_flush();
	}else if($_SESSION['user_type']==PENDING.AGENT){
		header("location:welcome.php?status=loggedin");
       		ob_flush();
	}else{
		header("location:login.php");
       		ob_flush();
	}

}
/*
//if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_GET['user_id'])){
	//echo $_GET['user_id'];
	$connect = db_connect();
	$make_agent_execute = pg_execute($connect,'make_agent',array($_GET['user_id']));
	header("location:./pending-users.php");
	ob_flush();
}*/

	if(isset($_GET['page'])){
		$pageNumber = $_GET['page'];
	}else{
		//missing page number
		$pageNumber=1; //assuming that the page is 1
	}

$output="";
$connect = db_connect();
$offense_listing_result = pg_execute($connect,'get_offense',array());
$offense_listings=array();

while($offense_listing = pg_fetch_assoc($offense_listing_result)){
	$offense_listings[] = $offense_listing['listing_id'];
}
//print_r($offense_listings);
//echo date("l");

	$output .= "<table><tr><td>No.</td><td>Listings</td><td>Image</td></tr>";

		for($no_listing=($pageNumber - 1) * 10; $no_listing< ($pageNumber * 10) && $no_listing < sizeof($offense_listings); $no_listing++){
			$listing_info_execute = pg_execute($connect, 'listing_info', array($offense_listings[$no_listing]));
			$listing_info_result = pg_fetch_assoc($listing_info_execute);

			$headline = $listing_info_result["headline"]; 	//headline
			$price = $listing_info_result["price"]; 		//price
			$address = $listing_info_result["address"]; 	//address
			$city = get_property("city",$listing_info_result["city"]); 		//city
			$image = $listing_info_result["image"]; 		//image
		
			if($image == 0)	{
				$image = "<div style=\"transform:rotate(15deg)\">" . "NO IMAGE AVAILABLE" . "</div>";
			}else{
				$image = "<img src=\"./listings/" . $offense_listings[$no_listing] . "/". $offense_listings[$no_listing] . "_" . (1) .".jpg\" alt=\"Image\" style=\"width:128px;height:128px;\">";
			}
			
			$output .= "<tr>";
			$output .= "<td>" . ($no_listing+1) . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $offense_listings[$no_listing] ."'\" />" . $headline . "<br/>" . "$".number_format($price,2) . "<br/>" . $address . "," . $city . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $offense_listings[$no_listing] ."'\" />" . $image . "</td>";
			$output .= "<td><input type=\"button\" value=\"Click To View\" onclick=\"window.location.href='./listing-display.php?listing_id=" . $offense_listings[$no_listing] ."'\" /></td>";
			$output .= "</tr>";
		}
	$output .= "</table>";

	echo $output;


?>

<?php
require_once 'footer.php';
?>
