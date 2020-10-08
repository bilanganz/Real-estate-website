<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - register.php
*/

$file = "pending-users.php";
$date = "10/24/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require_once 'header.php';

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
disabled-user.php
	list of disabled users
	only can be viewed by admin access (change the dynamic navigation in header.php)
	use pagination

*/

//if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_GET['user_id'])&&($_GET['enable']=='t')){
	if(isset($_GET['user_id'])){
		//echo $_GET['user_id'];
		$connect = db_connect();
		$make_agent_execute = pg_execute($connect,'make_agent',array($_GET['user_id']));
		header("location:./pending-users.php");
		ob_flush();
	}
}

if(isset($_GET['user_id'])&&($_GET['enable']=='f')){
	if(isset($_GET['user_id'])){
		//echo $_GET['user_id'];
		$connect = db_connect();
		$make_agent_execute = pg_execute($connect,'reject_user',array($_GET['user_id']));
		header("location:./pending-users.php");
		ob_flush();
	}
}

$output="";
$connect = db_connect();

//sql command
$sql = "SELECT user_id FROM users WHERE (user_type LIKE 'p%');";
$conn = db_connect();
$disabled_user_execute = pg_query($conn,$sql);
$disabled_users=array();

while($disabled_user_result = pg_fetch_assoc($disabled_user_execute)){
	$disabled_users[] = $disabled_user_result['user_id'];
}

//print_r($disabled_users);

echo "<form method=\"post\" enctype=\"multipart/form-data\">";

$output .= "<table><tr><td colspan='4'>List of Pending Agent</td></tr><tr><td>No.</td><td>User Id</td><td>Name</td></tr>";

	if(isset($_GET['page'])){
		$pageNumber = $_GET['page'];
	}else{
		//missing page number
		$pageNumber=1; //assuming that the page is 1
	}


for($no_listing=($pageNumber - 1) * 10; $no_listing< ($pageNumber * 10) && $no_listing < sizeof($disabled_users); $no_listing++){
	$greeting_info_result = pg_execute($connect, 'greeting_info', array($disabled_users[$no_listing]));
	$greeting_info_row = pg_fetch_assoc($greeting_info_result);

	$salutation = $greeting_info_row["salutation"];
	$first_name = $greeting_info_row["first_name"];
	$last_name = $greeting_info_row["last_name"];

	$output .= "<tr>";
	$output .= "<td>" . $no_listing . "</td>";
	$output .= "<td onclick=\"window.location='./pending-users.php?user_id=" . $disabled_users[$no_listing] ."'\" />" . $disabled_users[$no_listing] . "</td>";
	$output .= "<td>" . $salutation . " " . $first_name . " " . $last_name . "</td>";
	$output .= "<input type=\"hidden\" name=\"HDN_FormClicked\" value=" . $clicked . " />";
	$output .= "<td><input type=\"button\" name=\"btnEnableAgent\" value=\"Click To Enable\" onclick=\"window.location.href='./pending-users.php?user_id=" . $disabled_users[$no_listing] ."&enable=t'\" /></td>";
	$output .= "<td><input type=\"button\" name=\"btnRejectAgent\" value=\"Click To Reject\" onclick=\"window.location.href='./pending-users.php?user_id=" . $disabled_users[$no_listing] ."&enable=f'\" /></td>";
	$output .= "</tr>";
}
$output .= "</table>";

echo $output;
echo "<center>" . pagination_menu($disabled_users,$pageNumber) . "</center>";

echo "<form>";

?>

</table>

<?php
require_once 'footer.php';
?>
