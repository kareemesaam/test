<?php 

ob_start();
session_start();
 $pageTitle = 'items';


 if (isset($_SESSION['Username'])) {
 	 include 'inti.php';

	$do =isset($_GET['do']) ? $_GET['do'] :'manage';

		

     //if the page is main page 
		if ($do =='manage') {

			echo "wlcome to manage page ";
			

		}elseif ($do == 'add') {
			

		}elseif ($do ='insert' ) {
			

		}elseif ($do == 'edit') {
		

		}elseif ($do ='update' ) {
			

		}elseif ($do == 'delete') {
			

		}elseif ($do ='approve' ) {
			
			
		}

	  include $tmp ."footer.php ";

}
 else{
		header('Location: index.php');
		exit();
	}
	ob_end_flush();
 ?>
