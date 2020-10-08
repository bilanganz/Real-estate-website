<?php
include "constants.php";
include "db.php";
include "functions.php";
$conn = db_connect();
/*
$user_id='lpesina';
if($disable_user_result = pg_execute($connect, 'disable_user', array($user_id))){
			echo "Sucesfully Disabled!";
		}else{
			echo "failed disabled!";
		}
*/


//SET MAIN IMAGE
/*
$listing_id=3;
echo "<form method=\"post\">
  <input type=\"radio\" name=\"main_image\" value=1> First Picture<br>
  <input type=\"radio\" name=\"main_image\" value=2> Second Picture<br>
  <input type=\"radio\" name=\"main_image\" value=3> Third Picture<br>
  <input type=\"radio\" name=\"main_image\" value=4> Fourth Picture<br>
  <input type=\"radio\" name=\"main_image\" value=5> Fifth Picture<br>
  <input type=\"submit\" value=\"Submit\">
</form>
";

//echo $_POST['main_image'];

if(isset($_POST['main_image'])){
	$image_number = $_POST['main_image'];
	$old_file=$listing_id . "_" . "1" . ".jpg";
	$new_file=$listing_id . "_" . ($image_number). ".jpg";
	$temp_file=$listing_id . "_" . "0" . ".jpg";
	
	if(rename($listing_id."/".$old_file,$listing_id."/".$temp_file)){
		echo "Successfully changed to temporary folder";

		if(rename($listing_id."/".$new_file,$listing_id."/".$old_file)){
			echo "Old File:" . $listing_id . "_" . ($counter+1) . "<br/>";
			echo "New File:" . $listing_id . "_" . $counter . "<br/>";
			if(rename($listing_id."/".$temp_file,$listing_id."/".$new_file))
				echo "Have Changed";
		}
	}
	
}
*/

/*
//DELETE IMAGE
//GET INPUT FROM RADIO BUTTON

$delete_pic;
echo "<form method=\"post\">
  <input type=\"checkbox\" name=\"images[]\" value=1> First Picture<br>
  <input type=\"checkbox\" name=\"images[]\" value=2> Second Picture<br>
  <input type=\"checkbox\" name=\"images[]\" value=3> Third Picture<br>
  <input type=\"checkbox\" name=\"images[]\" value=4> Fourth Picture<br>
  <input type=\"checkbox\" name=\"images[]\" value=5> Fifth Picture<br>
  <input type=\"submit\" value=\"Submit\">
</form>
";
$listing_id=3;
$num_image=5;


//echo is_array($_POST["images"]);
//print_r($_POST["images"]);
//$lists=$_POST["images"].sort();
//echo count($_POST["images"]);

if(is_array($_POST["images"])&&!empty($_POST["images"])){
	$number_image_result = pg_execute($conn,'number_image',array($listing_id));
	$numPicture = pg_fetch_result($number_image_result, 0, "image");

	for($count = count($_POST["images"]); $count > 0; $count--){
		//echo $count . " ";
		//echo $_POST["images"][$count-1] . "<br/><br/>";
		$remove_file = $listing_id . "_" . $_POST["images"][$count-1] . ".jpg";
		if (file_exists($listing_id."/".$remove_file)){
 			//echo "<br/>Remove: " . $listing_id . "_" . $_POST["images"][$count-1] . "<br/><br/>";
			if(unlink($listing_id. "/" .$remove_file)){
				echo "File (" . $remove_file . ") have been removed.<br/>";
			}else{
				echo "failed to remove " . $listing_id."_".$remove_file ;
			}
			$num_image = $num_image - 1;
			$decrement_image_result = pg_execute($conn,'increment_image',array($listing_id));
		}else{
			echo "File failed to remove.";
		}
		//echo $count . "<br/>";
		for($counter=$_POST["images"][$count-1]; $counter <= ($num_image); $counter++){
			//rename(($listing_id."_".$counter);
			//echo "Old File:" . $listing_id . "_" . ($counter+1) . "<br/>";
			//echo "New File:" . $listing_id . "_" . $counter . "<br/>";
			$old_file=$listing_id . "_" . ($counter+1). ".jpg";
			$new_file=$listing_id . "_" . ($counter). ".jpg";

			//if (file_exists($listing_id."/".$old_file)&&file_exists($listing_id."/".$new_file)){
 				if(rename($listing_id."/".$old_file,$listing_id."/".$new_file)){
					echo "Old File:" . $listing_id . "_" . ($counter+1) . "<br/>";
					echo "New File:" . $listing_id . "_" . $counter . "<br/>";
			//	}
			}else{
				echo "File failed to change. <br/>";
			}
		}
	}
}else{
echo "Invalid Data";
}
*/

/*
function getName($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 
*/

//echo generatePassword(8);

//echo random_bytes(8);

/*
function unique_id($l = 8) {
    return substr(uniqid(,), 0, $l);
}

echo unique_id();
*/
/*
if($check_favorites_result=pg_execute($connect, 'check_favorites', array("ggoat",1511))){
echo "good";
}else{
echo "bad";
}
$check_favorites=pg_fetch_result($check_favorites_result, 0, 0);
echo $check_favorites;
*/
//echo "a";
//echo $conn;

//$test = build_simple_dropdown("salutations","Miss");
//echo $test;

//$test = is_valid_id("ggoat");
//echo $test;

//$test = build_radio("l");
//echo $test;

//$num="12345678901";
//$test = display_phone_number($num);

//$test = get_property("preferred_contact_methods","e");
/*
$test = build_checkbox("city");
echo "<form method='post'>";
echo $test;
echo "<input type='submit' name='submit' value='submit'/>";
echo "</form>";
$total_sum="";
$sum = array();
if(isset($_POST['submit'])){
if(!empty($_POST["city"])){
	foreach($_POST["city"] as $selected){
	$sum[]=$selected;
	}
	//print_r($sum);
	$total_sum = sum_check_box($sum);
	echo $total_sum;
}
}

$listing_search_sql="SELECT listings.listing_id FROM listings WHERE 1 = 1"; 
$property_type = 7;
if(!empty($property_type))
{
	$property_type = pg_escape_string($property_type);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 7;$counter++){
		if(is_bit_set($counter, $property_type)){
		$listing_search_sql .= " listings.property_type ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}

$property_options = 1;
if(!empty($property_options))
{
	$property_options = pg_escape_string($property_options);
	$listing_search_sql .= " AND (";
	for($counter = 0;$counter <= 5;$counter++){
		if(is_bit_set($counter, $property_options)){
		$listing_search_sql .= " listings.property_options ='". pow(2,$counter) ."' OR ";
		}
	}
	$listing_search_sql = substr($listing_search_sql, 0, -4);
	$listing_search_sql .=")";
}
	AND (listings.city = 4 OR listings.city = 8 OR listings.city = 64) 
	AND (listings.bedrooms = 16 OR listings.bedrooms = 32) 
	AND (listings.property_type = 2 OR listings.property_type = 8 OR listings.property_type = 128) 
	AND listings.price >= 125000 AND listings.price <= 300000 

$listing_search_sql.="AND listings.listing_status = \"". OPEN ."\" ORDER BY listings.listing_id DESC LIMIT\"" . LIMIT_NUMBER_OF_RECORD;

echo $listing_search_sql;

echo $_SERVER['REQUEST_URI'];

//$test = build_search_sql("32","128");
//echo $test;
*/
/*
//function set_main_image($listing_id,$file_name){
$listing_id = 1;
$file_name = "1_3";

$number_image_execute = pg_execute($conn, 'number_image', array($listing_id));
$number_image_row = pg_fetch_assoc($number_image_execute);
$number_image = $number_image_row["image"];
echo $number_image;

echo "<br/>";
$image_number = substr($file_name, strpos($file_name, "_") + 1);;
echo $image_number;
*/



/*
echo "<form method=\"post\">";
echo "<input type=\"submit\" value=\"Add to favorites\" name=\"add_favorites\" />";
echo "</form>";

foreach($listing_array as $value){
	if(isset($_POST[$value])){
		echo $value;
	}

}

for($counter=0;$counter<=sizeof($listing_array);$counter++){
//echo $_POST['.$listing_array[$counter].'];
if(isset($_POST[$listing_array[$counter]])){
		echo $listing_array[$counter];
		//echo "1511";
}
}
*/




/*
$number_image_execute=pg_query($conn,"SELECT image FROM listings where listing_id='1'");
$number_image_result = pg_fetch_assoc($number_image_execute);
$number_image = $number_image_result["image"];
echo $number_image;
*/
//for($counter = 0;$counter <= 5;$counter++)

//}



?>
<!--<link rel="stylesheet"
    href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="form-price-range-filter">
    <form method="post" action="">
        <div>
            <input type="" id="min" name="min_price"
                value="<?php echo $min; ?>">
            <div id="slider-range"></div>
            <input type="" id="max" name="max_price"
                value="<?php echo $max; ?>">
        </div>
        <div>
            <input type="submit" name="submit_range"
                value="Filter Product" class="btn-submit">
        </div>
    </form>
</div>

<img src="../image/Image_Mapping.jpg" alt="DurhamRegionMap" usemap="#citymap">


<map name="citymap">
  <area target="" alt="Yellow" title="Yellow" href="" coords="5,122,47,61" shape="rect">
  <area target="" alt="Dark Blue" title="Dark Blue" href="" coords="48,79,86,4" shape="rect">
  <area target="" alt="Light Blue" title="Light Blue" href="" coords="128,122,48,78" shape="rect">
  <area target="" alt="Dark Green" title="Dark Green" href="" coords="5,124,29,167" shape="rect">
  <area target="" alt="Dark Green" title="Dark Green" href="" coords="45,143,13,123" shape="rect">
  <area target="" alt="Small Blue" title="Small Blue" href="" coords="45,167,32,145" shape="rect">
  <area target="" alt="Orange" title="Orange" href="" coords="48,123,66,165" shape="rect">
  <area target="" alt="Dark Yellow" title="Dark Yellow" href="" coords="68,123,87,166" shape="rect">
  <area target="" alt="Green" title="Green" href="" coords="90,124,169,175" shape="rect">
</map>
-->