<?php

//TO-DO
//image(not sure what to put) n user_id(done) n description(filter data recomended as there is some dangerous character suchas '%sd)

include '../includes/constants.php';
include './headline.php';
include './names.php';
include '../includes/functions.php';
require "../includes/db.php";


$listing_id="";			//Don't need since its in serial
$user_id="";			//To this moment: dduck, lgolding, fcarbone, kcohoon, dmeszaros, gkopps
$status="";			//open, closed, hidden or sold
$headline="";			//array, in headline.php
$price="";			//between 50k to 500k
$description="";		//lorm ipsum thingi
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
$land_size="";			//1-64, 7 options
$address="";			//refer back to the seed_generator.php
$city="";			//refer back to the seed_generator.php
$postal_code="";		//refer back to the seed_generator.php
$images="";			//Not sure

//echo $listing_id . " " . $user_id . " " . $status . " " . $headline . " " . $price . " " . $description . " " . $property_type . " " .$property_options . " " . $transaction_type . " " . $building_type . " " . $heating_type . " " . $bedrooms . " " . $bathrooms . " " . $living_room . " " . $kitchen . " " . $basement_feature . " " . $parking_lot . " " . $building_size . " " . $land_size . " " . $address . " " . $city . " " . $postal_code . " " . $images;			//Not sure

function create_postal_code(){
//define("MAX_POSTAL_CODE",6);
$postal_code_acceptable = array("A","B","C","E","G","H","J","K","L","M","N","P","R","S","T","V","W","X","Y","Z");

for($i=1;$i<=6;$i++)
{
	if($i%2==0)
	{
		$randVal = rand(1,9);
		$postal_code .= $randVal;		
	}else
	{
		$randVal = rand(0,sizeof($postal_code_acceptable)-1);
		$postal_code .= $postal_code_acceptable[$randVal];
	}	
}
return $postal_code;
}

function power_of_two($num)
{
	$result = pow(2,$num);
	return $result;
}

for($x=0;$x<=1500;$x++){

//user_id 
//create a sql query to fetch userid where user_type is agent
$find_agent_sql="SELECT user_id FROM users WHERE user_type='a'";
//echo $find_agent_sql;
$conn = db_connect();
//echo $conn;
$result = pg_query($conn,$find_agent_sql);
$agent_list = array();
while($row = pg_fetch_assoc($result)) {
   $agent_list[] = $row['user_id']; 
if(sizeof($agent_list)==100)
break;
}
$randVal = rand(0,sizeof($agent_list)-1);
$user_id = $agent_list[$randVal];
$user_id = pg_escape_string($user_id);

//create an array then random number
$status_options = array("o","o","o","o","o","o","c","c","h","s","s","s");
$randVal = rand(0,sizeof($status_options)-1);
$status = $status_options[$randVal];

//headline
//fetch an array then random number *the array is on headlines.php
$randVal = rand(0,sizeof($headlines)-1);
$headline = $headlines[$randVal];
$headline = pg_escape_string($headline);

//price
//random number
$randVal = rand(50000,500000);
$price = $randVal;

//description
$description = "Lorem Ipsum";

//property_type
$randVal = rand(0,6);//why 7 because there is only 7 options
$property_type = power_of_two($randVal);//1,2,4... 64, 7 options

//property_option
$randVal = rand(0,4);//why 5 because there is only 5 options
$property_options = power_of_two($randVal);//1-16, 5 options

$randVal = rand(0,1);
$transaction_type = power_of_two($randVal);//SALE or RENT (1,2), 2 options

$randVal = rand(0,7);
$building_type = power_of_two($randVal);//1-128, 8 options

$randVal = rand(0,7);
$heating_type = power_of_two($randVal);//1-128, 8 options

$randVal = rand(0,6);
$bedrooms = power_of_two($randVal);//1-64, 7 options

$randVal = rand(0,6);
$bathrooms = power_of_two($randVal);//1-64, 7 options

$randVal = rand(0,2);
$living_room = power_of_two($randVal);//1-4, 3 options

$randVal = rand(0,2);
$kitchen = power_of_two($randVal);//1-4, 3 options

$randVal = rand(0,7);
$basement_feature = power_of_two($randVal);//1-128, 8 options

$randVal = rand(0,9);
$parking_lot = power_of_two($randVal);//1-512, 10 options

$randVal = rand(0,6);
$building_size = power_of_two($randVal);//1-64, 7 options

$randVal = rand(0,6);
$land_size = power_of_two($randVal);//1-64, 7 options

$address="";			//refer back to the seed_generator.php
define("MIN_STREET_NUMBER",1);
define("MAX_STREET_NUMBER",9999);
$address .= mt_rand(MIN_STREET_NUMBER,MAX_STREET_NUMBER);
//echo $address_one;

$randVal = rand(0,sizeof($street_names)-1);
$address .= " " . $street_names[$randVal];

/*
$cities = array("Abbotsford","Airdrie","Ajax","Aurora","Barrie","Belleville","Blainville","Brampton","Brantford","Brossard","Burlington","Burnaby",
"Caledon","Calgary","Cambridge","Cape Breton","Chatham-Kent","Chilliwack","Clarington","Coquitlam","Delta","Drummondville","Edmonton","Fredericton",
"Gatineau","Granby","Grande Prairie","Greater Sudbury","Guelph","Halifax","Halton Hills","Hamilton","Kamloops","Kawartha Lakes","Kelowna","Kingston",
"Kitchener","Langley","Laval","Lethbridge","London","Longueuil","Maple Ridge","Markham","Medicine Hat","Milton","Mirabel","Mississauga","Moncton","Montreal",
"Nanaimo","New Westminster","Newmarket","Niagara Falls","Norfolk County","North Bay","North Vancouver","North Vancouver","Oakville","Oshawa","Ottawa","Peterborough",
"Pickering","Port Coquitlam","Prince George","Quebec City","Red Deer","Regina","Repentigny","Richmond","Richmond Hill","Saanich","Saguenay","Saint John","Saint-Hyacinthe",
"Saint-Jerome","Saint-Jean-sur-Richelieu","Sarnia","Saskatoon","Sault Ste. Marie","Sherbrooke","St. Albert","St. Catharines","Saint John","St. John","Saint Albert","Saint Catharines",
"Strathcona County","Surrey","Terrebonne","Thunder Bay","Toronto","Trois-Rivieres","Vancouver","Vaughan","Victoria","Waterloo","Welland","Whitby","Windsor","Winnipeg","Wood Buffalo");

$randVal = rand(0,sizeof($cities)-1);
$city= $cities[$randVal];			//refer back to the seed_generator.php * 7 options
*/

$randVal = rand(0,6);
$city = power_of_two($randVal);//1-64, 7 options

do{
$postal_code = create_postal_code();
} while (is_valid_postal_code($postal_code)!=true);

//$images=rand(0,15);			//Not sure
$images =0;
//echo $listing_id . " " . $user_id . " " . $status . " " . $headline . " " . $price . " " . $description . " " . $property_type . " " .$property_options . " " . $transaction_type . " " . $building_type . " " . $heating_type . " " . $bedrooms . " " . $bathrooms . " " . $living_room . " " . $kitchen . " " . $basement_feature . " " . $parking_lot . " " . $building_size . " " . $land_size . " " . $address . " " . $city . " " . $postal_code . " " . $images . " " . is_valid_postal_code($postal_code);			//Not sure

$listing_insert_sql = "INSERT INTO listings (user_id,status,price,headline,description,property_type,property_options,transaction_type,building_type,heating_type,bedrooms,bathrooms,living_room,kitchen,basement_feature,parking_lot,building_size,land_size,address,city,postal_code,image)"
			. " VALUES ('" . $user_id . "','" . $status . "','" . $price . "','" . $headline . "','" . $description . "','" . $property_type . "','" . $property_options . "','" . $transaction_type . "','" . $building_type . "','" . $heating_type . "','" . $bedrooms . "','" . $bathrooms . "','" . $living_room . "','" . $kitchen . "','" . $basement_feature . "','" . $parking_lot . "','" . $building_size . "','" . $land_size . "','" . $address . "','" . $city . "','" . $postal_code . "','" . $images . "');";


//$conn is connection
//commented to prevent data overflow
/*
$result = pg_query($conn,$listing_insert_sql);

if(!$result){
echo $listing_insert_sql . "<br/>";
$x--;
}
$listing_insert_sql="";
*/
}
?>