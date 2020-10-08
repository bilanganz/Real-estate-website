<?php
include './names.php';
include '../includes/constants.php';
include '../includes/functions.php';
include '../includes/db.php';


for($x=0;$x<=1000;$x++){

//The data on the names.php
$salutation="";
$first_name="";
$last_name="";
$address_one="";
$address_two=""; //Haven't
$city="";
$province="";
$postal_code="";
$phone_number_one="";
$phone_number_two=""; //Haven't
$preferred_contact_method="";
$email = "";
$user_type = "";
$password = "password";

date_default_timezone_set("Canada/Newfoundland");
$now = date("Y-m-d", time());

$gender = array("M","F");
$salutation_option = array("Mr.","Mrs.","Miss","Ms.");

$randVal = rand(0,sizeof($gender)-1);
//echo $randVal; echo $gender[$randVal];
if($gender[$randVal]=="M")
{
$randVal = rand(0,sizeof($male_names)-1);
$first_name = ucfirst(strtolower(strtoupper($male_names[$randVal])));
$salutation = $salutation_option[0];
//echo $first_name; echo $salutation;
}elseif($gender[$randVal]=="F")
{
$randVal = rand(0,sizeof($female_names)-1);
$first_name = ucfirst(strtolower(strtoupper($female_names[$randVal])));
$randVal = rand(1,sizeof($salutation_option)-1);
$salutation = $salutation_option[$randVal];
//echo $first_name; echo $salutation;
}
if(isset($first_name))
{
$randVal = rand(0,sizeof($last_names)-1);
$last_name = ucfirst(strtolower(strtoupper($last_names[$randVal])));
//echo $last_name;
}
//define("num_of_gender",2);

$email_domain = array("gmail", "yahoo", "hotmail", "aol", "msn", "live");
$randVal = rand(0,sizeof($email_domain)-1);
$email .= $last_name . substr($first_name,1) . "@" . $email_domain[$randVal] . ".com";
$email = strtolower($email);
//echo $email . "<br/>";

$user_type_list = array("s","a","a","a","a","a","a","a","c","c","c","c","c","c","c","c","c","c","c");
$randVal = rand(0,sizeof($user_type_list)-1);
$user_type = $user_type_list[$randVal];
//echo $user_type . "<br/>";

define("MIN_STREET_NUMBER",1);
define("MAX_STREET_NUMBER",9999);
$address_one .= mt_rand(MIN_STREET_NUMBER,MAX_STREET_NUMBER);
//echo $address_one;

$randVal = rand(0,sizeof($street_names)-1);
$address_one .= " " . $street_names[$randVal];
//echo $address_one;

/*
// Cited from https://pe.usps.com/text/pub28/28apc_002.htm
//"ALY", "ANX, "ARC", "AVE", "BYU", "BCH", "BND", "BLF", "BLFS", "BTM", "BLVD", "BR", "BRG", "BRK", "BG", "BYP", "CP", "CYN", "CPE", "CSWY", "CTR", "CIR", "CLF", "CLB", "CMN", "COR", "CRSE", "CT", "CV", "CRK", "CRST", "XING", "XRD", "CURV", "DL", "DM", "DV", "DR", "EST"
$street_abbreviations = array("Ave", "Rd", "St", "Ln", "Dr", "Way", "Pl", "Blvd");
$randVal = rand(0,sizeof($street_abbreviations)-1);
$address_one .=" " . $street_abbreviations[$randVal];
echo $address_one;
*/

//$canada_province = array("Alberta","British Columbia","Manitoba","New Brunswick","Newfoundland and Labrador","Northwest Territories","Nova Scotia","Nunavut","Ontario","Prince Edward Island","Quebec","Saskatchewan","Yukon");
$canada_province = array("AB","BC","MB","NB","NF","NS","NT","NU","ON","PE","PQ","SK","YT");

//define("num_of_province",13);

/*
$city_alberta = array("Airdrie","Beaumont","Brooks","Calgary","Camrose","Chestermere","Cold Lake","Edmonton","Fort Saskatchewan","Grande Prairie","Lacombe","Leduc","Lethbridge","Lloydminster","Medicine Hat","Red Deer","Spruce Grove","St. Albert","Wetaskiwin");
$city_british_columbia = array("Abbotsford","Armstrong","Burnaby","Campbell River","Castlegar","Chiliwack","Colwood","Coquitlam","Courtenay","Cranbrook","Dawson Creek","Delta","Duncan","Enderby","Fernie","Fort St. John","Grand Forks","Greenwood","Kamloops","Kelowna","Kimberley","Langford","Langley","Maple Ridge","Merritt","Nanaimo","Nelson","New Westminster","North Vancouver","Parksville","Penticton","Pit Meadows","Port Alberni","Port Coquitlam","Port Moody","Powell River","Prince George","Prince Rupert","Quesnel","Revelstoke","Richmond","Rossland","Salmon Arm","Surrey","Terrace","Trail","Vancouver","Vernon","Victoria","West Kelowna","White Rock","Williams Lake");
$city_manitoba = array("Brandon","Dauphin","Flin Flon","Morden","Portage la Prairie","Selkirk","Steinbach","Thompson","Winkler","Winnipeg");
$city_new_brunswick = array("Bathurst","Campbelton","Dieppe","Edmundston","Fredericton","Miramichi","Moncton","Saint John");
// do we put \ escape character for the '
$city_newfoundland_and_labrador = array("Corner Brook","Mount Pearl","St. John's");
$city_northwest_territories = array("Yellowknife");
$city_nova_scotia = array("Halifax","Sydney","Dartmouth");
$city_nunavut = array("Iqaluit");
$city_ontario = array("Barrie","Belleville","Brampton","Brant","Brantford","Brockville","Burlington","Cambridge","Clarence-Rockland","Cornwall","Dryden","Elliot Lake","Greater Sudbury","Guelph","Haldimand County","Hamilton","Kawartha Lakes","Kenora","Kingston","Kitchener","London","Markham","Mississauga","Niagara Falls","Norfold Country","North Bay","Orillia","Oshawa","Ottawa","Owen Sound","Pembroke","Peterborough","Pickering","Port Colborne","Prince Edward County","Quinte West","Richmond Hill","Sarnia","Sault Ste. Marie","St. Catharines","St. Thomas","Stratford","Temiskaming Shores","Thorold","Thunder Bay","Timmins","Toronto","Vaughan","Waterloo","Welland","Windsor","Woodstock");
$city_prince_edward_island = array("Charlottetown","Summerside");
$city_quebec = array ("Acton Vale","Alma","Amos","Amqui","Asbestos","Baie-Comeau","Baie-D'Urfé","Baie-Saint-Paul","Barkmere","Beaconsfield","Beauceville","Beauharnois","Beaupré","Bécancour","Bedford","Belleterre","Beloeil","Berthierville","Blainville","Boisbriand","Bois-des-Filion","Bonaventure","Boucherville","Brome Lake","Bromont","Brossard","Brownsburg-Chatham","Candiac","Cap-Chat","Cap-Santé","Carignan","Carleton-sur-Mer","Causapscal","Chambly","Chandler","Chapais","Charlemagne","Châteauguay","Château-Richer","Chibougamau","Clermont","Coaticook","Contrecoeur","Cookshire-Eaton","Côte Saint-Luc","Coteau-du-Lac","Cowansville","Danville","Daveluyville","Dégelis","Delson","Desbiens","Deux-Montagnes","Disraeli","Dolbeau-Mistassini","Dollard-des-Ormeaux","Donnacona","Dorval","Drummondville","Dunham","Duparquet","East Angus","Estérel","Farnham","Fermont","Forestville","Fossambault-sur-le-Lac","Gaspé","Gatineau","Gracefield","Granby","Grande-Rivière","Hampstead","Hudson","Huntingdon","Joliette","Kingsey Falls","Kirkland","La Malbaie","La Pocatière","La Prairie","La Sarre","La Tuque","Lac-Delage","Lachute","Lac-Mégantic","Lac-Saint-Joseph","Lac-Sergent","L'Ancienne-Lorette","L'Assomption","Laval","Lavaltrie","Lebel-sur-Quévillon","L'Épiphanie","Léry","Lévis","L'Île-Cadieux","L'Île-Dorval","L'Île-Perrot","Longueuil","Lorraine","Louiseville","Macamic","Magog","Malartic","Maniwaki","Marieville","Mascouche","Matagami","Matane","Mercier","Métabetchouan–Lac-à-la-Croix","Métis-sur-Mer","Mirabel","Mont-Joli","Mont-Laurier","Montmagny","Montreal","Montreal West","Montréal-Est","Mont-Saint-Hilaire","Mont-Tremblant","Mount Royal","Murdochville","Neuville","New Richmond","Nicolet","Normandin","Notre-Dame-de-l'Île-Perrot","Notre-Dame-des-Prairies","Otterburn Park","Paspébiac","Percé","Pincourt","Plessisville","Pohénégamook","Pointe-Claire","Pont-Rouge","Port-Cartier","Portneuf","Prévost","Princeville","Québec","Repentigny","Richelieu","Richmond","Rimouski","Rivière-du-Loup","Rivière-Rouge","Roberval","Rosemère","Rouyn-Noranda","Saguenay","Saint-Augustin-de-Desmaures","Saint-Basile","Saint-Basile-le-Grand","Saint-Bruno-de-Montarville","Saint-Césaire","Saint-Colomban","Saint-Constant","Sainte-Adèle","Sainte-Agathe-des-Monts","Sainte-Anne-de-Beaupré","Sainte-Anne-de-Bellevue","Sainte-Anne-des-Monts","Sainte-Anne-des-Plaines","Sainte-Catherine","Sainte-Catherine-de-la-Jacques-Cartier","Sainte-Julie","Sainte-Marguerite-du-Lac-Masson","Sainte-Marie","Sainte-Marthe-sur-le-Lac","Sainte-Thérèse","Saint-Eustache","Saint-Félicien","Saint-Gabriel","Saint-Georges","Saint-Hyacinthe","Saint-Jean-sur-Richelieu","Saint-Jérôme","Saint-Joseph-de-Beauce","Saint-Joseph-de-Sorel","Saint-Lambert","Saint-Lazare","Saint-Lin-Laurentides","Saint-Marc-des-Carrières","Saint-Ours","Saint-Pamphile","Saint-Pascal","Saint-Pie","Saint-Raymond","Saint-Rémi","Saint-Sauveur","Saint-Tite","Salaberry-de-Valleyfield","Schefferville","Scotstown","Senneterre","Sept-Îles","Shawinigan","Sherbrooke","Sorel-Tracy","Stanstead","Sutton","Témiscaming","Témiscouata-sur-le-Lac","Terrebonne","Thetford Mines","Thurso","Trois-Pistoles","Trois-Rivières","Valcourt","Val-d'Or","Varennes","Vaudreuil-Dorion","Victoriaville","Ville-Marie","Warwick","Waterloo","Waterville","Westmount","Windsor");
$city_saskatchewan = array("Estevan","Flin Flon","Humboldt","Lloydminster","Martensville","Meadow Lake","Melfort","Melville","Moose Jaw","North Battleford","Prince Albert","Regina","Saskatoon","Swift Current","Warman","Weyburn","Yorkton");
$city_yukon = array("Whitehorse");
$city_per_province = array($city_alberta,$city_british_columbia,$city_manitoba,$city_new_brunswick,$city_newfoundland_and_labrador,$city_northwest_territories,$city_nova_scotia,$city_nunavut,$city_ontario,$city_prince_edward_island,$city_quebec,$city_saskatchewan,$city_yukon);
*/

$city_alberta = array("Airdrie","Beaumont","Brooks","Calgary","Camrose","Chestermere","Cold Lake","Edmonton","Fort Saskatchewan","Grande Prairie","Lacombe","Leduc","Lethbridge","Lloydminster","Medicine Hat","Red Deer","Spruce Grove","St. Albert","Wetaskiwin");
$city_british_columbia = array("Abbotsford","Armstrong","Burnaby","Campbell River","Castlegar","Chiliwack","Colwood","Coquitlam","Courtenay","Cranbrook","Dawson Creek","Delta","Duncan","Enderby","Fernie","Fort St. John","Grand Forks","Greenwood","Kamloops","Kelowna","Kimberley","Langford","Langley","Maple Ridge","Merritt","Nanaimo","Nelson","New Westminster","North Vancouver","Parksville","Penticton","Pit Meadows","Port Alberni","Port Coquitlam","Port Moody","Powell River","Prince George","Prince Rupert","Quesnel","Revelstoke","Richmond","Rossland","Salmon Arm","Surrey","Terrace","Trail","Vancouver","Vernon","Victoria","West Kelowna","White Rock","Williams Lake");
$city_manitoba = array("Brandon","Dauphin","Flin Flon","Morden","Portage la Prairie","Selkirk","Steinbach","Thompson","Winkler","Winnipeg");
$city_new_brunswick = array("Bathurst","Campbelton","Dieppe","Edmundston","Fredericton","Miramichi","Moncton","Saint John");
// do we put \ escape character for the '
$city_newfoundland_and_labrador = array("Corner Brook","Mount Pearl","St. John's");
$city_northwest_territories = array("Yellowknife");
$city_nova_scotia = array("Halifax","Sydney","Dartmouth");
$city_nunavut = array("Iqaluit");
$city_ontario = array("Barrie","Belleville","Brampton","Brant","Brantford","Brockville","Burlington","Cambridge","Clarence-Rockland","Cornwall","Dryden","Elliot Lake","Greater Sudbury","Guelph","Haldimand County","Hamilton","Kawartha Lakes","Kenora","Kingston","Kitchener","London","Markham","Mississauga","Niagara Falls","Norfold Country","North Bay","Orillia","Oshawa","Ottawa","Owen Sound","Pembroke","Peterborough","Pickering","Port Colborne","Prince Edward County","Quinte West","Richmond Hill","Sarnia","Sault Ste. Marie","St. Catharines","St. Thomas","Stratford","Temiskaming Shores","Thorold","Thunder Bay","Timmins","Toronto","Vaughan","Waterloo","Welland","Windsor","Woodstock");
$city_prince_edward_island = array("Charlottetown","Summerside");
$city_quebec = array ("Acton Vale","Alma","Amos","Amqui","Asbestos","Baie-Comeau","Baie-D'Urfe","Baie-Saint-Paul","Barkmere","Beaconsfield","Beauceville","Beauharnois","Beaupre","Becancour","Bedford","Belleterre","Beloeil","Berthierville","Blainville","Boisbriand","Bois-des-Filion","Bonaventure","Boucherville","Brome Lake","Bromont","Brossard","Brownsburg-Chatham","Candiac","Cap-Chat","Cap-Sante","Carignan","Carleton-sur-Mer","Causapscal","Chambly","Chandler","Chapais","Charlemagne","Chateauguay","Chateau-Richer","Chibougamau","Clermont","Coaticook","Contrecoeur","Cookshire-Eaton","Cote Saint-Luc","Coteau-du-Lac","Cowansville","Danville","Daveluyville","Degelis","Delson","Desbiens","Deux-Montagnes","Disraeli","Dolbeau-Mistassini","Dollard-des-Ormeaux","Donnacona","Dorval","Drummondville","Dunham","Duparquet","East Angus","Esterel","Farnham","Fermont","Forestville","Fossambault-sur-le-Lac","Gaspe","Gatineau","Gracefield","Granby","Grande-Riviere","Hampstead","Hudson","Huntingdon","Joliette","Kingsey Falls","Kirkland","La Malbaie","La Pocatiere","La Prairie","La Sarre","La Tuque","Lac-Delage","Lachute","Lac-Megantic","Lac-Saint-Joseph","Lac-Sergent","L'Ancienne-Lorette","L'Assomption","Laval","Lavaltrie","Lebel-sur-Quevillon","L'epiphanie","Lery","Levis","L'ile-Cadieux","L'ile-Dorval","L'ile-Perrot","Longueuil","Lorraine","Louiseville","Macamic","Magog","Malartic","Maniwaki","Marieville","Mascouche","Matagami","Matane","Mercier","Metabetchouan–Lac-a-la-Croix","Metis-sur-Mer","Mirabel","Mont-Joli","Mont-Laurier","Montmagny","Montreal","Montreal West","Montreal-Est","Mont-Saint-Hilaire","Mont-Tremblant","Mount Royal","Murdochville","Neuville","New Richmond","Nicolet","Normandin","Notre-Dame-de-l'ile-Perrot","Notre-Dame-des-Prairies","Otterburn Park","Paspebiac","Perce","Pincourt","Plessisville","Pohenegamook","Pointe-Claire","Pont-Rouge","Port-Cartier","Portneuf","Prevost","Princeville","Quebec","Repentigny","Richelieu","Richmond","Rimouski","Riviere-du-Loup","Riviere-Rouge","Roberval","Rosemere","Rouyn-Noranda","Saguenay","Saint-Augustin-de-Desmaures","Saint-Basile","Saint-Basile-le-Grand","Saint-Bruno-de-Montarville","Saint-Cesaire","Saint-Colomban","Saint-Constant","Sainte-Adele","Sainte-Agathe-des-Monts","Sainte-Anne-de-Beaupre","Sainte-Anne-de-Bellevue","Sainte-Anne-des-Monts","Sainte-Anne-des-Plaines","Sainte-Catherine","Sainte-Catherine-de-la-Jacques-Cartier","Sainte-Julie","Sainte-Marguerite-du-Lac-Masson","Sainte-Marie","Sainte-Marthe-sur-le-Lac","Sainte-Therese","Saint-Eustache","Saint-Felicien","Saint-Gabriel","Saint-Georges","Saint-Hyacinthe","Saint-Jean-sur-Richelieu","Saint-Jerome","Saint-Joseph-de-Beauce","Saint-Joseph-de-Sorel","Saint-Lambert","Saint-Lazare","Saint-Lin-Laurentides","Saint-Marc-des-Carrieres","Saint-Ours","Saint-Pamphile","Saint-Pascal","Saint-Pie","Saint-Raymond","Saint-Remi","Saint-Sauveur","Saint-Tite","Salaberry-de-Valleyfield","Schefferville","Scotstown","Senneterre","Sept-iles","Shawinigan","Sherbrooke","Sorel-Tracy","Stanstead","Sutton","Temiscaming","Temiscouata-sur-le-Lac","Terrebonne","Thetford Mines","Thurso","Trois-Pistoles","Trois-Rivieres","Valcourt","Val-d'Or","Varennes","Vaudreuil-Dorion","Victoriaville","Ville-Marie","Warwick","Waterloo","Waterville","Westmount","Windsor");
$city_saskatchewan = array("Estevan","Flin Flon","Humboldt","Lloydminster","Martensville","Meadow Lake","Melfort","Melville","Moose Jaw","North Battleford","Prince Albert","Regina","Saskatoon","Swift Current","Warman","Weyburn","Yorkton");
$city_yukon = array("Whitehorse");
$city_per_province = array($city_alberta,$city_british_columbia,$city_manitoba,$city_new_brunswick,$city_newfoundland_and_labrador,$city_northwest_territories,$city_nova_scotia,$city_nunavut,$city_ontario,$city_prince_edward_island,$city_quebec,$city_saskatchewan,$city_yukon);

$randVal = rand(0,sizeof($canada_province)-1);
$province = $canada_province[$randVal];
$identifier = $randVal;

$randVal2 = rand(0,sizeof($city_per_province[$identifier])-1);
$city = $city_per_province[$identifier][$randVal2];
//echo $city; echo $province;

/*
//https://www.quora.com/How-many-cities-are-there-in-Canada
$city = array("Abbotsford","Airdrie","Ajax","Aurora","Barrie","Belleville","Blainville","Brampton","Brantford","Brossard","Burlington","Burnaby",
"Caledon","Calgary","Cambridge","Cape Breton","Chatham-Kent","Chilliwack","Clarington","Coquitlam","Delta","Drummondville","Edmonton","Fredericton",
"Gatineau","Granby","Grande Prairie","Greater Sudbury","Guelph","Halifax","Halton Hills","Hamilton","Kamloops","Kawartha Lakes","Kelowna","Kingston",
"Kitchener","Langley","Laval","Lethbridge","London","Longueuil","Maple Ridge","Markham","Medicine Hat","Milton","Mirabel","Mississauga","Moncton","Montreal",
"Nanaimo","New Westminster","Newmarket","Niagara Falls","Norfolk County","North Bay","North Vancouver","North Vancouver","Oakville","Oshawa","Ottawa","Peterborough",
"Pickering","Port Coquitlam","Prince George","Quebec City","Red Deer","Regina","Repentigny","Richmond","Richmond Hill","Saanich","Saguenay","Saint John","Saint-Hyacinthe",
"Saint-Jerome","Saint-Jean-sur-Richelieu","Sarnia","Saskatoon","Sault Ste. Marie","Sherbrooke","St. Albert","St. Catharines","Saint John","St. John","Saint Albert","Saint Catharines",
"Strathcona County","Surrey","Terrebonne","Thunder Bay","Toronto","Trois-Rivieres","Vancouver","Vaughan","Victoria","Waterloo","Welland","Whitby","Windsor","Winnipeg","Wood Buffalo");
*/

define("MAX_POSTAL_CODE",6);
$postal_code_alberta = array("T");
$postal_code_british_columbia = array("V");
$postal_code_manitoba = array("R");
$postal_code_new_brunswick = array("E");
$postal_code_newfoundland_and_labrador = array("A");
$postal_code_northwest_territories = array("X");
$postal_code_nova_scotia = array("B");
$postal_code_nunavut = array("X");
$postal_code_ontario = array("K","L","M","N","P");
$postal_code_prince_edward_island = array("C");
$postal_code_quebec = array("G","H","J");
$postal_code_saskatchewan = array("S");
$postal_code_yukon = array("Y");
$postal_code_per_province = array($postal_code_alberta,$postal_code_british_columbia,$postal_code_manitoba,$postal_code_new_brunswick,$postal_code_newfoundland_and_labrador,$postal_code_northwest_territories,$postal_code_nova_scotia,$postal_code_nunavut,$postal_code_ontario,$postal_code_prince_edward_island,$postal_code_quebec,$postal_code_saskatchewan,$postal_code_yukon);

$postal_code_exception = array("D","F","I","O","Q","U");
$postal_code_acceptable = array("A","B","C","E","G","H","J","K","L","M","N","P","R","S","T","V","W","X","Y","Z");

for($i=1;$i<=MAX_POSTAL_CODE;$i++)
{
	if($i==1)
	{
	$randVal2 = rand(0,sizeof($postal_code_per_province[$identifier])-1);
	$postal_code .= $postal_code_per_province[$identifier][$randVal2];
	}
	elseif($i%2==0)
	{
		$randVal = rand(1,9);
		$postal_code .= $randVal;		
	}else
	{
		$randVal = rand(0,sizeof($postal_code_acceptable)-1);
		$postal_code .= $postal_code_acceptable[$randVal];
	}	
}
//echo $postal_code;

//$phone_number_one .= "(";
$phone_number_area = rand(MIN_AREA_PHONE_NUMBER,MAX_AREA_PHONE_NUMBER);
$phone_number_one .= $phone_number_area;
//$phone_number_one .= ")";

$phone_number_exchange = rand(MIN_AREA_PHONE_NUMBER,MAX_AREA_PHONE_NUMBER);
$phone_number_one .= $phone_number_exchange;

$phone_number_generator = str_pad(rand(0,9999), 4, '0', STR_PAD_LEFT);
$phone_number_one .= $phone_number_generator;
//$phone_number_one = substr_replace( $phone_number_one, "-", 8, 0 );
//echo $phone_number_one;

$preferred_contact_option = array(EMAIL,PHONE,POSTED_MAIL);
$randVal = rand(0,sizeof($preferred_contact_option)-1);
$preferred_contact_method = $preferred_contact_option[$randVal];
//echo $preferred_contact_method;

$display_phone=display_phone_number($phone_number_one);
//echo $postal_code;
$valid_postal = is_valid_postal_code($postal_code);

$valid_email = is_valid_email($email);
//echo $valid_email;

$valid_phone_number = is_valid_phone($phone_number_one);
//echo $valid_phone_number;

//echo " " . $valid_postal . "<br/>";

$user_id= substr($first_name, 0 , 1).$last_name;
$user_id = strtolower($user_id);

$hash_algorithm="md5";
$password = hash($hash_algorithm, $password);

echo $user_id . " " . $salutation . " " . $first_name . " " . $last_name . " " . $address_one . " " . $city . " " . $province . " " . $postal_code . " " . $valid_postal . " " . $display_phone . " " . $preferred_contact_method . "<br>";
echo $user_id . " " . $password . " " . $user_type . " " . $email . " " . $now . " " . $now . "<br>";

//TO-DO
//SQL data injection
//Change the loop instead of 10 to 1000
//Commented to prevent data overflowing
/*
$connect = db_connect();

$user_insert_sql = "INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES($1,$2,$3,$4,$5,$6);";
$person_insert_sql = "INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10);";

$user_insert_prepare = pg_prepare($connect, 'user_insert', $user_insert_sql);
$person_insert_prepare = pg_prepare($connect, 'person_insert', $person_insert_sql);

$user_insert_result = pg_execute($connect, 'user_insert', array($user_id,$password,$user_type,$email,$now,$now));
$person_insert_result = pg_execute($connect, 'person_insert', array($user_id,$salutation,$first_name,$last_name,$address_one,$city,$province,$postal_code,$phone_number_one,$preferred_contact_method));
*/
		
$salutation="";
$first_name="";
$last_name="";
$address_one="";
$address_two=""; //Haven't
$city="";
$province="";
$postal_code="";
$phone_number_one="";
$phone_number_two=""; //Haven't
$preferred_contact_method="";
$email ="";
$user_type = "";
$password = "password";
$user_id="";


}

?>