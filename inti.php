<?php 

//error reporting
	ini_set('desplay_errors', 'on');
	error_reporting(E_ALL);

	 include 'admin/connect.php';
	$tmp = 'includes/templates/';
	$lang =  'includes/languages/';
	$func = 'includes/function/';
	$css = 'layout/css/';
	$js ='layout/js/';

		//include the important fails
		include $func ."functions.php";
		 include $lang."english.php "; 
		include $tmp ."header.php "; 


	// include navbar in all faila else when exist $nonavbar  
	
 
 ?>