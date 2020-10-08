<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - listing - search.php
*/
$file = "listing-search.php";
$date = "10/24/2019";
$description = "listing search webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require "header.php";

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'] . "<br/>";
	unset($_SESSION['unauthorized_access']);
}

if(isset($_COOKIE['city'])){
$city = $_COOKIE['city'];
}

if((empty($_SESSION['city'])&&empty($_GET['city'])&&$city=="")){
	$_SESSION['unauthorized_access'] = "You haven't select any city!";
	header("location:listing-select-city.php");
	ob_flush();
}else{
	if(isset($_GET['city'])){
		$city = $_GET['city'];
		$_SESSION['city'] = $city;
	}else if(isset($_SESSION['city'])){
		$city = $_SESSION['city'];
		//unset($_SESSION['city']);
	}else if (isset($_COOKIE['city'])) {
		$city = $_COOKIE['city'];
	}

	$city_selected="";
	for($counter=0;$counter<10;$counter++){
		if(is_bit_set($counter, $city)){
			$city_selected .= get_property("city",pow(2,$counter)) . ",";
		}	
	}
$city_selected = substr($city_selected, 0, -1);
echo "<a href=\"./listing-select-city.php\">city</a> >> " . $city_selected;
}

if($_SERVER['REQUEST_METHOD']=='GET'){
	$min_price="";			//between 50k to 500k
	$max_price="";			//between 50k to 500k
	$property_type="";		//1,2,4... 64, 7 options
	$property_options="";		//1-16, 5 options
	$transaction_type="";		//SALE or RENT (1,2), 2 options
	$building_type="";		//1-128, 8 options
	$heating_type="";		//1-128, 8 options
	$bedrooms="";			//1-64, 7 options
	$bathrooms="";			//1-64, 7 options
	$living_room="";		//1-4, 3 options
	$kitchen="";			//1-4, 3 options
	$basement_feature="";		//1-128, 8 options
	$parking_lot="";		//1-512, 10 options
	$building_size="";		//1-64, 7 options
	$landsize="";			//1-64, 7 options
	$city="";			//refer back to the seed_generator.php
}

if (isset($_COOKIE['MIN_PRICE'])) {
    $min_price = $_COOKIE['MIN_PRICE'];
}
if (isset($_COOKIE['MAX_PRICE'])) {
    $max_price = $_COOKIE['MAX_PRICE'];
}
if (isset($_COOKIE['PROPERTY_TYPE'])) {
    $property_type = $_COOKIE['PROPERTY_TYPE'];
}
if (isset($_COOKIE['PROPERTY_OPTIONS'])) {
    $property_options = $_COOKIE['PROPERTY_OPTIONS'];
}
if (isset($_COOKIE['TRANSACTION_TYPE'])) {
    $transaction_type = $_COOKIE['TRANSACTION_TYPE'];
}
if (isset($_COOKIE['BUILDING_TYPE'])) {
    $building_type = $_COOKIE['BUILDING_TYPE'];
}
if (isset($_COOKIE['HEATING_TYPE'])) {
    $heating_type = $_COOKIE['HEATING_TYPE'];
}
if (isset($_COOKIE['BEDROOMS'])) {
    $bedrooms = $_COOKIE['BEDROOMS'];
}
if (isset($_COOKIE['BATHROOMS'])) {
    $bathrooms = $_COOKIE['BATHROOMS'];
}
if (isset($_COOKIE['LIVING_ROOM'])) {
    $living_room = $_COOKIE['LIVING_ROOM'];
}
if (isset($_COOKIE['KITCHEN'])) {
    $kitchen = $_COOKIE['KITCHEN'];
}
if (isset($_COOKIE['BASEMENT_FEATURE'])) {
    $basement_feature = $_COOKIE['BASEMENT_FEATURE'];
}
if (isset($_COOKIE['PARKING_LOT'])) {
    $parking_lot = $_COOKIE['PARKING_LOT'];
}
if (isset($_COOKIE['BUILDING_SIZE'])) {
    $building_size = $_COOKIE['BUILDING_SIZE'];
}
if (isset($_COOKIE['LAND_SIZE'])) {
    $land_size = $_COOKIE['LAND_SIZE'];
}
if(isset($_POST["search"])){
	$error = "";
	$min_price=$_POST["min_price"];					//between 50k to 500k
	$max_price=$_POST["max_price"];					//between 50k to 500k
	$property_type=sum_check_box($_POST["property_type"]);		//1,2,4... 64, 7 options
	$property_options=sum_check_box($_POST["property_options"]);	//1-16, 5 options
	$transaction_type=sum_check_box($_POST["transaction_type"]);	//SALE or RENT (1,2), 2 options
	$building_type=sum_check_box($_POST["building_type"]);		//1-128, 8 options
	$heating_type=sum_check_box($_POST["heating_type"]);		//1-128, 8 options
	$bedrooms=sum_check_box($_POST["bedrooms"]);			//1-64, 7 options
	$bathrooms=sum_check_box($_POST["bathrooms"]);			//1-64, 7 options
	$living_room=sum_check_box($_POST["living_room"]);		//1-4, 3 options
	$kitchen=sum_check_box($_POST["kitchen"]);			//1-4, 3 options
	$basement_feature=sum_check_box($_POST["basement_feature"]);	//1-128, 8 options
	$parking_lot=sum_check_box($_POST["parking_lot"]);		//1-512, 10 options
	$building_size=sum_check_box($_POST["building_size"]);		//1-64, 7 options
	$land_size=sum_check_box($_POST["land_size"]);			//1-64, 7 options
	//$city = $_SESSION["city"];

	if(!empty($min_price)&&!empty($max_price)){
		if($min_price>$max_price){
			$error .= "<br/><h1>Your minimum price can't be less than your maximum price</h1>";
			$min_price="";
			$max_price="";
		}
	}else{
		if($min_price!=""&&$min_price<=0){
			$error .= "<br/><h1>Minimum Price Cant Be less or equal to zero</h1>";
			$min_price="";
		}else if($min_price!=""&&!is_numeric($min_price)){
			$error .= "<br/><h1>Invalid Min Price</h1>";
			$min_price="";
		}
		if($max_price!=""&&$max_price<=0){
			$error .= "<br/><h1>Maximum Price Cant Be less or equal to zero</h1>";
			$max_price="";
		}else if($max_price!=""&&!is_numeric($max_price)){
			$error .= "<br/><h1>Invalid Max Price</h1>";
			$max_price="";
		}

	}

	//SETTING COOKIE
	setcookie("LAND_SIZE",$land_size,time() + COOKIE_LIFESPAN);
	setcookie("BUILDING_SIZE",$building_size,time() + COOKIE_LIFESPAN);
	setcookie("PARKING_LOT",$parking_lot,time() + COOKIE_LIFESPAN);
	setcookie("BASEMENT_FEATURE",$basement_feature,time() + COOKIE_LIFESPAN);
	setcookie("KITCHEN",$kitchen,time() + COOKIE_LIFESPAN);
	setcookie("LIVING_ROOM",$living_room,time() + COOKIE_LIFESPAN);
	setcookie("BATHROOMS",$bathrooms,time() + COOKIE_LIFESPAN);
	setcookie("BEDROOMS",$bedrooms,time() + COOKIE_LIFESPAN);
	setcookie("HEATING_TYPE",$heating_type,time() + COOKIE_LIFESPAN);
	setcookie("BUILDING_TYPE",$building_type,time() + COOKIE_LIFESPAN);
	setcookie("TRANSACTION_TYPE",$transaction_type,time() + COOKIE_LIFESPAN);
	setcookie("PROPERTY_OPTIONS",$property_options,time() + COOKIE_LIFESPAN);
	setcookie("PROPERTY_TYPE",$property_type,time() + COOKIE_LIFESPAN);
	setcookie("MAX_PRICE",$max_price,time() + COOKIE_LIFESPAN);
	setcookie("MIN_PRICE",$min_price,time() + COOKIE_LIFESPAN);
	setcookie("CITY",$city,time() + COOKIE_LIFESPAN);

	if($error==""){
		//echo $listing_id . " " . $user_id . " " . $status . " " . $headline . " " . $min_price . " " . $max_price . " " . $property_type . " " .$property_options . " " . $transaction_type . " " . $building_type . " " . $heating_type . " " . $bedrooms . " " . $bathrooms . " " . $living_room . " " . $kitchen . " " . $basement_feature . " " . $parking_lot . " " . $building_size . " " . $land_size . " " . $address . " " . $city . " " . $postal_code . " " . $images;			//Not sure
		//print_r($property_options);
		$listing_search_sql = build_search_sql($min_price,$max_price,$property_type,$property_options,$transaction_type,$building_type,$heating_type,$bedrooms,$bathrooms,$living_room,$kitchen,$basement_feature,$parking_lot,$building_size,$land_size,$city);
		//echo $listing_search_sql;
		//$listing_search_sql = "SELECT listing_id FROM listings where price >=500000 and city='64'"; 	// 0 listing
		//$listing_search_sql = "SELECT listing_id FROM listings where price >=495000 and city='64'"; 	// 1 listing
		//$listing_search_sql = "SELECT listing_id FROM listings where price >=495000 and city='1'"; 	// 2 listings
		//$listing_search_sql = "SELECT listing_id FROM listings where city='64'"; 			// 232 listing

		$conn = db_connect();
		$search_result=pg_query($conn,$listing_search_sql);
		$listing_id = array();
		
		while($row = pg_fetch_array($search_result)){
			$listing_id[] = $row[0];
		}

		if(pg_num_rows($search_result)==0){
			echo "<center><h1>There are 0 match found, perhaps you should expand your search criteria</h1></center>";
			//echo $listing_search_sql;
		}else if(pg_num_rows($search_result)==1){
			header("location:listing-display.php?listing_id=" . $listing_id[0]);
			ob_flush();
		}else if(pg_num_rows($search_result)>1){
			$_SESSION['list_listings'] = $listing_id;
			//$_SESSION['test_array'] = $listing_search_sql;
			header("location:listing-matches.php?page=1");
			ob_flush();
		}

	}else{
		echo $error;
	}
}
?>

<form action="listing-search.php" method="post" enctype="multipart/form-data">
	<div id="bg">
		<div id="img">
			<img src="./image/logo2.jpg" width="400" height="200" alt="OVO Logo"/>        
		</div>
		<div id="reg">
			<table width="900px">
					<!--<tr>
					<td class="tt" width="200"><label for="keyword">Keyword :</label></td>
					<td class="tt" width="400"><input type="text" name="keyword" value="" style="margin-top:10px;margin-bottom:10px;" id="keyword" />	
					<input type="hidden" name="variable" value="searching"/></td>
					</tr>-->
            				<tr>
					<td class="tt" width="200"><label for="min_price">Min Price :</label></td>
					<td class="tt" width="400"><input type="text" name="min_price" value="<?php echo $min_price; ?>" style="margin-top:10px;margin-bottom:10px;" id="min_price" /></td>
					</tr>
            				<tr>
					<td class="tt" width="200"><label for="max_price">Max Price :</label></td>
					<td class="tt" width="400"><input type="text" name="max_price" value="<?php echo $max_price; ?>" style="margin-top:10px;margin-bottom:10px;" id="max_price" /></td>
					</tr>
            				<tr>
              				<td class="tt" width="200"><label>Property Type:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $property_type=build_checkbox("property_type",$property_type); echo $property_type; ?></td>
              				</tr>
					<!--<tr>
					<td class="tt" width="400" colspan="2"><div class="dropdown">
					<button class="dropbtn">Property Type:</button>
					<div class="dropdown-content" style="text-align:left">
					<?php $property_type=build_checkbox("property_type",$property_type); echo $property_type; ?>
					</div>
					</div>
					</td>
              				</tr>-->
					<tr>
              				<td class="tt" width="200"><label>Property Options:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $property_options=build_checkbox("property_options",$property_options); echo $property_options; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Transaction Type:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $transaction_type=build_checkbox("transaction_type",$transaction_type); echo $transaction_type; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Building Type:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $building_type=build_checkbox("building_type",$building_type); echo $building_type; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Heating Type:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $heating_type=build_checkbox("heating_type",$heating_type); echo $heating_type; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Bedrooms:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $bedrooms=build_checkbox("bedrooms",$bedrooms); echo $bedrooms; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Bathrooms:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $bathrooms=build_checkbox("bathrooms",$bathrooms); echo $bathrooms; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Living Rooms:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $living_room=build_checkbox("living_room",$living_room); echo $living_room; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Kitchen:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $kitchen=build_checkbox("kitchen",$kitchen); echo $kitchen; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Basement Feature:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $basement_feature=build_checkbox("basement_feature",$basement_feature); echo $basement_feature; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Parking Lot:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $parking_lot=build_checkbox("parking_lot",$parking_lot); echo $parking_lot; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Building Size:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $building_size=build_checkbox("building_size",$building_size); echo $building_size; ?></td>
              				</tr>
					<tr>
              				<td class="tt" width="200"><label>Land Size:</label></td>
                			<td class="tt" width="400" style="text-align:left"><?php $land_size=build_checkbox("land_size",$land_size); echo $land_size; ?></td>
              				</tr>
					<tr>
    					<td class="tt" colspan="2" align="center"><input type="submit" value="Search" name="search" class="bt"/>
    					<input type="reset" name="cancel" class="bt" value="Cancel"/></td>
    					</tr>
    			</table>
		</div>
    	</div>
</form>
<?php
require './footer.php'; 
?>