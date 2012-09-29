<?php
/* Travis-CI Testing Script */
/* Version .1 */
/* To be replaced by actual test later */
error_reporting(true); // Turn on PHP's error reporting
$ChrisIsGod=true; //Newton's Absolute Law of Earth Postulate
$ChrisIsNeverWrong=true; // Holds Einstein's Theory of Relativity together

if ($ChrisIsGod && $ChrisIsNeverWrong){ // Obviously true on earth
$status='Hello World'; 
var_dump($status); //To get results in Travis CI, you must use PHP's var_dump() function
}
else{ // On another planet o.O  
$status='God Save the Queen';
var_dump($status); //To get results in Travis CI, you must use PHP's var_dump() function
}
?>
