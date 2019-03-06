<?php  
/*
===========================================
== manage comments page  
== you can  edit | delete member from here 
===========================================
*/
ob_start();
 session_start();
 $pageTitle = 'comments';

 if (isset($_SESSION['Username'])) {
 	 	
 	 include 'inti.php';
 	 $do =isset($_GET['do']) ? $_GET['do'] :'manage';

 	 	if ($do == 'manage') {//manage page

 	 	


 	 		// select all data 
 	 		$stmt=$con->prepare("SELECT
 	 									 comments.*, items.name AS item_name  , users.username AS member
	 	 							FROM 
	 	 								comments
	 	 							INNER JOIN 
	 	 								items
	 								ON 
	 									items.items_id = comments.item_id
	 								INNER JOIN 
	 									users
	 								ON
	 									users.user_id = comments.user_id ");

 	 		$stmt->execute();

 	 		$rows= $stmt->fetchAll();
 	 		if (!empty($rows)) {
 	 			# code...
 	 		
 	 		?>
 	 		
 	 		 <h1 class="text-center">Manage comments</h1>
			<div class="container">
				<div class="table-responsev">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>comment</td>
							<td>Item Name </td>
							<td>User Name</td>
							<td>Date</td>
							<td>Control</td>
						</tr>
 	 <?php 
 	 			foreach ($rows as $row) {
 	 				echo"<tr>";
							echo "<td>".$row['c_id'] ."</td>";
							echo "<td>".$row['comment'] ."</td>";
							echo "<td>".$row['item_name'] ."</td>";
							echo "<td>".$row['member'] ."</td>";
							echo "<td>" .$row['comment_date'] ."</td>";
							echo "<td>";
								echo "	<a href='comments.php?do=edit&comid=". $row['c_id']. "' class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>";
								echo"<a href='comments.php?do=delete&comid=". $row['c_id']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> delete </a>";
								if ($row['status'] == 0 ) {
									echo"<a href='comments.php?do=approve&comid=". $row['c_id']. "' class='btn btn-info activate'><i class='fa fa-check'></i> approve </a>";
								}

							echo"</td>";
						echo"</tr>";
					}
						?>
						</table>
						</div>
				</div>
					
 	 			

 	<?php  	
 	 	}else {
			echo "<div class='container'>";
			echo "<div class='alert alert-danger'>there\'s no items to show</div>";
			echo "</div>";
		}


 	 	}elseif ($do == 'edit'){ //start edit 
 	 		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

       $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
			// Execute Query
			$stmt->execute(array($comid));
			// Fetch The Data
			$row = $stmt->fetch();
			// The Row Count
			$count = $stmt->rowCount();
			// If There's Such ID Show The Form
			if ($count > 0) { ?>
 	
			            <h1 class="text-center">Edit comment</h1>
							<div class="container">
								<form class="form-horizontal" action="?do=Update" method="POST">
									<input type="hidden" name="comid" value="<?php echo $comid ?>" />
									<!-- Start Username Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">comment</label>
										<div class="col-sm-10 col-md-6">
											<textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
										</div>
									</div>
									<!-- End Username Field -->

									<!-- Start Submit Field -->
									<div class="form-group form-group-lg">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="submit" value="Save" class="btn btn-primary btn-lg" />
										</div>
									</div>
									<!-- End Submit Field -->
								</form>
							</div>

 	 	<?php
				// If There's No Such ID Show Error Message
			} else {
				echo "<div class='container'>";
				$themsg='<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($themsg ,3);
				echo "</div>";
 	 		 } 


 		}
 		elseif ($do == 'Update' ) {
 	 	   echo  "<h1 class='text-center'>Update comment</h1>";
 	 	   echo '<div class="container" >';
 	 	    if ($_SERVER['REQUEST_METHOD']== 'POST') {
 	 	    // GET varibal from the form
 	 	    	$comment = $_POST['comment'];
 	 	    	$id = $_POST['comid'];
 	 	    	// password tric 
 	 	    	

 	 	    	$stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id =? ");

 	 	    	$stmt->execute(array($comment,$id)); 

 	 	    	// echo success messege 
 	 	    	$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    	redirectHome($themsg ,'back',3);
 	 	        }
 	 	    
		 	 	    else {
		 	 	    	$themsg=  '<div class="alert alert-success">sorry cant browse this page direct </div>';

		 	 	    	redirectHome($themsg ,3);
		 	 	    } 
         

 	 	    echo '</div>';

 	 	    //delete page 
 	 	}elseif ($do == 'delete') {
 	 		 echo  "<h1 class='text-center'>Delete comment</h1>";
 	 	     echo '<div class="container" >';

 	 		 $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
	
			 $check = checkItem ('c_id' , 'comments', $comid );
			
			// If There's Such ID Show The Form
			 if ($check > 0) {
				$stmt=$con->prepare("DELETE FROM comments WHERE c_id =:zid");

				$stmt->bindParam(":zid",$comid);
				$stmt->execute();


 	 	    	// echo success messege 
 	 	    	$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    	redirectHome($themsg ,'back',1 );

 	 	     }else{
 	 	    	$themsg = '<div class="alert alert-danger">the id not exist</div>';
 	 	    	redirectHome($themsg , 1);
 	 	    }
 	 	    echo"</div>";
   	    }elseif ($do == 'approve') {

   	    	 echo  "<h1 class='text-center'>approve comment</h1>";
 	 	     echo '<div class="container" >';

 	 		 $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
	
			 $check = checkItem ('c_id' , 'comments', $comid );
			
			// If There's Such ID Show The Form
			 if ($check > 0) {
				$stmt=$con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

				
				$stmt->execute(array($comid));


 	 	    	// echo success messege 
 	 	    	$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    	redirectHome($themsg ,'back');

 	 	     }else{
 	 	    	$themsg = '<div class="alert alert-danger">the id not exist</div>';
 	 	    	redirectHome($themsg);
 	 	    }
 	 	    echo"</div>";
   	    	
   	    }
 	  include $tmp ."footer.php ";
    
}
 else{
		header('Location: index.php');
		exit();
	}
	ob_end_flush();
 ?>