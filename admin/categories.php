<?php 
ob_start();
session_start();
 $pageTitle = 'categories';


 if (isset($_SESSION['Username'])) {
 	 include 'inti.php';

		$do =isset($_GET['do']) ? $_GET['do'] :'manage';

		     //if the page is main page 
		if ($do =='manage') {

			$sort = 'ASC';
			$sort_array=array('ASC','DESC');
			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
				$sort = $_GET['sort'];
			}


			$stmt2= $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ordering $sort");
			$stmt2->execute();
			$cats = $stmt2->fetchAll(); ?>

			<h1 class="text-center"> manage categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading"><i class='fa fa-edit'></i>Manage categories
					<div class="option pull-right">
						Ordering:[
						<a class="<?php if ($sort == 'ASC') {echo 'active';} ?>" href="?sort=ASC">Asc</a> |
						<a class="<?php if ($sort == 'DESC') {echo 'active';} ?>" href="?sort=DESC">Desc</a> ]
						View :[
						<span class="active" data-view='full'>full</span> |
						<span>Classic</span> ]
					</div>

					</div>
					<div class="panel-body">
						<?php 
						
							foreach ($cats as $cat) {
							echo "<div class='cat'>";	
							  echo "<div class='heddin-buttons' >";
								  echo "<a href='?do=edit&catid=".$cat['id']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
								   echo "<a href='?do=delete&catid=".$cat['id']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
							  echo "</div>";
								echo "<h3>".$cat['name'] . "</h3>";

								echo "<div class='full-view'>";
									echo "<p>" ; if ($cat['discription']=='') {echo "the discription empty";}else{echo $cat['discription'];}
								    echo "</p>";
									if($cat['visibility']== 1 ){echo "<span class='visibility'><i class='fa fa-eye'></i>heddin</span>";}
									if($cat['allow_comment']== 1 ){echo "<span class='comment'><i class='fa fa-close'></i>comment disabled</span>";}
									if($cat['allow_ads']== 1 ){echo "<span class='ads'><i class='fa fa-close'></i>ads disabled</span>";}

								echo "</div>";
							
							//echo child catigory 
							 $childcats= getallfrom('*','categories',"where parent ={$cat['id']} ",'','ordering','ASC');  
									 if (!empty($childcats)) {	
									    echo "<h4 class='child-head'>child catigory</h4>";
									    echo "<ul class='list-unstyled child-cats' >";									 
					      				foreach ($childcats as $c) {
					       					 echo "<li class='child-link'>
					       					 <a href='?do=edit&catid=".$c['id']."'>".$c['name']."</a>
					       					 <a href='?do=delete&catid=".$c['id']."' class='confirm delete-child'>Delete</a>
					       					 </li>";
					     					 }
					     				echo "</ul>";
					     			 }
					     			 echo "</div>";
							echo "<hr>";
							}




						
						?>
					</div>
				</div>
				<a class="btn btn-primary" href="categories.php?do=add"><i class="fa fa-plus"></i>Add new category</a>
			</div>
				

	<?php 	}elseif ($do == 'add') { //add catigory ?>
					
				   <h1 class="text-center">add new category</h1>
						<div class="container">
							<form class="form-horizontal" action="?do=insert" method="POST">
								
								<!-- Start name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">name</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="name" class="form-control"  autocomplete="off" required="required" placeholder="name of the catigory "/>
									</div>
								</div>
								<!-- End name Field -->
								<!-- Start Discription Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Discription</label>
									<div class="col-sm-10 col-md-6"> 
										<input type="text" name="Discription" class="form-control"   placeholder=" discrip your catigory" />
										
									</div>
								</div>
								<!-- End Discription Field -->
								<!-- Start ordering Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">ordering</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="ordering"  class="form-control"  placeholder="namber to arrange the catigories " />
									</div>
								</div>
								<!-- End ordering Field -->
								<!-- Start catigory type Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">parent?</label>
									<div class="col-sm-10 col-md-6">
										<select name="parent">
											<option value="0">None</option>
										<?php 
	       								    $getcats=getallfrom('*','categories','WHERE parent= 0','','ordering');
	       								    foreach ($getcats as $cat ) {
	       								    	echo "<option value='".$cat['id']."' >".$cat['name']."</option>";
	       								    }
											?>
										</select>
									</div>
								</div>
								<!-- End catigory type Field -->
								<!-- Start visible Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">visible </label>
									<div class="col-sm-10 col-md-6">
										<div>
											<input id="ves-yes" type="radio" name="visible" value="0" checked>
											<label for="ves-yes">yes</label>
										</div> 
										<div>
											<input id="ves-no" type="radio" name="visible" value="1">
											<label for="ves-no">No</label>
										</div> 
									</div>
								</div>
								<!-- End visible  Field -->
								<!-- Start commenting Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Allow commenting </label>
									<div class="col-sm-10 col-md-6">
										<div>
											<input id="com-yes" type="radio" name="commenting" value="0" checked>
											<label for="com-yes">yes</label>
										</div> 
										<div>
											<input id="com-no" type="radio" name="commenting" value="1">
											<label for="com-no">No</label>
										</div> 
									</div>
								</div>
								<!-- End commenting Field -->
								<!-- Start ads Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Allow ads  </label>
									<div class="col-sm-10 col-md-6">
										<div>
											<input id="ads-yes" type="radio" name="ads" value="0" checked>
											<label for="ads-yes">yes</label>
										</div> 
										<div>
											<input id="ads-no" type="radio" name="ads" value="1">
											<label for="ads-no">No</label>
										</div> 
									</div>
								</div>
								<!-- End ads Field -->

								<!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="add catigory" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
							</form>
						</div>
			


<?php	}elseif ($do =='insert' ) {
				
			if ($_SERVER['REQUEST_METHOD'] =='POST') {
		    		
				echo "<h1 class='text-center'> insert catigory</h1>";
				echo "<div class='container'>";
				//get varibal from the form
					$name    = $_POST['name'];
					$desc    = $_POST['Discription'];
					$parent  = $_POST['parent'];
					$order   = $_POST['ordering'];
					$visible = $_POST['visible'];
					$comment = $_POST['commenting'];
					$ads    = $_POST['ads'];
					
					if (!empty($name)) {
						
						$check= checkItem ('name','categories', $name );
							if ($check > 0) {
								$themsg= '<div class="alert alert-danger"> sorry this catigory exist </div>';
								redirectHome($themsg, 'back');
							}
							else{
							$stmt = $con->prepare("INSERT INTO categories(name,Discription,parent,ordering,visibility,	allow_comment,allow_ads) 
								VALUES( :zname ,:zdisc,:zparent,:zorder ,:zvisible ,:zcomment,:zads )");

							$stmt->execute(array(
								'zname'     => $name ,
								'zdisc'     => $desc,
								'zparent'   => $parent,
								'zorder'    => $order ,
								':zvisible' => $visible,
								':zcomment' => $comment ,
								':zads'     => $ads
								));

							//success massege
							$themsg = '<div class="alert alert-success">'.$stmt->rowCount().'record update</div>';
								redirectHome($themsg, 'back',5);	
							}
					}else{
						$themsg= '<div class="alert alert-danger"> sorry the name is empty </div>';
						redirectHome($themsg ,'back');
					}




					echo "</div>";
					}else{
							$themsg= '<div class="alert alert-danger"> sorry can\'t browse page direct </div>';
								redirectHome($themsg);

					}
				


		}elseif ($do =='edit' ){
				$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

		       $stmt = $con->prepare("SELECT * FROM categories WHERE id = ?");
					// Execute Query
					$stmt->execute(array($catid));
					// Fetch The Data
					$cat = $stmt->fetch();
					// The Row Count
					$count = $stmt->rowCount();
					// If There's Such ID Show The Form
					if ($count > 0) { ?>

						   <h1 class="text-center">Edit category</h1>
						   <div class="container">
							<form class="form-horizontal" action="?do=update" method="POST">
							<input type="hidden" name="catid" value="<?php echo $catid ;?>">	
								<!-- Start name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">name</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="name" class="form-control"   required="required" placeholder="name of the catigory"
										 value="<?php echo $cat['name'];?>" />
									</div>
								</div>
								<!-- End name Field -->
								<!-- Start Discription Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Discription</label>
									<div class="col-sm-10 col-md-6"> 
										<input type="text" name="Discription" class="form-control"   placeholder=" password must be hard & complex" 
										 value="<?php echo $cat['discription'];?>" />
										
									</div>
								</div>
								<!-- End Discription Field -->
				
								<!-- Start ordering Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">ordering</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="ordering"  class="form-control"  placeholder="namber to arrange the catigories" value="<?php echo $cat['ordering'];?>" />
									</div>
								</div>
								<!-- End ordering Field -->
								<!-- Start catigory type Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">parent?</label>
									<div class="col-sm-10 col-md-6">
										<select name="parent">
											<option value="0">None</option>
										<?php 
	       								    $getcats=getallfrom('*','categories','WHERE parent= 0','','ordering');
	       								    foreach ($getcats as $c ) {
	       								    	echo "<option value='".$c['id']."'" ;
	       								    	if ($cat['parent']== $c['id'] ) {echo 'selected';}	  
	       								    	echo ">" .$c['name']. "</option>";
	       								    }
											?>
										</select>
									</div>
								</div>
								<!-- End catigory type Field -->
								<!-- Start visible Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">visible </label>
									<div class="col-sm-10 col-md-6">
										<div>
											<input id="ves-yes" type="radio" name="visible" value="0" <?php if($cat['visibility']==0){echo'checked';} ?>>
											<label for="ves-yes">yes</label>
										</div> 
										<div>
											<input id="ves-no" type="radio" name="visible" value="1"<?php if($cat['visibility']==1){echo'checked';} ?>>
											<label for="ves-no">No</label>
										</div> 
									</div>
								</div>
								<!-- End visible  Field -->
								<!-- Start commenting Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Allow commenting </label>
									<div class="col-sm-10 col-md-6">
										<div>
											<input id="com-yes" type="radio" name="commenting" value="0"
											 <?php if($cat['allow_comment']==0){echo'checked';} ?>>
											<label for="com-yes">yes</label>
										</div> 
										<div>
											<input id="com-no" type="radio" name="commenting" value="1"
											<?php if($cat['allow_comment']==1){echo'checked';} ?>>
											<label for="com-no">No</label>
										</div> 
									</div>
								</div>
								<!-- End commenting Field -->
								<!-- Start ads Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Allow ads  </label>
									<div class="col-sm-10 col-md-6">
										<div>
											<input id="ads-yes" type="radio" name="ads" value="0"<?php if($cat['allow_ads']==0){echo 'checked';} ?>>
											<label for="ads-yes">yes</label>
										</div> 
										<div>
											<input id="ads-no" type="radio" name="ads" value="1"<?php if($cat['allow_ads']==1){echo'checked';} ?>>
											<label for="ads-no">No</label>
										</div> 
									</div>
								</div>
								<!-- End ads Field -->

								<!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Update" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
							</form>
						</div>


					<?php
						// If There's No Such ID Show Error Message
					 }else {
						echo "<div class='container'>";
						$themsg='<div class="alert alert-danger">Theres No Such ID</div>';

						redirectHome($themsg ,3);
						echo "</div>";
		 	 		 } 



				}elseif ($do == 'update') {
					echo "<h1 class='text-center'> update catigory </h1>";
					echo "<div calss='container'>";

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						
						$id      = $_POST['catid'];
						$name    = $_POST['name'];
						$desc    = $_POST['Discription'];
						$order   = $_POST['ordering'];
						$parent  = $_POST['parent'];
						$visible = $_POST['visible'];
						$comment = $_POST['commenting'];
						$ads     = $_POST['ads'];

					if (!empty($name)) {
							$stmt= $con->prepare("UPDATE
														 categories 
														SET 
															name = ?,
															discription= ?,
															ordering =?,
															parent =?,
															visibility= ?,
															allow_comment= ?,
															allow_ads = ?
														WHERE
															id = ?");
						$stmt->execute(array($name, $desc, $order,$parent, $visible, $comment, $ads, $id));

							// echo success massge 
								$themsg = '<div class="alert alert-success">'.$stmt->rowCount().'record update</div>';
								redirectHome($themsg, 'back',3);	
							
						
					}			
					}else {
						$themsg = '<div class="alert alert-danger">sorry cant browse this page direct';
						redirectHome($themsg);
					}




					echo "</div>";
				}elseif ($do == 'delete') {
					echo "<h1 class='text-center'>delete catigory</h1>";
					echo '<div class="container">';
					$catid= isset($_GET['catid'])&& is_numeric($_GET['catid'])? intval($_GET['catid']):0;

					 $check=checkItem('id','categories',$catid);
					if ($check > 0 ) {
						$stmt=$con->prepare("DELETE FROM categories WHERE id = :zid ");

						$stmt->bindparam(":zid", $catid);
						$stmt->execute();
							$themsg = '<div class="alert alert-success">'. $stmt->rowCount(). 'record updates </div>';
 	 	    	redirectHome($themsg ,'back');
					}else{
							$themsg = '<div class="alert alert-danger">the id not exist</div>';
 	 	    	redirectHome($themsg ,'back');
 	 	    		}
					echo "</div>";
				}

				else {
					$themsg ="<div class='alert alert-danger'> error there is not found page</div> ";
					redirectHome($themsg ,'back');
				}


 	  include $tmp ."footer.php ";
    
	}
	 else{
			header('Location: index.php');
			exit();
		}

ob_end_flush();
?>