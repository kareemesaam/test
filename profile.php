<?php
session_start();
$pageTitle= 'profile';
 include 'inti.php'; 
 if (isset($_SESSION['user'])) {
 	
 	$getuser = $con->prepare("SELECT * FROM users WHERE username = ? ");
 	$getuser->execute(array($_SESSION['user']));
 	$info= $getuser->fetch();

 ?>
<h1 class='text-center'>my profile</h1>
<div class="infromation block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">my information</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
						<span>name :</span>   <?php echo $info['username'] ;?>
				    </li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Fullname :</span>   <?php echo $info['fulname'] ;?>
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email :</span>   <?php echo $info['email'] ;?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>register date :</span>   <?php echo $info['Date'] ;?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>fav catigory :</span>					 
					</li>
				</ul>
				<a href="#" class="btn btn-primary">Edit infromtion</a>
			</div>	
		</div>	
	</div>
</div>
	
<div id='my-items' class="ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">my items</div>
			<div class="panel-body">
				<?php 
		 $items = getallfrom('*','items',"WHERE member_id={$info['user_id']}",'','items_id');
				 	
				 	if (!empty($items)) { 		
				 		foreach ($items as $item) {
				 			echo "<div class='col-sm-6 col-md-3'>";
				 				echo "<div class='thumbnail item-box'>";
				 				if ($item['approve'] == 0) {echo '<span class="approve-status"> not approved</span>'; }
				 				echo '<span class="price-tag">$'.$item['price'].'</span>';
				 					echo "<img class='responsive' src='image.jpg' alt='' />";
				 					echo "<div class='caption'>";
				 						echo "<h3><a href='items.php?itemid=".$item['items_id'] ."'>".$item['name'] ."</a></h3>";
				 						echo "<p>".$item['describtion'] ."</p>";
				 						echo "<div class='date'>".$item['add_date'] ."</div>";
				 					echo "</div>";
				 				echo "</div>";
				 			echo "</div>";
				 		}
				 	}else{
				 		echo "there is no ads to show create <a href='newad.php'>NewAdd</a>";
				 	}

	 	?>
			</div>	
		</div>	
	</div>
</div>

<div class="comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">letest comments</div>
			<div class="panel-body">
		<?php 
			$getcomments= getallfrom('comment','comments',"WHERE  user_id={$info['user_id']}",'','c_id');
				if ( ! empty($getcomments)) {
					foreach ($getcomments as $comment) {
						echo '<p>'. $comment['comment'].'</p>';
					}
				}else{
					echo "there is no comments to show ";
				}

			 ?>
			</div>	
		</div>	
	</div>
</div>		 
 <?php 
 }else{
 	header('Location:login.php');
 }	
 include $tmp ."footer.php "; ?>