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

?>
	<!-- welcome messages for aan agents -->
	<h1>OVO</h1>
	<br/><br/>
	<p>Welcome Back <?php echo $_SESSION['salutation'] . " " . $_SESSION['first_name']  . " " . $_SESSION['last_name']; ?>(AGENT), you last access is: <?php echo $_SESSION['last_access']; ?><br/>
	Welcome to OVO website!This website is the best simulation for real estate website according to its Authors,
	which are Lisa Legawa, Ngoc Diep Nguyen, and Gabriel Nathan Legawa. The three of us are Durham College's student. 
	We create this OVO website for our WEBD3201 course for our project.</p>
	<br/>
	<p>Since you are an agent, your role will be create the listing, see a listing more detailed information in listing display, search a losting by critera, 
	and see the listing search result. Ovo website will provide many functionality and present it with an amazing design by our authors. We could use this website 
	as a simulator for real estate website, which you an agent will help our customer to find the best suited house or apartment for the customer. We could 
	provide the customer with the possible houses that tehy will like according to their criteria and needs.</p>
	<br/><br/>

<?php
	if(isset($_GET['page'])){
		$pageNumber = $_GET['page'];
	}else{
		//missing page number
		$pageNumber=1; //assuming that the page is 1
	}

	$listing_result = pg_execute($connect, 'agent_listing', array($_SESSION['user_id']));
	$listing_id = array();
	while($row = pg_fetch_assoc($listing_result)){
		$listing_id[] = $row["listing_id"];
	}
	//print_r($listing_id);

	if(!empty($listing_id)){	
		echo listing_preview($listing_id,$pageNumber,$_SESSION['user_type']);
		echo "<center>" . pagination_menu($listing_id,$pageNumber) . "</center>";
	}else{
		echo "<center> Looks Like you havent created any listing.</center>";
	}
           
}//end if of type of user

require './footer.php';
?>


