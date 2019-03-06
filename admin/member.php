<?php  
/*
===========================================
== manage member page  
== you can add | edit | delete member from here 
===========================================
*/
ob_start();
 session_start();
 $pageTitle = 'member';

 if (isset($_SESSION['Username'])) {
 	 	
 	 include 'inti.php';
 	 $do =isset($_GET['do']) ? $_GET['do'] :'manage';

 	 	if ($do == 'manage') {//manage page

 	 		$query = '';

 	 		 if (isset($_GET['page']) && $_GET['page'] == 'bending') {
				$query = 'AND regStatus = 0';
			}



 	 		// select all data 
 	 		$stmt=$con->prepare("SELECT * FROM users WHERE group_id != 1 $query");

 	 		$stmt->execute();

 	 		$rows= $stmt->fetchAll();
 	 		if (!empty($rows)) {
 	 			
 	 		
 	 		?>
 	 		
 	 		 <h1 class="text-center">Manage Members</h1>
			<div class="container">
				<div class="table-responsev">
					<table class="main-table manage-member text-center table table-bordered">
						<tr>;
							<td>#ID</td>
							<td>image</td>
							<td>UserName</td>
							<td>Email</td>
							<td>FullName</td>
							<td>Register</td>
							<td>Control</td>
						</tr>
					
							
							
				
			</div>
 	 		

 	 <?php 
 	 			foreach ($rows as $row) {
 	 				echo"<tr>";
							echo "<td>".$row['user_id'] ."</td>";
							echo "<td>";
							if (empty($row['image'])) {
								echo "<img src='defult.jpg' >";
							}else{
							echo "<img src='uploads/member_image/". $row['image'] ."' alt='' />" ;
							}
							echo "</td>";
							echo "<td>".$row['username'] ."</td>";
							echo "<td>".$row['email'] ."</td>";
							echo "<td>".$row['fulname'] ."</td>";
							echo "<td>" .$row['Date'] ."</td>";
							echo "<td>";
								echo "	<a href='member.php?do=edit&userid=". $row['user_id']. "' class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>";
								echo"<a href='member.php?do=delete&userid=". $row['user_id']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> delete </a>";
								if ($row['regStatus'] == 0 ) {
									echo"<a href='member.php?do=activate&userid=". $row['user_id']. "' class='btn btn-info activate'><i class='fa fa-check'></i> activate </a>";
								}

							echo"</td>";
						echo"</tr>";
					}
						?>
						</table>
						</div>
			<a href="member.php?do=add" class="btn btn-primary"><i class="fa fa-plus"> </i> New member</a>
				</div>	
 	<?php  			
	}else {
			echo "<div class='container'>";
			echo "<div class='alert alert-danger'>there\'s no members to show</div>";
			echo'<a href="member.php?do=add" class="btn btn-primary"><i class="fa fa-plus"> </i> New member</a>';
			echo "</div>";}

 	 	}elseif ($do == 'add') {//add member page 
 	 		?>
 	 		
 	 		
			            <h1 class="text-center">add new Member</h1>
							<div class="container">
								<form class="form-horizontal" action="?do=insert" method="POST" 
								enctype="multipart/form-data">
									
									<!-- Start Username Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Username</label>
										<div class="col-sm-10 col-md-6">
											<input type="text" name="username" class="form-control"  autocomplete="off" required="required" placeholder="username to login "/>
										</div>
									</div>
									<!-- End Username Field -->
									<!-- Start Password Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Password</label>
										<div class="col-sm-10 col-md-6"> 
											<input type="password" name="password" class="password form-control" autocomplete="password" required="required" placeholder=" password must be hard & complex" />
											<i class="show-pass fa fa-eye fa-2x"></i>
										</div>
									</div>
									<!-- End Password Field -->
									<!-- Start Email Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Email</label>
										<div class="col-sm-10 col-md-6">
											<input type="email" name="email"  class="form-control" required="required" placeholder="Email must be valid " />
										</div>
									</div>
									<!-- End Email Field -->
									<!-- Start Full Name Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Full Name</label>
										<div class="col-sm-10 col-md-6">
											<input type="text" name="full" class="form-control" required="required" placeholder="full name apper to profile page  " />
										</div>
									</div>
									<!-- End Full Name Field -->
									<!-- Start image Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label"> profile image </label>
										<div class="col-sm-10 col-md-6">
											<input type="file" name='image' class="form-control"  />
										</div>
									</div>
									<!-- End image Field -->
									<!-- Start Submit Field -->
									<div class="form-group form-group-lg">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="submit" value="add member " class="btn btn-primary btn-lg" />
										</div>
									</div>
									<!-- End Submit Field -->
								</form>
							</div>


 <?php 

	//end add page 
		}elseif ($do == 'insert') {
		
		//insert in database 

 	 	    if ($_SERVER['REQUEST_METHOD']== 'POST') {

 	 	    	echo  "<h1 class='text-center'>insert Member</h1>";
 	 	        echo '<div class="container" >';

 	 	    //upload varibal
 	 	        $imageName = $_FILES['image']['name'];
 	 	    	$imagetype = $_FILES['image']['type'];
 	 	    	$imageSize = $_FILES['image']['size'];
 	 	    	$imagetmp  = $_FILES['image']['tmp_name'];
 	 	    //list of allowed file type to apload

 	 	    	$imageAllowedExtension= array('jpeg','jpg','png','gif');

 	 	    	@$imagExtension= strtolower( end(explode ('.', $imageName )));
 	 	    
 	 	    // GET varibal from the form
 	 	    	
 	 	    	$user = $_POST['username'];
 	 	    	$pass = $_POST['password'];
 	 	    	$email= $_POST['email'];
 	 	    	$name = $_POST['full'];

 	 	    	// password tric 
 	 	    	$hashpass = sha1($_POST['password']);
 	 	    	// valedate the form 
 	 	    	$formErrors = array();
 	 	    
 	 	    if (strlen($user) > 20 ) {
 	 	    	$formErrors[] = 'the username cant be more than <strong> 20 char</strong>';
 	 	    	}

 	 	    if (strlen($user) < 4) {
 	 	    	$formErrors[] = 'the username cant be less <strong> 4 char</strong>';
 	 	    	}
 	 	    	if (empty($user)) {
 	 	    	$formErrors[] = ' username cant<strong> be empty</strong> ';
 	 	    	}
 	 	    	if (empty($pass)) {
 	 	    	$formErrors[] = ' password cant<strong> be empty</strong> ';
 	 	    	}
 	 	    if (empty($email)) {
 	 	    	$formErrors[] = 'email  cant <strong> be empty</strong>';
 	 	    	}	 	 	    	
			if (empty($name)) {
		    	$formErrors[] = 'full name cant <strong> be empty</strong>';	 	 	    	
				}
			if (empty($imageName)) {
				$formErrors[] = 'image is <strong> required </strong>';
			}
			if (!empty($imageName) && !in_array($imagExtension, $imageAllowedExtension)) {
				$formErrors[] = 'the extension is not <strong> allowed</strong>';
			}
			if ($imageSize > 4194304) {
				$formErrors[] = 'image cant be lager than  <strong>4MB</strong>';
			}

				foreach ($formErrors as $error ) {
					echo '<div class="alert alert-danger">'. $error. '</div>' ;
				}
				
				// check if  there's no errer proceed the update  
				if (empty($formErrors)) {
					//image apload in system

					$image = rand(0,10000000) . '_'.$imageName ;
					move_uploaded_file($imagetmp, "uploads\member_image\\".$image);
					//check if user exsit in database
					$check = checkItem('username','users',$user);
					if ($check > 0 ) {
						$themsg = '<div class="alert alert-danger">sorry this user exist </div>' ;
						redirectHome($themsg,'back');
						# code...
					}else{


					
									
			 	 	    	// update the database with this data

			 	 	    	$stmt = $con->prepare("INSERT INTO users(username,password,email, fulname,regStatus , Date ,image)
			 	 	    		 VALUES(:zuser, :zpass, :zemail ,:zname, 1 ,now() ,:zimage)  ");

			 	 	    	$stmt->execute(array(
			 	 	    		'zuser' => $user ,
			 	 	    		'zpass' => $hashpass,
			 	 	    		'zemail'=> $email,
			 	 	    		'zname' => $name,
			 	 	    		'zimage'=>$image 
			 	 	    		)); 

			 	 	    	// echo success messege 
			 	 	    	$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
			 	 	    	redirectHome($themsg,'back' ,3);

 	 	        }
 	 	    }
 	 	
 	 	    
 	 	    }else {
 	 	    	$themsg = '<div class="alert alert-danger"> sorry cant browse this page direct </div>';
 	 	    	redirectHome($themsg);
 	 	    }

 	 	    echo '</div>';
 	 
 	 	
 	 	

 	 	}elseif ($do == 'edit'){ //start edit 
 	 		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

       $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
			// Execute Query
			$stmt->execute(array($userid));
			// Fetch The Data
			$row = $stmt->fetch();
			// The Row Count
			$count = $stmt->rowCount();
			// If There's Such ID Show The Form
			if ($count > 0) { ?>
 	
			            <h1 class="text-center">Edit Member</h1>
							<div class="container">
								<form class="form-horizontal" action="?do=Update" method="POST"
									enctype="multipart/form-data" >
									<input type="hidden" name="userid" value="<?php echo $userid ?>" />
									<!-- Start Username Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Username</label>
										<div class="col-sm-10 col-md-6">
											<input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" autocomplete="off" required="required" />
										</div>
									</div>
									<!-- End Username Field -->
									<!-- Start Password Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Password</label>
										<div class="col-sm-10 col-md-6">
											<input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
											<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
										</div>
									</div>
									<!-- End Password Field -->
									<!-- Start Email Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Email</label>
										<div class="col-sm-10 col-md-6">
											<input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" required="required" />
										</div>
									</div>
									<!-- End Email Field -->
									<!-- Start Full Name Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Full Name</label>
										<div class="col-sm-10 col-md-6">
											<input type="text" name="full" value="<?php echo $row['fulname'] ?>" class="form-control" required="required" />
										</div>
									</div>
									<!-- End Full Name Field -->
										<!-- Start image Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label"> profile image </label>
										<div class="col-sm-10 col-md-6">
											<input type="file" name="image" class="form-control" 
											 />
										</div>
									</div>
									<!-- End image Field -->
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
 	 	   echo  "<h1 class='text-center'>Update Member</h1>";
 	 	   echo '<div class="container" >';
 	 	    if ($_SERVER['REQUEST_METHOD']== 'POST') {

 	 	    	//upload varibal
 	 	        $imageName = $_FILES ['image']['name'];
 	 	    	$imagetype = $_FILES ['image']['type'];
 	 	    	$imageSize = $_FILES ['image']['size'];
 	 	    	$imagetmp = $_FILES ['image']['tmp_name'];
 	 	    //list of allowed file type to apload
 	 	    	
 	 	    	$imageAllowedExtension= array('jpeg','jpg','png','gif');

				@$imagExtension= strtolower(end(explode ('.', $imageName )));
 	 	    // GET varibal from the form
 	 	    	$id = $_POST['userid'];
 	 	    	$user = $_POST['username'];
 	 	    	$email= $_POST['email'];
 	 	    	$name = $_POST['full'];

 	 	    	// password tric 
 	 	    	$pass =empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
 	 	    	// valedate the form 
 	 	    	$formErrors = array();
 	 	    if (empty($user)) {
 	 	    		$formErrors[] = ' username cant<strong> be empty</strong> ';
 	 	    	}
 	 	    if (strlen($user) > 20 ) {
 	 	    		$formErrors[] = 'the username cant be more than <strong> 20 char</strong>';
 	 	    	}

 	 	    if (strlen($user) < 4) {
 	 	    		$formErrors[] = 'the username cant be less <strong> 4 char</strong>';
 	 	    	}
 	 	    if (empty($email)) {
 	 	    		$formErrors[] = 'email  cant <strong> be empty</strong>';
 	 	    	}	 	 	    	
			if (empty($name)) {
		    		$formErrors[] = 'full name cant <strong> be empty</strong>';	 	 	    	
				}
			if (empty($imageName)) {
					$formErrors[] = 'image is <strong> required </strong>';
				}
			if (!empty($imageName) && !in_array($imagExtension, $imageAllowedExtension)) {
					$formErrors[] = 'the extension is not <strong> allowed</strong>';
			}
			if ($imageSize > 4194304) {
					$formErrors[] = 'image cant be lager than  <strong>4MB</strong>';
			}
				foreach ($formErrors as $error ) {
					echo '<div class="alert alert-danger">'. $error. '</div>' ;
				}
				// check if  there's no errer proceed the update  
				if (empty($formErrors)) {
					//image apload in system

				$image = rand(0,10000000) . '_'.$imageName ;
				move_uploaded_file($imagetmp, "uploads\member_image\\".$image);

				$stmt2=$con->prepare("SELECT * FROM users WHERE username =? AND user_id != ? ");
				$stmt2->execute(array($user ,$id));
				$count= $stmt2->rowCount();
				if ($count ==1) {
				 	   $themsg = "<div class='alert alert-danger'>the user exsit </div>";
				 	    redirectHome($themsg ,'back');
				 }else{ 					
 	 	    	// update the database with this data

 	 	    	$stmt = $con->prepare("UPDATE users SET username = ? , email = ? ,fulname=  ?, password = ?, image = ? WHERE user_id =? ");

 	 	    	$stmt->execute(array($user ,$email , $name,$pass ,$image,$id)); 

 	 	    	// echo success messege 
 	 	    	$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    		//redirectHome($themsg ,'back',3);
 	 	        }
 	 	        }
 	 	    }
		 	 	    else {
		 	 	    	$themsg=  '<div class="alert alert-success">sorry cant browse this page direct </div>';

		 	 	    	redirectHome($themsg ,3);
		 	 	    } 
         

 	 	    echo '</div>';

 	 	    //delete page 
 	 	}elseif ($do == 'delete') {
 	 		 echo  "<h1 class='text-center'>Delete Member</h1>";
 	 	     echo '<div class="container" >';

 	 		 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
	
			 $check = checkItem ('user_id' , 'users', $userid );
			
			// If There's Such ID Show The Form
			 if ($check > 0) {
				$stmt=$con->prepare("DELETE FROM users WHERE user_id =:zuserid");

				$stmt->bindParam(":zuserid",$userid);
				$stmt->execute();


 	 	    	// echo success messege 
 	 	    	$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    	redirectHome($themsg ,'back');

 	 	     }else{
 	 	    	$themsg = '<div class="alert alert-danger">the id not exist</div>';
 	 	    	redirectHome($themsg);
 	 	    }
 	 	    echo"</div>";
   	    }elseif ($do == 'activate') {

   	    	 echo  "<h1 class='text-center'>activate Members</h1>";
 	 	     echo '<div class="container" >';

 	 		 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
	
			 $check = checkItem ('user_id' , 'users', $userid );
			
			// If There's Such ID Show The Form
			 if ($check > 0) {
				$stmt=$con->prepare("UPDATE users SET regStatus = 1 WHERE user_id = ?");

				
				$stmt->execute(array($userid));


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