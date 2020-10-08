<?php

//TAKEN FROM StackOverflow on 12/5/2019, credit to brandonscript
//https://stackoverflow.com/questions/21030978/php-component-that-generares-random-string-from-regex
function generatePassword($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 


function display_copyright()
{
echo "&copy;" . date("Y") . " OVO";
}


function display_phone_number($num)
{
	if(isset($num))
	{
		if(is_numeric($num))
		{
			if(preg_match('/^\d{10}$/',$num)) // phone number is valid
			{
			$num = substr_replace( $num, "(", 0, 0 );
			$num = substr_replace( $num, ")", 4, 0 );
			$num = substr_replace( $num, "-", 8, 0 );
			}
			elseif(preg_match('/^\d{10,15}$/',$num)) // phone number is valid
			{
			$num = substr_replace( $num, "(", 0, 0 );
			$num = substr_replace( $num, ")", 4, 0 );
			$num = substr_replace( $num, "-", 8, 0 );
			$num = substr_replace( $num, "ext.", 13, 0 );			
			}
			else // phone number is not valid
			{
				$num = 'Phone number invalid !';
			}
		}else
		{
			$num = "Phone number should be numeric!";
		}
	}else
	{
		$num = 'empty phone number!';
	}
return $num;
}

/*
	this function should be passed a integer power of 2, and any decimal number,
	it will return true (1) if the power of 2 is contain as part of the decimal argument
*/
function is_bit_set($power, $decimal) {
	if((pow(2,$power)) & ($decimal)) 
		return 1;
	else
		return 0;
} 

/*
	this function can be passed an array of numbers (like those submitted as 
	part of a named[] check box array in the $_POST array).
*/
function sum_check_box($array)
{
	$num_checks = count($array); 
	$sum = 0;
	for ($i = 0; $i < $num_checks; $i++)
	{
	  $sum += $array[$i]; 
	}
	return $sum;
}

function is_valid_postal_code($postal)
{
	$canada = '/\\A\\b[ABCEGHJKLMNPRSTVXY][0-9][A-Z][ ]?[0-9][A-Z][0-9]\\b\\z/i';
	return preg_match($canada, $postal);
}//By mpezzi gist::1171590

function is_valid_email($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    return 1;
	} else {
	    return 0;
	}
}

function is_valid_phone($phone)
{
	if(preg_match("/^([1]-)?[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/i", $phone)) {
		return 1;
	} else{
		return 0;
	}
}

?>
