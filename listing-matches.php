<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - listing-search-result.php
*/

$file = "listing-matches.php";
$date = "10/24/2019";
$description = "listing search result webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require "header.php";

if(isset($_SESSION['list_listings'])){
	$listing_array = $_SESSION['list_listings'];
	//echo $_SESSION['test_array'];
	//unset($_SESSION['list_listings']);
	//echo sizeof($listing_array) . " ";
	if(isset($_GET['page'])){
		$pageNumber = $_GET['page'];
	}else{
		//missing page number
		$pageNumber=1; //assuming that the page is 1
	}
}else{
	$_SESSION['unauthorized_access'] = "You haven't input any criteria for your search";
	header("location:listing-search.php");
	ob_flush();
}


echo listing_preview($listing_array,$pageNumber,$_SESSION['user_type']);
echo "<center>" . pagination_menu($listing_array,$pageNumber) . "</center>";
?>

<?php require './footer.php'; ?>
