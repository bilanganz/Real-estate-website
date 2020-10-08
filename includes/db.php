<?php
function db_connect(){
$connection = pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASSWORD);
return $connection;
}

$connect = db_connect();

$remove_user_favorites_sql = "DELETE FROM favorites WHERE user_id=$1;";
$remove_user_favorites_prepare = pg_prepare($connect, 'remove_user_favorites', $remove_user_favorites_sql);

$close_offensive_listing_sql = "UPDATE offensives SET status='c' WHERE listing_id=$1;";
$close_offensive_listing_prepare = pg_prepare($connect, 'close_offensive_listing', $close_offensive_listing_sql);

$remove_offensive_listing_sql = "DELETE FROM offensives WHERE listing_id=$1;";
$remove_offensive_listing_prepare = pg_prepare($connect, 'remove_offensive_listing', $remove_offensive_listing_sql);

$enable_listing_sql = "UPDATE listings SET status='o' WHERE listing_id=$1;";
$enable_listing_prepare = pg_prepare($connect, 'enable_listing', $enable_listing_sql);

$get_offense_sql = "SELECT * FROM offensives WHERE status='o' ORDER BY reported_on ASC;";
$get_offense_prepare = pg_prepare($connect, 'get_offense', $get_offense_sql);

$get_offense_detail_sql = "SELECT * FROM offensives WHERE listing_id=$1;";
$get_offense_detail_prepare = pg_prepare($connect, 'get_offense_detail', $get_offense_detail_sql);

$disable_user_sql = "UPDATE users SET user_type=CONCAT('d',user_type) WHERE user_id=$1;";
//$disable_user_sql = "UPDATE users SET user_type='da' WHERE user_id=$1;";
$disable_user_prepare = pg_prepare($connect, 'disable_user', $disable_user_sql);

$reject_user_sql = "UPDATE users SET user_type=REPLACE(user_type,'p','d') WHERE user_id=$1;";
$reject_user_prepare = pg_prepare($connect, 'reject_user', $reject_user_sql);

$get_agent_sql = "SELECT user_id FROM listings WHERE listing_id=$1;";
$get_agent_prepare = pg_prepare($connect, 'get_agent', $get_agent_sql);

$disable_listing_sql = "UPDATE listings SET status='d' WHERE listing_id=$1;";
$disable_listing_prepare = pg_prepare($connect, 'disable_listing', $disable_listing_sql);

$hide_listing_sql = "UPDATE listings SET status='h' WHERE listing_id=$1;";
$hide_listing_prepare = pg_prepare($connect, 'hide_listing', $hide_listing_sql);

$check_status_sql = "SELECT status FROM listings WHERE listing_id=$1;";
$check_status_prepare = pg_prepare($connect, 'check_status', $check_status_sql);

$email_validate_sql = "SELECT COUNT(email_address) FROM users WHERE user_id=$1 AND email_address=$2;";
$email_validate_prepare = pg_prepare($connect, 'email_validate' , $email_validate_sql);

$update_password_sql = "UPDATE users SET password=$1 WHERE user_id=$2 AND email_address=$3;";
$update_password_prepare = pg_prepare($connect, 'update_password', $update_password_sql);

$add_offensive_sql = "INSERT INTO offensives(user_id,listing_id,status) VALUES ($1,$2,'o');";
$add_offensive_prepare = pg_prepare($connect, 'add_offensives', $add_offensive_sql);

$check_offensive_sql = "SELECT COUNT(*) FROM offensives WHERE user_id=$1 AND listing_id = $2;";
$check_offensive_prepare = pg_prepare($connect, 'check_offensives', $check_offensive_sql);

$add_favorites_sql = "INSERT INTO favorites(user_id,listing_id) VALUES ($1,$2);";
$add_favorite_prepare = pg_prepare($connect, 'add_favorites', $add_favorites_sql);

$remove_favorites_sql = "DELETE FROM favorites WHERE user_id=$1 AND listing_id=$2;";
$remove_favorites_prepare = pg_prepare($connect, 'remove_favorites', $remove_favorites_sql);

$get_favorites_sql = "SELECT listing_id FROM favorites WHERE user_id=$1;";
$get_favorites_prepare = pg_prepare($connect, 'get_favorites', $get_favorites_sql);

$check_favorites_sql = "SELECT COUNT(listing_id) FROM favorites WHERE user_id=$1 AND listing_id=$2;";
$check_favorites_prepare = pg_prepare($connect, 'check_favorites', $check_favorites_sql);

$increment_image_sql = "UPDATE listings SET image = image + 1 WHERE listing_id=$1;";
$increment_image_prepare = pg_prepare($connect, 'increment_image', $increment_image_sql);

$decrement_image_sql = "UPDATE listings SET image = image - 1 WHERE listing_id=$1;";
$decrement_image_prepare = pg_prepare($connect, 'decrement_image', $decrement_image_sql);

$login_sql = "SELECT * FROM users WHERE (user_id = $1 AND password = $2);";
$login_prepare = pg_prepare($connect, 'user_login', $login_sql);

$number_image_sql = "SELECT image FROM listings WHERE listing_id = $1;";
$number_image_prepare = pg_prepare($connect, 'number_image', $number_image_sql);

$update_sql = "UPDATE users SET last_access = $1 WHERE user_id = $2;";	
$update_prepare = pg_prepare($connect, 'user_update', $update_sql);

$user_type_update_sql = "UPDATE users SET user_type=REPLACE(user_type,'d','') WHERE user_id = $1;";
$user_type_update_prepare = pg_prepare($connect,'user_type_update',$user_type_update_sql);

$make_agent_sql = "UPDATE users SET user_type=REPLACE(user_type,'p','') WHERE user_id = $1;";
$make_agent_prepare = pg_prepare($connect,'make_agent',$make_agent_sql);

$record_sql = "SELECT * FROM users WHERE user_id = $1;";	
$record_prepare = pg_prepare($connect, 'user_get_type', $record_sql);

$greeting_sql = "SELECT salutation, first_name, last_name FROM persons WHERE user_id = $1;";
$greeting_prepare = pg_prepare($connect, 'greeting_info', $greeting_sql);

$listing_info_sql = "SELECT headline,price,address,city,image FROM listings WHERE listing_id=$1;";
$listing_info_prepare = pg_prepare($connect, 'listing_info', $listing_info_sql);

$listing_detail_sql = "SELECT headline,price,address,city,image,description,status,property_type,property_options,transaction_type,building_type,heating_type,bedrooms,bathrooms,living_room,kitchen,basement_feature,parking_lot,building_size,land_size,postal_code FROM listings WHERE listing_id=$1;";
$listing_detail_prepare = pg_prepare($connect, 'listing_detail', $listing_detail_sql);

$listing_select_sql = "SELECT headline,price,status,description,property_type,property_options,transaction_type,building_type,heating_type,bedrooms,bathrooms,living_room,kitchen,basement_feature,parking_lot,building_size,land_size,address,city,postal_code,image FROM listings WHERE listing_id=$1 AND user_id=$2;";
$listing_select_prepare = pg_prepare($connect, 'listing_select', $listing_select_sql);

$users_persons_select_sql = "SELECT users.user_type,users.email_address,persons.salutation,persons.first_name,persons.last_name,persons.street_address1,persons.street_address2,persons.city,persons.province,persons.postal_code,persons.primary_phone_number,persons.secondary_phone_number,persons.fax_number,persons.preferred_contact_method FROM users INNER JOIN persons ON users.user_id=persons.user_id WHERE users.user_id=$1 AND persons.user_id=$1;";
$users_persons_select_prepare = pg_prepare($connect, 'users_persons_select', $users_persons_select_sql);

$agent_listing_sql= "SELECT listing_id FROM listings where (user_id = $1) AND (status='o') ORDER BY listings.listing_id DESC;";
$agent_listing_prepare= pg_prepare($connect, 'agent_listing', $agent_listing_sql);

$agent_old_listing_sql= "SELECT listing_id FROM listings where (user_id = $1) AND (status='c' OR status='s') ORDER BY listings.listing_id DESC;";
$agent_old_listing_prepare= pg_prepare($connect, 'agent_old_listing', $agent_old_listing_sql);

$listing_insert_sql = "INSERT INTO listings(user_id,headline,price,status,description,property_type,property_options,transaction_type,building_type,heating_type,bedrooms,bathrooms,living_room,kitchen,basement_feature,parking_lot,building_size,land_size,address,city,postal_code,image)
			VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21,$22)";
$listing_insert_prepare = pg_prepare($connect, 'listing_insert', $listing_insert_sql);

$users_insert_sql = "INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access) 
			VALUES($1, md5($2), $3, $4, $5, $6);";
$users_insert_prepare = pg_prepare($connect, 'users_insert', $users_insert_sql);

$persons_insert_sql = "INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, street_address2, city, province, postal_code, primary_phone_number, secondary_phone_number, fax_number, preferred_contact_method)
			VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13);";
$persons_insert_prepare = pg_prepare($connect, 'persons_insert', $persons_insert_sql);

$persons_update_sql = "UPDATE persons SET salutation=$1,first_name=$2,last_name=$3,street_address1=$4,street_address2=$5,city=$6,province=$7,postal_code=$8,primary_phone_number=$9,secondary_phone_number=$10,fax_number=$11,preferred_contact_method=$12 WHERE user_id=$13;";
$persons_update_prepare = pg_prepare($connect, 'persons_update', $persons_update_sql);

//$users_update_sql = "UPDATE users SET user_type=$1,email_address=$2 WHERE user_id=$3;";
$users_update_sql = "UPDATE users SET email_address=$1 WHERE user_id=$2;";
$users_update_prepare = pg_prepare($connect, 'users_update', $users_update_sql);

$password_update_sql = "UPDATE users SET password = $1 WHERE user_id = $2;";	
$password_update_prepare = pg_prepare($connect, 'password_update', $password_update_sql);

$listing_update_sql = "UPDATE listings SET headline=$1,price=$2,status=$3,description=$4,property_type=$5,property_options=$6,transaction_type=$7,building_type=$8,heating_type=$9,bedrooms=$10,bathrooms=$11,living_room=$12,kitchen=$13,basement_feature=$14,parking_lot=$15,building_size=$16,land_size=$17,address=$18,city=$19,postal_code=$20,image=$21 WHERE listing_id=$22 AND user_id=$23;";
$listing_update_prepare = pg_prepare($connect, 'listing_update', $listing_update_sql);

function build_simple_dropdown($table,$preselected=""){
	$output ="";
	$connect = db_connect();
	$sql = "SELECT * FROM " . $table;
	$result = pg_query($connect, $sql);//salutations or provinces
	$output .= "<select name=" . $table . ">";
	while($row = pg_fetch_array($result)) 
	{
		$value = trim($row[0]);
		if($value == $preselected){
			$output .= "<option value= \"". $value. "\" selected=\"selected\" >" . $value . "</option>";	
		}else{
			//echo $row[0] . " " . $preselected . "<br>";
			$output .= "<option value= ". $value. ">" . $value . "</option>";
		}
	}
	$output .= "</select>";
	return $output;
}

function get_property($table,$value){
	$output ="";
	$connect = db_connect();
	$sql = "SELECT property FROM " . $table . " WHERE value='" . $value . "'";
	$result = pg_query($connect, $sql);
	$records = pg_num_rows($result);
	if($records > 0)
	{
		$output = pg_fetch_result($result,0,"property");
		return $output;
	}else{
		return "No record matched!";
	}
}

function build_dropdown($table, $preselected = ""){
	$output = "";
	$connect = db_connect();
	$sql = "SELECT value from ". $table;
	$result = pg_query($connect,$sql);
	$output .= "<select name=" . $table . ">";
	while($row = pg_fetch_array($result)) 
	{
		$value = trim($row[0]);
		$property = get_property($table, $value);
		if($value == $preselected){
			$output .= "<option value= \"". $value. "\" selected=\"selected\" >" . $property . "</option>";	
		}else{
			$output .= "<option value= ". $value. ">" . $property . "</option>";
		}
	}
	$output .= "</select>";
	return $output;
}

function build_radio($table,$preselected=""){
	$output ="";
	$connect = db_connect();
	$sql = "SELECT * FROM ".$table.";"; 
	$result = pg_query($connect, $sql);//preferred_contact_methods

	while($row = pg_fetch_array($result)) 
	{
		$value = trim($row[0]);
		if($value == $preselected){
			$output .= "<input type=\"radio\" name=\"" . $table . "\" value=\"" . $value . "\" checked=\"checked\" /> " . $row[1] . " ";
		}else{
			$output .= "<input type=\"radio\" name=\"" . $table . "\" value=\"" . $row[0] . "\" /> " . $row[1] . " ";
		}
	}
	return $output;
}

function is_user_id($record){
	$record = pg_escape_string($record);
	$sql = "SELECT user_id FROM users WHERE user_id = '" . $record . "'";
	$connect = db_connect();
	$result = pg_query($connect, $sql);
	$num_rows = pg_num_rows($result);
	if ($num_rows > 0) {
		return true;
	}else {
 		return false;
	}
}

function build_checkbox($table_name,$preselected=""){
	$output="";
	$connect = db_connect();
	$sql = "SELECT * FROM " . $table_name;
	//run the command
	$result = pg_query($connect, $sql);//preferred_contact_methods
	$record = 0;
	while($row = pg_fetch_array($result)) 
	{
		$value = trim($row[0]);
		$property = get_property($table_name, $value);
		if(is_bit_set($record, $preselected)){
			$output .= "<input type=\"checkbox\" name=\"" . $table_name ."[]\" value=\"" . $value . "\" checked=\"checked\" /> " . $property . "<br/>";	
		}else{
			//echo $row[0] . " " . $preselected . "<br>";
			$output .= "<input type=\"checkbox\" name=\"" . $table_name ."[]\" value=\"" . $value . "\" /> " . $property . "<br/>";
		}
		$record++;
	}
	return $output;
}

function pagination_menu($listing_array,$pageNumber){
	$url = strtok($_SERVER["REQUEST_URI"],'?');
	
	$output="";
	$numOfPages = ceil(sizeof($listing_array)/NUM_PER_PAGE);
	if($pageNumber > 1){
		$output .= "<a href=\"".$url."?page=" . "1" . "\">&lt;&lt;</a>";
		$output .= "&nbsp;&nbsp;";
		$output .= "<a href=\"".$url."?page=" . ($pageNumber-1) . "\">&lt;</a>";
		$output .= "&nbsp;";
	}

	for($page = 1; $page <= $numOfPages ; $page++){
		if($pageNumber == $page)
			$output .= $page;
		else
			$output .= "<a href=\"".$url."?page=" . $page . "\"> " . $page . "</a>";
		$output .= "&nbsp;";
	}

	if($pageNumber != $numOfPages){
		$output .= "&nbsp;";
		$output .= "<a href=\"".$url."?page=" . ($pageNumber+1) . "\">&gt;</a>";
		$output .= "&nbsp;&nbsp;";
		$output .= "<a href=\"".$url."?page=" . $numOfPages . "\">&gt;&gt;</a>";
	}
	return $output;
}

function listing_preview($listing_array,$pageNumber,$user_type=""){
//function listing_preview($listing_array,$pageNumber,$user_type){
	$output="";
	$connect = db_connect();
	$output .= "<table><tr><td>No.</td><td>Listings</td><td>Image</td></tr>";

	if($user_type=="a"){

		for($no_listing=($pageNumber - 1) * 10; $no_listing< ($pageNumber * 10) && $no_listing < sizeof($listing_array); $no_listing++){
			$check_status_result = pg_execute($connect, 'check_status', array($listing_array[$no_listing]));
			$check_status=pg_fetch_result($check_status_result, 0, "status");

			$listing_info_execute = pg_execute($connect, 'listing_info', array($listing_array[$no_listing]));
			$listing_info_result = pg_fetch_assoc($listing_info_execute);
	
			$headline = $listing_info_result["headline"]; 			//headline
			$price = $listing_info_result["price"]; 			//price
			$address = $listing_info_result["address"]; 			//address
			$city = get_property("city",$listing_info_result["city"]); 	//city
			$image = $listing_info_result["image"]; 			//image
			
			if($image == 0)	{
				$image = "<div style=\"transform:rotate(15deg)\">" . "NO IMAGE AVAILABLE" . "</div>";
			}else{
				$image = "<img src=\"./listings/" . $listing_array[$no_listing] . "/". $listing_array[$no_listing] . "_" . (1) .".jpg\" alt=\"Image\" style=\"width:128px;height:128px;\">";
			}

			if($check_status==SOLD){
				$image = "<div style=\"transform:rotate(15deg)\">" . "<font color=\"red\">" . "SOLD" . "</font>" . "</div>";
			}

			$output .= "<tr>";
			$output .= "<td>" . ($no_listing+1) . "</td>";
			$output .= "<td>" . $headline . "<br/>" . "$".number_format($price,2) . "<br/>" . $address . "," . $city . "</td>";
			$output .= "<td>" . $image . "</td>";
			if($check_status==CLOSED){
				$output .= "<td>" . "<div style=\"transform:rotate(0deg)\">" . "<font color=\"black\">" . "CLOSED" . "</font>" . "</div>" . "</td>";
			}else if($check_status==SOLD){
				$output .= "<td>" . "<div style=\"transform:rotate(0deg)\">" . "<font color=\"black\">" . "SOLD" . "</font>" . "</div>" . "</td>";
			}else{
				$output .= "<td><input type=\"button\" value=\"Click To Edit\" onclick=\"window.location.href='./listing-update.php?listing_id=" . $listing_array[$no_listing] ."'\" /></td>";
			}
			$output .= "</tr>";
		}
	}elseif($user_type=="c"){
		for($no_listing=($pageNumber - 1) * 10; $no_listing< ($pageNumber * 10) && $no_listing < sizeof($listing_array); $no_listing++){
			$listing_info_execute = pg_execute($connect, 'listing_info', array($listing_array[$no_listing]));
			$listing_info_result = pg_fetch_assoc($listing_info_execute);

			$headline = $listing_info_result["headline"]; 			//headline
			$price = $listing_info_result["price"]; 			//price
			$address = $listing_info_result["address"]; 			//address
			$city = get_property("city",$listing_info_result["city"]); 	//city
			$image = $listing_info_result["image"]; 			//image
		
			if($image == 0)	{
				$image = "<div style=\"transform:rotate(15deg)\">" . "NO IMAGE AVAILABLE" . "</div>";
			}else{
				$image = "<img src=\"./listings/" . $listing_array[$no_listing] . "/". $listing_array[$no_listing] . "_" . (1) .".jpg\" alt=\"Image\" style=\"width:128px;height:128px;\">";
			}

			
			$output .= "<tr>";
			$output .= "<td>" . ($no_listing+1) . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $listing_array[$no_listing] ."'\" />" . $headline . "<br/>" . "$".number_format($price,2) . "<br/>" . $address . "," . $city . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $listing_array[$no_listing] ."'\" />" . $image . "</td>";
			$output .= "<td><input type=\"button\" value=\"Click To View\" onclick=\"window.location.href='./listing-display.php?listing_id=" . $listing_array[$no_listing] ."'\" /><br/><br/>";
			$output .= "<form method=\"post\">";
	
			//check_favorites
			//SELECT listing_id FROM favorites WHERE user_id=$1 AND listing_id=$2;
			//pg_execute($connect, 'get_favorites', array($_SESSION['user_id'],$listing_id));
			//pg_num_rows()==1
			$check_favorites_result=pg_execute($connect, 'check_favorites', array($_SESSION['user_id'],$listing_array[$no_listing]));
			$check_favorites=pg_fetch_result($check_favorites_result, 0, 0);
			
			if($check_favorites==1){
			$output .= "<input type=\"submit\" value=\"Remove favorites\" name=\"" . $listing_array[$no_listing] . "\" />";
			}else if($check_favorites==0){
			$output .= "<input type=\"submit\" value=\"Add to favorites\" name=\"" . $listing_array[$no_listing] . "\" />";
			}
			//$output .= "<input type=\"submit\" value=\"Add to favorites\" name=\"add_favorites\" />";
	
			$output .= "</form>";
			$output .= "</td>";
			$output .= "</tr>";
		}
		//CREATE FOR DELETE AS WELL
		//REMOVE ADD FAVORITE BUTTON WHEN IN WELCOME PAGE	
	
		foreach($listing_array as $value){
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
	}else{
		for($no_listing=($pageNumber - 1) * 10; $no_listing< ($pageNumber * 10) && $no_listing < sizeof($listing_array); $no_listing++){
			$listing_info_execute = pg_execute($connect, 'listing_info', array($listing_array[$no_listing]));
			$listing_info_result = pg_fetch_assoc($listing_info_execute);

			$headline = $listing_info_result["headline"]; 	//headline
			$price = $listing_info_result["price"]; 		//price
			$address = $listing_info_result["address"]; 	//address
			$city = get_property("city",$listing_info_result["city"]); 		//city
			$image = $listing_info_result["image"]; 		//image
		
			if($image == 0)	{
				$image = "<div style=\"transform:rotate(15deg)\">" . "NO IMAGE AVAILABLE" . "</div>";
			}
			
			$output .= "<tr>";
			$output .= "<td>" . ($no_listing+1) . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $listing_array[$no_listing] ."'\" />" . $headline . "<br/>" . "$".number_format($price,2) . "<br/>" . $address . "," . $city . "</td>";
			$output .= "<td onclick=\"window.location='./listing-display.php?listing_id=" . $listing_array[$no_listing] ."'\" />" . $image . "</td>";
			$output .= "<td><input type=\"button\" value=\"Click To View\" onclick=\"window.location.href='./listing-display.php?listing_id=" . $listing_array[$no_listing] ."'\" /></td>";
			$output .= "</tr>";
		}
	}
	$output .= "</table>";
	return $output;
}

function build_search_sql($min_price="",$max_price="",$property_type="",$property_options="",$transaction_type="",$building_type="",$heating_type="",$bedrooms="",$bathrooms="",$living_room="",$kitchen="",$basement_feature="",$parking_lot="",$building_size="",$land_size="",$city="")
{
$listing_search_sql="SELECT listings.listing_id FROM listings WHERE 1 = 1"; 

if(!empty($min_price))
{
	$min_price = pg_escape_string($min_price);
	$listing_search_sql .= " AND listings.price >='". $min_price ."'";
}

if(!empty($max_price))
{
	$max_price = pg_escape_string($max_price);
	$listing_search_sql .= " AND listings.price <='". $max_price ."'";
}

if(!empty($city))
{
	$city = pg_escape_string($city);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++)
	{
		if(is_bit_set($counter, $city))
		{
		$listing_search_sql .= " listings.city ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($property_type))
{
	$property_type = pg_escape_string($property_type);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++)
	{
		if(is_bit_set($counter, $property_type))
		{
		$listing_search_sql .= " listings.property_type ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($property_options))
{
	$property_options = pg_escape_string($property_options);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 5;$counter++)
	{
		if(is_bit_set($counter, $property_options))
		{
		$listing_search_sql .= " listings.property_options ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($transaction_type))
{
	$transaction_type = pg_escape_string($transaction_type);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 2;$counter++)
	{
		if(is_bit_set($counter, $transaction_type))
		{
		$listing_search_sql .= " listings.transaction_type ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($building_type))
{
	$building_type = pg_escape_string($building_type);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 8;$counter++)
	{
		if(is_bit_set($counter, $building_type))
		{
		$listing_search_sql .= " listings.building_type ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($heating_type))
{
	$heating_type = pg_escape_string($heating_type);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 8;$counter++)
	{
		if(is_bit_set($counter, $heating_type))
		{
		$listing_search_sql .= " listings.heating_type ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($bedrooms))
{
	$bedrooms = pg_escape_string($bedrooms);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++)
	{
		if(is_bit_set($counter, $bedrooms))
		{
		$listing_search_sql .= " listings.bedrooms ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($bathrooms))
{
	$bathrooms = pg_escape_string($bathrooms);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++)
	{
		if(is_bit_set($counter, $bathrooms))
		{
		$listing_search_sql .= " listings.bathrooms ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($living_room))
{
	$living_room = pg_escape_string($living_room);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 3;$counter++)
	{
		if(is_bit_set($counter, $living_room))
		{
		$listing_search_sql .= " listings.living_room ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($kitchen))
{
	$kitchen = pg_escape_string($kitchen);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 3;$counter++)
	{
		if(is_bit_set($counter, $kitchen))
		{
		$listing_search_sql .= " listings.kitchen ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($basement_feature))
{
	$basement_feature = pg_escape_string($basement_feature);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 8;$counter++)
	{
		if(is_bit_set($counter, $basement_feature))
		{
		$listing_search_sql .= " listings.basement_feature ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($parking_lot))
{
	$parking_lot = pg_escape_string($parking_lot);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 10;$counter++)
	{
		if(is_bit_set($counter, $parking_lot))
		{
		$listing_search_sql .= " listings.parking_lot ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($building_size))
{
	$building_size = pg_escape_string($building_size);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++)
	{
		if(is_bit_set($counter, $building_size))
		{
		$listing_search_sql .= " listings.building_size ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

if(!empty($land_size))
{
	$landsize = pg_escape_string($land_size);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++)
	{
		if(is_bit_set($counter, $land_size))
		{
		$listing_search_sql .= " listings.land_size ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

$listing_search_sql.=" AND listings.status = '". OPEN ."' ORDER BY listings.listing_id DESC LIMIT " . LIMIT_NUMBER_OF_RECORD;

return $listing_search_sql;
}


//group 08
?>
