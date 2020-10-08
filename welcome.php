<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - welcome.php
*/

$file = "welcome.php";
$date = "10/24/2019";
$description = "welcome webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

/*require header.php in welcome.php*/
require_once "header.php";

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

if($_SESSION['user_type']!=CLIENT && $_SESSION['user_type']!=ADMIN && $_SESSION['user_type']!=PENDING.AGENT){

	$_SESSION['unauthorized_access'] = "You are have no permission to access " . $file;

	if($_SESSION['user_type']==AGENT){
		header("location:dashboard.php?status=loggedin");
        	ob_flush();
	}else{
		header("location:login.php");
        	ob_flush();
	}
}else {
//its an admin or a client

?>
	<!-- show welcome messages to client-->
	<h1>OVO</h1>
	<br/><br/>
	<p>Welcome Back <?php echo $_SESSION['salutation'] . " " . $_SESSION['first_name']  . " " . $_SESSION['last_name']; ?><?php if($_SESSION['user_type'] == PENDING.AGENT) { ?>(PENDING AGENT)<?php } elseif($_SESSION['user_type'] == CLIENT) { ?>(CLIENT)<?php } ?>, you last access is: <?php echo $_SESSION['last_access']; ?><br/>
	Welcome to OVO website!This website is the best simulation for real estate website according to its Authors,
	which are Lisa Legawa, Ngoc Diep Nguyen, and Gabriel Nathan Legawa. The three of us are Durham College's student. 
	We create this OVO website for our WEBD3201 course for our project.</p>
	<br/>
	<p>As a client, you will be able to log out, update your information, change your existing password, search listing, search listing result, and listing display.
	As a client, your homepage will be welcome.php, which is your current page and it will tell you more on what could you do as a client.
	Ovo website will provide many functionality and present it with an amazing design by our authors. We could use this website 
	as a simulator for real estate website, which we will help you to find the best suited house or apartment for your needs. We could 
	provide you with the possible houses that you will like according to your criteria and needs. In addition, we will also help you 
	by giving you an advices with our agents.</p>
	<br/>
	<br/>

<?php

	if(isset($_GET['page'])){
		$pageNumber = $_GET['page'];
	}else{
		//missing page number
		$pageNumber=1; //assuming that the page is 1
	}

	$listing_result = pg_execute($connect, 'get_favorites', array($_SESSION['user_id']));
	$listing_id = array();
	$output = "<table><tr><td>No.</td><td>Listings</td><td>Image</td></tr>";

	while($row = pg_fetch_assoc($listing_result)){
		$listing_id[] = $row["listing_id"];
	}
	//print_r($listing_id);
	if(!empty($listing_id)){
		for($no_listing=($pageNumber - 1) * 10; $no_listing< ($pageNumber * 10) && $no_listing < sizeof($listing_id); $no_listing++){
			$check_status_result = pg_execute($connect, 'check_status', array($listing_id[$no_listing]));
			$check_status=pg_fetch_result($check_status_result, 0, "status");

			$listing_info_execute = pg_execute($connect, 'listing_info', array($listing_id[$no_listing]));
			$listing_info_result = pg_fetch_assoc($listing_info_execute);

			$headline = $listing_info_result["headline"]; 			//headline
			$price = $listing_info_result["price"]; 			//price
			$address = $listing_info_result["address"]; 			//address
			$city = get_property("city",$listing_info_result["city"]); 	//city
			$image = $listing_info_result["image"]; 			//image
		
			if($image == 0)	{
				$image = "<div style=\"transform:rotate(15deg)\">" . "NO IMAGE AVAILABLE" . "</div>";
			}else{
				$image = "<img src=\"./listings/" . $listing_id[$no_listing] . "/". $listing_id[$no_listing] . "_" . (1) .".jpg\" alt=\"Image\" style=\"width:128px;height:128px;\">";
			}
			if($check_status==SOLD){
				$image = "<div style=\"transform:rotate(15deg)\">" . "<font color=\"red\">" . "SOLD" . "</font>" . "</div>";
			}
			
			$output .= "<tr>";
			$output .= "<td>" . ($no_listing+1) . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $listing_id[$no_listing] ."'\" />" . $headline . "<br/>" . "$".number_format($price,2) . "<br/>" . $address . "," . $city . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $listing_id[$no_listing] ."'\" />" . $image . "</td>";
			$output .= "<td><input type=\"button\" value=\"Click To View\" onclick=\"window.location.href='./listing-display.php?listing_id=" . $listing_id[$no_listing] ."'\" /><br/><br/>";
			$output .= "<form method=\"post\">";
			
			$check_favorites_result=pg_execute($connect, 'check_favorites', array($_SESSION['user_id'],$listing_id[$no_listing]));
			$check_favorites=pg_fetch_result($check_favorites_result, 0, 0);
			
			if($check_favorites==1){
			$output .= "<input type=\"submit\" value=\"Remove favorites\" name=\"" . $listing_id[$no_listing] . "\" />";
			}else if($check_favorites==0){
			$output .= "<input type=\"submit\" value=\"Add to favorites\" name=\"" . $listing_id[$no_listing] . "\" />";
			}
			//$output .= "<input type=\"submit\" value=\"Add to favorites\" name=\"add_favorites\" />";
	
			$output .= "</form>";
			$output .= "</td>";
			$output .= "</tr>";
		}
		//CREATE FOR DELETE AS WELL
		//REMOVE ADD FAVORITE BUTTON WHEN IN WELCOME PAGE	
	
		foreach($listing_id as $value){
			if(isset($_POST[$value])){
				$check_favorites_result=pg_execute($connect, 'check_favorites', array($_SESSION['user_id'],$value));
				$check_favorites=pg_fetch_result($check_favorites_result, 0, 0);
			
				if($check_favorites==1){
				$remove_favorites_execute=pg_execute($connect,'remove_favorites',array($_SESSION['user_id'],$value));
				}else if($check_favorites==0){
				$add_favorites_execute=pg_execute($connect,'add_favorites',array($_SESSION['user_id'],$value));
				}
				header("Refresh:0");
				ob_flush();
				//echo $value;
				
			}
		}
		$output .= "</table>";
		echo $output;
		echo "<center>" . pagination_menu($listing_id,$pageNumber) . "</center>";
	}
}
/*require footer.php in welcome.php*/
require_once './footer.php';
?>


