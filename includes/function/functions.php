<?php 
		/*
	** Get  all items Function v2.0
	** Function To Get catigories From Database */
	function getallfrom($feild , $table , $where = NULL , $and=NULL , $orderfeild , $ordring = 'DESC'){

		global $con ;
		$getall= $con->prepare("SELECT $feild FROM $table $where $and  ORDER BY $orderfeild $ordring ");
		$getall->execute(array());
		$all= $getall->FetchAll();
		return $all;
	}


	

	/*
** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
	*/
	function checkItem ($select , $from, $value ){

		global $con ;
		$stmt= $con->prepare("SELECT $select FROM $from WHERE $select = ? ");

		$stmt->execute(array($value));

		$count = $stmt->rowcount();

		return $count ;

	}


	/* title function that echo tle page title  */
	function getTitle(){

		global $pageTitle;

	if (isset($pageTitle)) {
		echo $pageTitle;
	}else{echo 'default'; }

	}

	 /*chek if user exist in database */
	 function userstatus($user){
	 	global $con ;
	 $stmt2=$con->prepare('SELECT username ,regStatus FROM users WHERE username= ? AND 	regStatus = 0 ');

	 $stmt2->execute(array($user));

	 $status= $stmt2->rowCount();
	 return $status ;
	}
	/* 
	==home redirect function [accept parameters ]v2.0
	**$theoemsg = echo the error message 
	**$seconds = seconds befor rediricted 
	*/
	function redirectHome($themsg ,$url = null ,$seconds = 3){
		
		 if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'pravious page' ;
		 }else{
		 	$url ='index.php';
			$link ='home page';
		 }
		
	  	echo $themsg ;
	  	echo "<div class='alert alert-info'>you well be redirect to $link after $seconds seconds </div> ";
	  	header("refresh:$seconds;url=$url");
	 	exit();
	}



/*
	

	/*
	** Count Number Of Items Function v1.0
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
	*/

	function countitem ($item ,$table){

		global $con ;

		$stmt2= $con->prepare("SELECT COUNT($item) FROM $table ");
		$stmt2->execute();

		return $stmt2->fetchColumn();
	}

	/*
	** Get Latest Records Function v1.0
	** Function To Get Latest Items From Database [ Users, Items, Comments ]
	** $select = Field To Select
	** $table = The Table To Choose From
	** $order = The Desc Ordering
	** $limit = Number Of Records To Get
	*/
		function getlatest ($select , $table, $order,$limit= 5 ){

		global $con ;
		$getStmt= $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");

		$getStmt->execute(array());
		$rows= $getStmt->FetchAll();
		return $rows;

	}
 ?>
