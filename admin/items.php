<?php 

ob_start();
session_start();
 $pageTitle = 'items';


 if (isset($_SESSION['Username'])) {
 	 include 'inti.php';
 
 	

	$do =isset($_GET['do']) ? $_GET['do'] :'manage';

		

     //if the page is main page 
		if ($do =='manage') {
			 $query = '';

 	 		 if (isset($_GET['page']) && $_GET['page'] == 'bending') {
				$query = 'AND regStatus = 0';
			}
				// select all data 
 	 		$stmt=$con->prepare("SELECT
                          		    items.* ,
 		                           	categories.name AS cat_name ,
 		                            users.username 
 	 		                    FROM 
 		                    		items 
								INNER JOIN 
									categories 
								ON 
									categories.id= items.cat_id
								INNER JOIN 
									users 
								ON 
							    	users.user_id = items.member_id  
							    ORDER BY items_id DESC");

 	 		$stmt->execute();

 	 		$items= $stmt->fetchAll();
 	 		if (! empty($items)) {
 	 			
 	 		
 	 		?>
 	 		
 	 		 <h1 class="text-center">Manage items</h1>
			<div class="container">
				<div class="table-responsev">
					<table class="main-table text-center table table-bordered">
						<tr>;
							<td>#ID</td>
							<td>image</td>
							<td>Name</td>
							<td>description</td>
							<td>price</td>
							<td>Adding date</td>
							<td>category</td>
							<td>member</td>
							<td>Control</td>
						</tr>
					
							
							
				
			</div>
 	 		

 	 <?php 
 	 			foreach ($items as $item) {
 	 				echo"<tr>";
							echo "<td>".$item['items_id'] ."</td>";
							echo "<td>";
							if (empty($item['image'])) {
								echo "<img src='defult.jpg'>";
							}else{
								echo "<img src='uploads/item_image//".$item['image'] ."'>";
								echo"</td>";}
							echo "<td>".$item['name'] ."</td>";
							echo "<td>".$item['describtion'] ."</td>";
							echo "<td>".$item['price'] ."</td>";
							echo "<td>" .$item['add_date'] ."</td>";
							echo "<td>" .$item['cat_name'] ."</td>";
							echo "<td>" .$item['username'] ."</td>";
							echo "<td>";
								echo "	<a href='items.php?do=edit&item_id=". $item['items_id']. "' class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>";
								echo"<a href='items.php?do=delete&item_id=". $item['items_id']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> delete </a>";
								if ($item['approve'] == 0 ) {
									echo"<a href='items.php?do=approve&item_id=". $item['items_id']. "
									' class='btn btn-info activate'>
									<i class='fa fa-check'></i> approve </a>";
								}
							

							echo"</td>";
						echo"</tr>";
					}
						?>
						</table>
						</div>
			<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"> </i> Add item</a>
				</div>	
 	 			
		<?php 	}else {
			echo "<div class='container'>";
			echo "<div class='alert alert-danger'>there\'s no items to show</div>";
			echo'<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"> </i> new item</a>';
			echo "</div>";
		}

		}elseif ($do == 'add') {?>
			 <h1 class="text-center">add new items </h1>
						<div class="container">
							<form class="form-horizontal" action="?do=insert" method="POST"
							enctype="multipart/form-data">
								
								<!-- Start name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">name</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="name" class="form-control"  placeholder="name of the items"/>
									</div>
								</div>
								<!-- End name Field -->
								<!-- Start Discription Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Discription</label>
									<div class="col-sm-10 col-md-6"> 
										<input type="text" name="Discription" class="form-control"   placeholder="Discription of the items" />
										
									</div>
								</div>
								<!-- End Discription Field -->
								<!-- Start price Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">price</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="price"  class="form-control"  placeholder="price of the item " />
									</div>
								</div>
								<!-- End price Field -->
									<!-- Start country Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">country</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="country"  class="form-control"  placeholder="country of made " />
									</div>
								</div>
								<!-- End country Field -->

								<!-- Start tags Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">tags</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="tags"  class="form-control"  placeholder="separate tags with comma (,)" />
									</div>
								</div>
								<!-- End tags Field -->
									<!-- Start image Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label"> item image </label>
										<div class="col-sm-10 col-md-6">
											<input type="file" name='image' class="form-control"  />
										</div>
									</div>
									<!-- End image Field -->
								<!-- Start status Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">status</label>
									<div class="col-sm-10 col-md-6">
										<select  name="status">
											<option value="0">....</option>
											<option value="1">new</option>
											<option value="2">like new </option>
											<option value="3">used</option>
											<option value="4">very old</option>
										</select>	
									</div>
								</div>
								<!-- End status Field -->
								<!-- Start member Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">member</label>
									<div class="col-sm-10 col-md-6">
										<select  name="member">
											<option value="0">....</option>
										<?php 
											$users = getallfrom('*','users' ,'' ,'','user_id');	
											foreach ($users as $user) {
												echo "<option value='". $user['user_id'] ."'>". $user['username']."</option>";
											}
										 ?>
										</select>	
									</div>
								</div>
								<!-- End member Field -->
				           <!-- Start category Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">category</label>
									<div class="col-sm-10 col-md-6">
										<select  name="category">
											<option value="null">....</option>
										<?php 
										$cats = getallfrom('*','categories','WHERE parent =0','','id');
											foreach ($cats as $cat) {
												echo "<option value='". $cat['id'] ."'>". $cat['name']."</option>";
											$childcats = getallfrom('*','categories',"WHERE parent ={$cat['id']}",'','id');
												foreach ($childcats as $child) {
												echo "<option value='". $child['id'] ."'> ---". $child['name']."</option>";
											    }
									        }
										 ?>
										</select>	
									</div>
								</div>
								<!-- End category Field -->
						
								<!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="add item" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
							</form>
						</div>
			

	<?php	}elseif ($do =='insert' ) {
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					echo "<h1 class='text-center'> insert item </h1>";
					echo "<div class='container'>";

					$imagename = $_FILES['image']['name'];
					$imagesize =$_FILES['image']['size'];
					$imagetmp =$_FILES['image']['tmp_name'];
					$imagetype = $_FILES['image']['type'];

	 	 	    	$imageAllowedExtension= array('jpeg','jpg','png','gif');

	 	 	    	@$imagExtension= strtolower( end(explode ('.', $imagename )));

					$name		= $_POST['name'];
					$Disc 		= $_POST['Discription'];
					$price		= $_POST['price'];
					$country 	= $_POST['country'];
					$tags 		= $_POST['tags'];
					$status		= $_POST['status'];
					$category	= $_POST['category'];
					$member		= $_POST['member'];
					   	$formErrors = array();
 	 	    
 	 	    
 	 	    	if (empty($name)) {
 	 	    	$formErrors[] = ' name cant<strong> be empty</strong> ';
 	 	    	}
 	 	    	if (empty($Disc)) {
 	 	    	$formErrors[] = ' Discription cant<strong> be empty</strong> ';
 	 	    	}
 	 	    if (empty($price)) {
 	 	    	$formErrors[] = 'price  cant <strong> be empty</strong>';
 	 	    	}	 	 	    	
			if (empty($country)) {
		    	$formErrors[] = 'country cant <strong> be empty</strong>';	 	 	    	
				}
				if ($status == 0 ) {
		    	$formErrors[] = 'you mast choose the <strong> status</strong>';	 	 	    	
				}
				if (empty($imagename)) {
				$formErrors[] = 'image is <strong> required </strong>';
				}
				if (!empty($imagename) && !in_array($imagExtension, $imageAllowedExtension)) {
					$formErrors[] = 'the extension is not <strong> allowed</strong>';
				}
				if ($imagesize > 4194304) {
					$formErrors[] = 'image cant be lager than  <strong>4MB</strong>';
				}

				foreach ($formErrors as $error ) {
					echo '<div class="alert alert-danger">'. $error. '</div>' ;
				}
				// check if  there's no errer proceed the update  
				if (empty($formErrors)) {
					
						$image= rand(0,100000000) .'_'.$imagename;
						move_uploaded_file($imagetmp, "uploads\item_image\\".$image);
				
							$stmt = $con->prepare("INSERT INTO
							 items(name,describtion,price,add_date,	country_made,tags,image,status ,cat_id,member_id) 
							 VALUES(:zname , :zdesc, :zprice , now() ,:zcountry ,:ztags,:zimage,:zstat,:zcat, :zmember) ");

							$stmt->execute(array(
								':zname' 	=>$name,
								':zdesc'	=>$Disc,
								':zprice'	=>$price,
								':zcountry' =>$country,
								':ztags' 	=>$tags,
								':zimage'	=>$image,
								':zstat'	=>$status,
								':zcat'	    =>$category,
								':zmember'	=>$member	
								));
								//success massege
							$themsg = '<div class="alert alert-success">'.$stmt->rowCount().'record update</div>';
								redirectHome($themsg);
						}

					




				}else{
					$themsg= '<div class="alert alert-danger">sorry cant brows this page dirict </div>';
						redirectHome($themsg ,'back');
					
				}

		}elseif ($do == 'edit') {
		//start edit 
 	 		$item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;

       $stmt = $con->prepare("SELECT * FROM items WHERE items_id = ? LIMIT 1");
			// Execute Query
			$stmt->execute(array($item_id));
			// Fetch The Data
			$item = $stmt->fetch();
			// The Row Count
			$count = $stmt->rowCount();
			// If There's Such ID Show The Form
			if ($count > 0) { ?>
 	
			            <h1 class="text-center">Edit item</h1>
							<div class="container">
								<form class="form-horizontal" action="?do=Update" method="POST"
								enctype="multipart/form-data">
									<input type="hidden" name="item_id" value="<?php echo $item_id ?>" />
										<!-- Start name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">name</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="name" class="form-control" 
										value="<?php echo $item['name'] ?>" placeholder="name of the items"/>
									</div>
								</div>
								<!-- End name Field -->
								<!-- Start Discription Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Discription</label>
									<div class="col-sm-10 col-md-6"> 
										<input type="text" name="Discription" class="form-control"
										 value="<?php echo $item['describtion'] ?>" placeholder="Discription of the items" />
										
									</div>
								</div>
								<!-- End Discription Field -->
								<!-- Start price Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">price</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="price"  class="form-control"
										value="<?php echo $item['price'] ?>"  placeholder="price of the item " />
									</div>
								</div>
								<!-- End price Field -->
								<!-- Start country Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">country</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="country"  class="form-control"  value="<?php echo $item['country_made'] ?>"placeholder="country of made " />
									</div>
								</div>
								<!-- End price Field -->
								<!-- Start tags Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">tags</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="tags"  class="form-control" 
										value="<?php echo $item['tags'] ?>" 
										 placeholder="separate tags with comma (,)" />
									</div>
								</div>
								<!-- End tags Field -->
								<!-- Start image Field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label"> item image </label>
										<div class="col-sm-10 col-md-6">
											<input type="file" name='image' class="form-control"  />
										</div>
									</div>
								<!-- End image Field -->
								<!-- Start status Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">status</label>
									<div class="col-sm-10 col-md-6">
									
										<select  name="status">
											
											<option value="1" <?php if($item['status']==1){echo "selected";} ?> >new</option>
											<option value="2"<?php if($item['status']==2){echo "selected"
												;} ?>>like new </option>
											<option value="3"<?php if($item['status']==3){echo "selected";} ?>>used</option>
											<option value="4"<?php if($item['status']==4){echo "selected";} ?>>very old</option>
										</select>	
									</div>
								</div>
								<!-- End status Field -->
												<!-- Start member Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">member</label>
									<div class="col-sm-10 col-md-6">
										<select  name="member">
											
										<?php 
											$users = getallfrom('*','users' ,'' ,'','user_id');
											foreach ($users as $user) {
												echo "<option value='". $user['user_id'] ."'";
												 if($item['member_id']==$user['user_id']){echo "selected";} 
												echo">". $user['username']."</option>";
											}
										 ?>
										</select>	
									</div>
								</div>
								<!-- End member Field -->
				           <!-- Start category Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">category</label>
									<div class="col-sm-10 col-md-6">
										<select  name="category">
											
										<?php 
											$cats = getallfrom('*','categories','WHERE parent =0','','id');
										
											foreach ($cats as $cat) {
												echo "<option value='". $cat['id'] ."'";
												 if($item['cat_id']==$cat['id']){echo "selected";}
												echo ">". $cat['name']."</option>";
												$childcats = getallfrom('*','categories',"WHERE parent ={$cat['id']}",'','id');
												foreach ($childcats as $child) {
													echo "<option value='". $child['id'] ."'";
													if($item['cat_id']==$child['id']){echo "selected";}
													echo "> ---". $child['name']."</option>";
											    }
											}
										 ?>
    
										</select>	
									</div>
								</div>
								<!-- End category Field -->
								<!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Update item" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
								</form>
								<?php  
									// select all data 
			$stmt=$con->prepare("SELECT
 	 									 comments.*,  users.username AS member
	 	 							FROM 
	 	 								comments
	 	 							
	 									INNER JOIN 
	 									users
	 								ON
	 									users.user_id = comments.user_id 
	 									WHERE item_id = ?");

 	 		$stmt->execute(array($item_id));

 	 		$rows= $stmt->fetchAll();
 	 			if (! empty($rows)) {
 	 				# code...
 	 			
 	 		?>
 	 		
		 	 		 <h1 class="text-center">Manage [<?php echo $item['name'] ?>] comments</h1>
					<div class="container">
						<div class="table-responsev">
							<table class="main-table text-center table table-bordered">
								<tr>
									<td>comment</td>
									<td>User Name</td>
									<td>Date</td>
									<td>Control</td>
								</tr>
		 	 <?php 
		 	 			foreach ($rows as $row) {
		 	 				echo"<tr>";
									echo "<td>".$row['comment'] ."</td>";
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
							
		 	 			

		 	<?php } ?>	

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

		elseif ($do =='Update' ) {
			
			echo "<h1 class='text-center'> update items </h1>";
					echo "<div calss='container'>";

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						
					$imagename = $_FILES['image']['name'];
					$imagesize =$_FILES['image']['size'];
					$imagetmp =$_FILES['image']['tmp_name'];
					$imagetype = $_FILES['image']['type'];

	 	 	    	$imageAllowedExtension= array('jpeg','jpg','png','gif');

	 	 	    	@$imagExtension= strtolower( end(explode ('.', $imagename )));

						$id         = $_POST['item_id'];
						$name		= $_POST['name'];
						$Disc 		= $_POST['Discription'];
						$price		= $_POST['price'];
						$country 	= $_POST['country'];
						$tags 		= $_POST['tags'];
						$status		= $_POST['status'];
						$category	= $_POST['category'];
						$member		= $_POST['member'];

						$formErrors = array();
	 
		 	 	    	if (empty($name)) {
		 	 	    	$formErrors[] = ' name cant<strong> be empty</strong> ';
		 	 	    	}
		 	 	    	if (empty($Disc)) {
		 	 	    	$formErrors[] = ' Discription cant<strong> be empty</strong> ';
		 	 	    	}
		 	 	    if (empty($price)) {
		 	 	    	$formErrors[] = 'price  cant <strong> be empty</strong>';
		 	 	    	}	 	 	    	
					if (empty($country)) {
				    	$formErrors[] = 'country cant <strong> be empty</strong>';	 	 	    	
						}
						if ($status == 0 ) {
				    	$formErrors[] = 'you mast choose the <strong> status</strong>';	 	 	    	
						}
						if (empty($imagename)) {
							$formErrors[] = 'image is <strong> required </strong>';
						}
						if (!empty($imagename) && !in_array($imagExtension, $imageAllowedExtension)) {
							$formErrors[] = 'the extension is not <strong> allowed</strong>';
						}
						if ($imagesize > 4194304) {
							$formErrors[] = 'image cant be lager than  <strong>4MB</strong>';
						}
						foreach ($formErrors as $error ) {
							echo '<div class="alert alert-danger">'. $error. '</div>' ;
						}
						// check if  there's no errer proceed the update  
						if (empty($formErrors))  {
							$image= rand(0,100000000) .'_'.$imagename;
							move_uploaded_file($imagetmp, "uploads\item_image\\".$image);
							$stmt= $con->prepare("UPDATE
														 items 
														SET 
															name = ?,
															describtion= ?,
															price = ?,
															country_made= ?,
															tags = ? ,
															image =? ,
															status= ?,
															cat_id = ?,
															member_id= ?
														WHERE
															items_id = ?");
						$stmt->execute(array($name,$Disc,$price,$country,$tags,$image,$status,$category,$member,$id));


							// echo success massge 
							$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    				redirectHome($themsg ,'back');	
							
						
					}			
					}else {
						$themsg = '<div class="alert alert-danger">sorry cant browse this page direct';
						redirectHome($themsg);
					}




					echo "</div>";
		}elseif ($do == 'delete') {

				echo "<h1 class='text-center'>delete item </h1>";
					echo '<div class="container">';
					$item_id= isset($_GET['item_id'])&& is_numeric($_GET['item_id'])? intval($_GET['item_id']):0;

					 $check=checkItem('items_id','items',$item_id);
					if ($check > 0 ) {
						$stmt=$con->prepare("DELETE FROM items WHERE items_id = :zid ");

						$stmt->bindparam(":zid", $item_id);
						$stmt->execute();
							$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    	redirectHome($themsg ,'back');
					}else{
							$themsg = '<div class="alert alert-danger">the id not exist</div>';
 	 	    	redirectHome($themsg ,'back');
 	 	    		}
					echo "</div>";
				


		}elseif ($do =='approve' ) {
			 echo  "<h1 class='text-center'>approve item </h1>";
 	 	     echo '<div class="container" >';

 	 		 $item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
	
			 $check = checkItem ('items_id' , 'items', $item_id );
			
			// If There's Such ID Show The Form
			 if ($check > 0) {
				$stmt=$con->prepare("UPDATE items SET approve = 1 WHERE items_id = ?");

				
				$stmt->execute(array($item_id));


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
