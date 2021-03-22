<!-- 
	 Name of Work Unit:  Utility.php
	 Purpose of Work Unit:  Function that Removes XSS.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This file contains a functions that filteres and removes XSS.
-->

<?php

function RemoveXSS($val) 
{
    //Set's characters to look out for in $pattern vairables
	$pattern = '/</i';					
	$pattern2 = '/>/i';
	$pattern3 = '/:/i';
	$pattern4 = '/;/i';
	$pattern5 = '/{/i';
	$pattern6 = '/}/i';
	$pattern7 = '/#/i';
	$pattern8 = '/%/';
	$pattern9 = '/~/i';
	$pattern10 = "/'/i";
	$pattern11 = '/=/i';
    $pattern12 = '/&/i';
    $pattern13 = '/"/i';
    $pattern14 = '/]/i';
		
    //The pattern supplied in the first argument is replaced by the second argument in $val if the pattern is found in $val
	$val = preg_replace($pattern,'&lt',$val);		
	$val = preg_replace($pattern2,'&gt',$val);		
	$val = preg_replace($pattern3,'&colon',$val);	
	$val = preg_replace($pattern4,'&semi',$val);
	$val = preg_replace($pattern5,'&#x0007B',$val);
	$val = preg_replace($pattern6,'&#x0007D',$val);
	$val = preg_replace($pattern7,'&#35',$val);
	$val = preg_replace($pattern8,'&#37',$val);
	$val = preg_replace($pattern9,'&#8767',$val);
	$val = preg_replace($pattern10,'&#x27',$val);
	$val = preg_replace($pattern11,'&#61;',$val);
    $val = preg_replace($pattern12,'&amp;',$val);
    $val = preg_replace($pattern13,'&quot;',$val);
    $val = preg_replace($pattern14,'&#93;',$val);

    return $val;
}
?>

