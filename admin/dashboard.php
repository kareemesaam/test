 <?php 

 session_start();

 if (isset($_SESSION['Username'])) {
 	 	 $pageTitle = 'dashboard';
 	 include 'inti.php';

 	 $numberusers = 3;
 	 $latestusers= getlatest ("*","users","user_id" ,$numberusers );

 	 $namberitem = 3;
 	 $latestitem= getlatest ("*","items","items_id" ,$namberitem );
  	?>
  	<div class="home-stats">
	  	<div class="container  text-center">
	  		<h1>Dashboard</h1>
	  		<div class="row">
	  			<div class="col-md-3">
	  				<div class="stat st-members">
	  				<i class="fa fa-users"></i>
	  				<div class="info">
	  						Total Members
	  					<span><a href="member.php"> <?php echo countitem('username' ,'users');?></a> </span>
	  				</div>
	  				</div>
	  			</div>
	  			<div class="col-md-3">
	  				<div class="stat st-pending">
	  					<i class="fa fa-user-plus"></i>
	  				<div class="info">
	  						pending Members
		  				<span><a href="member.php?do=manage&page=bending"> 
		  				<?php echo checkItem ('regStatus' ,'users', 0); ?>
		  					
		  				</a></span>
	  				</div>
		  			
	  				</div>
	  			</div>
	  			<div class="col-md-3">
	  				<div class="stat st-items">
	  					<i class="fa fa-tag"></i>
	  				    <div class="info">
	  							Total items
	  					<span><a href="items.php"> <?php echo countitem('items_id' ,'items');?></a> </span>
	  				   </div>  			
	  				</div>
	  			</div>
	  			<div class="col-md-3">
	  				<div class="stat st-comments">
	  					<i class="fa fa-comments"></i>
	  				    <div class="info">
	  						Total comments
	  						<span><a href="comments.php"> <?php echo countitem('c_id' ,'comments');?></a> </span>
	  				   </div>
	  					
	  				</div>
	  			</div>
	  		</div>
	  	</div>	

  	</div>
  	<div class="letest">
	  	<div class="container">
	  			<div class="row">
	  				<div class="col-md-6">
	  					<div class="panel panel-default">
	  						<div class="panel-heading">
	  							<i class="fa fa-users"></i>lastes <?php echo $numberusers ?> registred member 
	  							<span class="toggel-info pull-right">
	  								<i class="fa fa-plus fa-lg"></i>
	  							</span>
	  						</div>
	  						<div class="panel-body">
	  						<ul class="list-unstyled latest-users">	
	  							<?php  
	  								foreach ($latestusers as $user) {
	  									
	  								    echo '<li>';
											echo $user['username'];
											echo '<a href="member.php?do=edit&userid='. $user['user_id'].'">';

												echo '<span class="btn btn-success pull-right">';

											 	echo "<i class='fa fa-edit'></i> Edit ";

											 	if ($user['regStatus'] == 0 ) {
													echo"<a href='member.php?do=activate&userid=". $user['user_id']. "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> activate </a>";
												}
												echo '</span>';
										 echo '</a>';
										echo "</li>";
	  								}
	  							 ?>
	  						 </ul>
	  						</div>
	  					</div>
	  				</div>
	  				<div class="col-md-6">
	  					<div class="panel panel-default">
	  						<div class="panel-heading">
	  							<i class="fa fa-users"></i>lastes <?php echo $namberitem ?> items 
	  								<span class="toggel-info pull-right">
	  								<i class="fa fa-plus fa-lg"></i>
	  							</span>
	  						</div>
	  						<div class="panel-body">
	  						<ul class="list-unstyled latest-users">	
	  							<?php  
	  								foreach ($latestitem as $item) {
	  									
	  								    echo '<li>';
											echo $item['name'];
											echo '<a href="items.php?do=edit&item_id='. $item['items_id'].'">';

												echo '<span class="btn btn-success pull-right">';

											 	echo "<i class='fa fa-edit'></i> Edit ";

											 	if ($item['approve'] == 0 ) {
													echo"<a href='items.php?do=approve&item_id=". $item['items_id']. "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> approve </a>";
												}
												echo '</span>';
										 echo '</a>';
										echo "</li>";
	  								}
	  							 ?>
	  						 </ul>
	  						</div>
	  					</div>
	  				</div>
	  			</div>	
	  	</div>
	</div>  	

  	<?php 

 	 include $tmp ."footer.php ";
 } 
 else {
		header('Location: index.php');
		exit();
	}
 ?>
