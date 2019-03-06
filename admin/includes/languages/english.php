<?php 
function lang( $phrase){

	static $lang = array(
		'HOME_ADMIN'	 =>'Home' ,
		'CATEGORIES'	 => 'CATEGORIES',
		'ITEMS' 		 =>'ITEMS' ,
		'MEMBERS' 		 => 'MEMBERS',
		'COMMENTS'		 => 'COMMENTS',
		 );
	
	return $lang[$phrase];
}

 ?>