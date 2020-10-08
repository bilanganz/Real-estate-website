<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - register.php
*/

$file = "listing-images.php";
$date = "12/11/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require_once "header.php";
$conn = db_connect();

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
}else{
/*
if(!empty($_SESSION['listing_id'])&&isset($_SESSION['listing_id'])){
	$_SESSION['listing_id'] = $_GET['listing_id'];
	$listing_id = $_SESSION['listing_id'];
}else 
*/

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if((!empty($_GET['listing_id'])&&isset($_GET['listing_id']))){
		$listing_id = $_GET['listing_id'];
		$_SESSION['listing_id'] = $listing_id;
	}else{
		$_SESSION['unauthorized_access'] = "You haven't select any listing!";	
		header("location:dashboard.php");
		ob_flush();
	}

	$get_agent_result = pg_execute($connect, 'get_agent', array($_GET['listing_id']));
	$get_agent=pg_fetch_result($get_agent_result, 0, "user_id");

	if($get_agent!=$_SESSION['user_id']){
		$_SESSION['unauthorized_access'] = "You dont own that listing!";
		header("location:dashboard.php");
       		ob_flush();
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$listing_id = $_SESSION['listing_id'];
	
	$get_agent_result = pg_execute($connect, 'get_agent', array($listing_id));
	$get_agent=pg_fetch_result($get_agent_result, 0, "user_id");

	if($get_agent!=$_SESSION['user_id']){
		$_SESSION['unauthorized_access'] = "You dont own that listing!";
		header("location:dashboard.php");
       		ob_flush();
	}

	if(isset($_POST['btnRemoveImage'])){
		if(is_array($_POST["images"])&&!empty($_POST["images"])){
			$number_image_result = pg_execute($conn,'number_image',array($listing_id));
			$num_image = pg_fetch_result($number_image_result, 0, "image");
	
			for($count = count($_POST["images"]); $count > 0; $count--){
				$remove_file = $listing_id . "_" . $_POST["images"][$count-1] . ".jpg";
				if (file_exists("listings"."/".$listing_id."/".$remove_file)){
		 			if(unlink("listings"."/".$listing_id. "/" .$remove_file)){
						echo "File (" . $remove_file . ") have been removed.<br/>";
					}else{
						echo "failed to remove " . $listing_id."_".$remove_file ;
					}
					$num_image = $num_image - 1;
					$decrement_image_result = pg_execute($conn,'decrement_image',array($listing_id));
				}else{
					echo "File failed to remove.";
				}
				for($counter=$_POST["images"][$count-1]; $counter <= ($num_image); $counter++){
					$old_file=$listing_id . "_" . ($counter+1). ".jpg";
					$new_file=$listing_id . "_" . ($counter). ".jpg";
		
					if(rename("listings"."/".$listing_id."/".$old_file,"listings"."/".$listing_id."/".$new_file)){
						echo "Old File:" . $listing_id . "_" . ($counter+1) . "<br/>";
						echo "New File:" . $listing_id . "_" . $counter . "<br/>";
					}else{
						echo "File failed to change. <br/>";
					}
				}	
				if($num_image==0){
					rmdir("listings"."/".$listing_id);
				}
			}
		}else{
			echo "Invalid Data";
		}
	}

	if(isset($_POST['btnMainImage'])){
		if(isset($_POST['main_image'])&&is_numeric($_POST['main_image'])){
			if($_POST['main_image']!=1){
				$image_number = $_POST['main_image'];
				$old_file=$listing_id . "_" . "1" . ".jpg";
				$new_file=$listing_id . "_" . ($image_number). ".jpg";
				$temp_file=$listing_id . "_" . "0" . ".jpg";
			
				if(rename("listings"."/".$listing_id."/".$old_file, "listings"."/" .$listing_id."/".$temp_file)){
					if(rename("listings"."/".$listing_id."/".$new_file, "listings"."/".$listing_id."/".$old_file)){
						if(rename("listings"."/".$listing_id."/".$temp_file, "listings"."/".$listing_id."/".$new_file)){
							echo "Have Changed";
						}
					}
				}
			}else{
				echo "You already set it to Main Image";
			}
		}else{
			echo "Missing Main Image Selection.";
		}
	}

	if(isset($_POST['btnUploadImage'])){
		if(!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] != 0){
			echo "Problem with file upload.";
		}else{
			$target_dir = './listings/' . $listing_id;
			if(!is_dir($target_dir)){
				mkdir($target_dir);
			}
			$number_image_result = pg_execute($conn,'number_image',array($listing_id));
			$numPicture = pg_fetch_result($number_image_result, 0, "image");
			$numPicture++;
	
			$target_file = $listing_id . "_" . $numPicture.".jpg";
			$uploadOk = 1;
	
			// Check file size
			if($_FILES["fileToUpload"]["size"] > 100000){
				echo "File is an image -  is too big " . $_FILES["fileToUpload"]["size"] . " bytes, must be less than 1000000.";
				$uploadOk = 0;
			}
	
			// Check if file already exists
			if (file_exists($target_dir."/".$target_file)) {
				echo "Sorry, file <i>" . $target_dir."/".$target_file ."</i> already exists.";
				$uploadOk = 0;
			}

			// Allow certain file formats
			if($_FILES["fileToUpload"]["type"] != "image/jpeg" || $_FILES["fileToUpload"]["type"] != "image/jpeg") {
				echo "Sorry, only JPG files are allowed. File you attempted to upload is of type: " . $_FILES["fileToUpload"]["type"];
				$uploadOk = 0;
			}
	
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . "/" . $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
					$increment_image_result = pg_execute($conn,'increment_image',array($listing_id));
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		}
	}
}

//$listing_id = $_GET['listing_id'];
$number_image_result = pg_execute($conn,'number_image',array($listing_id));
$numPicture = pg_fetch_result($number_image_result, 0, "image");

if($numPicture>0&&$numPicture<=MAX_NUMBER_OF_IMAGE){
	$image="";
	$radio="";
	$checkbox="";
	for($count = 1;$count < ($numPicture+1); $count++){
		$image .= "<td>" . "<img src=\"./listings/" . $listing_id . "/". $listing_id . "_" . ($count) .".jpg?rand=" . generatePassword(8) . "\" alt=\"Image\" style=\"width:128px;height:128px;\">" . "</td>";
		$radio .= "<td>" . "<input type=\"radio\" name=\"main_image\" value=\"" . $count . "\" " . ($count == 1 ? "checked=\"checked\"" : "") . ">" . "</td>";
		$checkbox .= "<td>" . "<input type=\"checkbox\" name=\"images[]\" value=\"" . $count . "\" >" . "</td>";
	}
}else{
	$image="<td>Looks Like You havent upload any picture!</td>";
	$radio="";
	$checkbox="";
}

}	
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td><b>Image</b></td> <?php echo $image ?>
		</tr>
		<?php if($numPicture>0){ ?>
		<tr>
			<td><b>Main Image</b></td> <?php echo $radio ?> <td> <input type="submit" value="Set Main Image" name="btnMainImage"> </td>
		</tr>
			<td><b>Click to delete</b></td> <?php echo $checkbox ?> <td> <input type="submit" value="Delete Image" name="btnRemoveImage"> </td>
		<tr>
		<?php } ?>
		</tr>
	</table>
<?php
	if($numPicture>=0&&$numPicture<MAX_NUMBER_OF_IMAGE){
echo '
	<center>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="btnUploadImage">
	</center>
	';
}else{
echo '
	<center>
		<b>Maximum Picture Achived, you have to delete existing picture in order to upload more.</b>
	</center>
	';
}
?>
</form>
