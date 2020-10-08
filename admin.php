<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - admin.php
*/

$file = "admin.php";
$date = "10/24/2019";
$description = "admin page for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing.";
require_once "header.php";

if(isset($_SESSION['unauthorized_access'])){
echo $_SESSION['unauthorized_access'];
unset($_SESSION['unauthorized_access']);
}

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

}else {	//its an admin


?>
	<h1>OVO</h1>
	<br/><br/>
	<p>Welcome Back <?php echo $_SESSION['salutation'] . " " . $_SESSION['first_name']  . " " . $_SESSION['last_name']; ?>(ADMIN) , you last access is: <?php echo $_SESSION['last_access']; ?><br/>
	Welcome to OVO website!<br/>
	As an admin, you have access to most of the page in this site. On your header, you could log out, change your password
	admin homepage (this current page), listing create, listing display, listing search, and listing search result. When you go to log out, you could log out from your current account by unset the cookies and destroy your session. 
	In change password, you could change your current password to the new one. In the listing create, you could create a new house or apartment listing. 
	In  listing display, you could see the details of the house or apartment. In listing search, you could fill out the form and find the listings based on your criteria. 
	In the listing search result, you will see your listings based on your criteria you gave in listing search.</p> <br/><br/>
	
	<p>This website is the best simulation for real estate website according to its Authors,
	which are Lisa Legawa, Ngoc Diep Nguyen, and Gabriel Nathan Legawa. The three of us are Durham College's student. 
	We create this OVO website for our WEBD3201 course for our project.</p>
	<br/><br/>

<?php
}//end if of type of user

require_once './footer.php';
?>


