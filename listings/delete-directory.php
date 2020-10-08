<?php

$dir = 1508;
if(isset($_GET['listing_id']))
{
	$dir = $_GET['listing_id'];
}
recursiveDelete($dir);

//at this point you should update the profiles table to set the images
//field back to zero (0) for the user_id you just deleted

/**
 * function will allow Apache to recurisvie delete files and, if applicable, sub-folders recursively
 * @param String $target - the file/directory 
 * @return bool whether the recursive delete occurred or not 
 */
function recursiveDelete($target) {
	if (!file_exists($target)){ //no target, implies nothing to delete, function is done
		echo "No directory/file named " . $target . " to be deleted";
		return true;
	}
	if (!is_dir($target)) {  //target is a file, not a directory, delete it with unlink() function
		return unlink($target); //will return false is Apache does not have write permissions in $target
	}
	
	$directoryContents = scandir($target); //target is a directory, get a list of files and directories inside the specified path as an array
	
	foreach ($directoryContents as $file) { //loop through the target's files and sub-directories
		echo "<br/>File/folder to be deleted: " . $file;
		if ($file == '..' || $file == '.') { //ignore parent and current diectories in file listing
			continue;
		}
		if (!recursiveDelete($target. "/" . $file)) {  //delete items, and sub-directories recursively
			return false;
		}
	}
	return rmdir($target); //delete the original target, now empty
}

?>