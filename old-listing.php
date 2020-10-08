<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - dashboard.php
*/

$file = "dashboard.php";
$date = "10/24/2019";
$description = "dashboard webpage for group08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

/*require a header in dashboard.php*/
require "header.php"; 

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

	if(isset($_GET['page'])){
		$pageNumber = $_GET['page'];
	}else{
		//missing page number
		$pageNumber=1; //assuming that the page is 1
	}

	$listing_result = pg_execute($connect, 'agent_old_listing', array($_SESSION['user_id']));
	$listing_id = array();
	while($row = pg_fetch_assoc($listing_result)){
		$listing_id[] = $row["listing_id"];
	}
	//print_r($listing_id);
	
	echo listing_preview($listing_id,$pageNumber,$_SESSION['user_type']);
	echo "<center>" . pagination_menu($listing_id,$pageNumber) . "</center>";
           
}//end if of type of user

require './footer.php';
?>


