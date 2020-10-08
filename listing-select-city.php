<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - listing-update.php
*/

$file = "listing-select-city.php";
$date = "11/19/2019";
$description = "listing select city webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require './header.php';

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}

$total_sum="";
$sum = array();
if(isset($_POST['submit'])){
	if(!empty($_POST["city"])){
		foreach($_POST["city"] as $selected){
			$sum[]=$selected;
		}
		//print_r($sum);
		//$total_sum = sum_check_box($sum);
		$_SESSION['city']=sum_check_box($sum);
		header("location:listing-search.php");
		ob_flush();
	}else{
		echo "Pick at least one city";
	}
}
?>

<div id="bg">
	<table>
		<tr>
			<td>
				<form method="post" action="./listing-select-city.php">
					<script type="text/javascript">
					<!--
					/*NOTE: for the following function to work, on your page
					you have to create a checkbox id'ed as city_toggle
				
					<input type="checkbox"  onclick="toggle(this);" name="city[]" value="0">
			
					and each city checkbox element has to be an named as an 
					array (specifically named "city[]")
					e.g.
					<input type="checkbox" name="city[]" value="1">Ajax
					*/

					function toggle(source) {
						checkboxes = document.getElementsByName('city[]');
						for(i = 0; i < checkboxes.length; i++){
							checkboxes[i].checked = source.checked;
						}
					}
					//-->
					</script>
					<div align="left">
						<input type="checkbox"  onclick="toggle(this);" name="city[]" value="0" /> Select All <br/>
						<?php $test = build_checkbox("city"); echo $test; ?>
					</div>
					<input type='submit' name='submit' value='submit'/>
				</form>
			</td>
			<td>
				<img src="./image/Image_Mapping.png" alt="DurhamRegionMap" usemap="#citymap" />
				<map name="citymap" id="DurhamRegionMap" >
					<area alt="Ajax" title="Ajax" href="./listing-search.php?city=1" coords="43,100,63,133" shape="rect" />
					<area alt="Brooklin" title="Brooklin" href="./listing-search.php?city=2" coords="64,63,187,45" shape="rect" />
					<area alt="Bowmanville" title="Bowmanville" href="./listing-search.php?city=4" coords="129,65,252,147" shape="rect" />
					<area alt="Oshawa" title="Oshawa" href="./listing-search.php?city=8" coords="99,65,127,134" shape="rect" />
					<area alt="Pickering" title="Pickering" href="./listing-search.php?city=16" coords="3,65,41,133" shape="rect" />
					<area alt="Pickering" title="Pickering" href="./listing-search.php?city=16" coords="63,65,4,98" shape="rect" />
					<area alt="Port Perry" title="Port Perry" href="./listing-search.php?city=32" coords="65,1,187,42" shape="rect" />
					<area alt="Whitby" title="Whitby" href="./listing-search.php?city=64" coords="66,65,97,133" shape="rect" />
				</map>
			</td>
		</tr>
	</table>
</div>

<?php
require './footer.php';
?>