<?php
session_start();
$pageTitle= 'show item';
 include 'inti.php'; 
 if (isset($_SESSION['user'])) {
 	//check get item id & get ineger value
 	$itemid= isset($_GET['itemid'])&& is_numeric($_GET['itemid'])? intval($_GET['itemid']):0 ;

 	$stmt = $con->prepare('SELECT items.* ,
 							categories.name AS category_name , 
 							users.username
 	 						FROM
 	 							 items
 	 						INNER JOIN 
 	 							categories
 	 						ON 
 	 							categories.id = items.cat_id 
 	 						INNER JOIN
 	 							users
 	 						ON
 	 							users.user_id= items.member_id
 	 					 	WHERE items_id =?
 	 					 	AND approve = 1 ');
 	$stmt->execute(array($itemid));

 	$count = $stmt->rowCount();
 	if ($count > 0 ) {
 
 	
 		$item = $stmt->fetch();
 	
		echo "<h1 class='text-center'>".$item['name']."</h1>";
		?>
		<div class="container">
			<div class="row">
				<div class='col-md-3'>
					<img class='img-responsive img-thumbnail center-block' src='image.jpg' alt='' />
				</div>
				<div class='col-md-9 item-info'>
					<h2><?php echo $item['name'] ; ?></h2>
					<p><?php echo $item['describtion'] ; ?></p>

					<ul class="list-unstyled">
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<?php  echo 'added_date : ' .$item['add_date'] ; ?>
								
							</li>
						<li>
							<i class="fa fa-money fa-fw"></i>
							<?php echo 'price : ' .$item['price'] ; ?>
								
						</li>
						<li>
							<i class="fa fa-building fa-fw"></i>
							<?php echo 'made in  : ' .$item['country_made'] ; ?>
								
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<?php echo 'category  : <a href="categories.php?id='.$item['cat_id'].'"> 
						' .$item['category_name'].'</a>' ; ?>
								
						</li>
						<li>
							<i class="fa fa-user fa-fw"></i>
							<?php echo 'added by   : <a href="#">' .$item['username'].'</a>' ; ?>
						</li>
						<li class="item-tags">
							<i class="fa fa-tags fa-fw"></i>
							<span> tags </span>  : 
							<?php
							$alltags =explode(',', $item['tags']);
								foreach ($alltags as $tag) {
									$tag = str_replace(' ', '', $tag);
									$lowertag = strtolower($tag);
									if (! empty($tag)) {						
									echo "<a href='tags.php?name={$lowertag}'>".$tag."</a>  ";
								}}
							 ?>
						</li>
					</ul>
				</div>
			</div>
			<?php if (isset($_SESSION['user'])) { ?>
			<!--start add comment -->
			<hr class="castom-hr">
			<div class="row">
				<div class="col-md-offset-3">
					<div class="add-comment">
						<h3>add your comment</h3>
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] .'?itemid='.$item['items_id'] ;?>">
							<textarea name="comment" required="required"></textarea>
							<input class="btn btn-primary" type="submit" value="add comment" >
						</form>
				<?php 
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING) ;
					$itemid  = $item['items_id'];
					$userid  = $_SESSION['uid'];

					if (!empty($comment)) {
						
						$stmt= $con->prepare("INSERT INTO 
								comments(comment , status ,comment_date,item_id , user_id)
								VALUES (:zcomment , 0 , now() ,:zitemid , :zuserid) 
							");
						$stmt->execute(array(
							'zcomment' => $comment,
							'zitemid'  => $itemid ,
							'zuserid' => $userid 
						));

						if ($stmt) {
							echo "<div class='alert alert-success'>comment added </div>";
						}
					}
				}
				?>
					</div>
				</div>
			</div>
			<!--end add comment -->
			<?php }else{
				echo "<a href='login.php'>login</a> or <a href='login.php'>register</a> To add comment";
			} 
			echo '<hr class="castom-hr">';
			//select and show all data   
 	 		$stmt=$con->prepare("SELECT
 	 									 comments.* , users.username AS member
	 	 							FROM 
	 	 								comments
	 	 							
	 								INNER JOIN 
	 									users
	 								ON
	 									users.user_id = comments.user_id 
	 								WHERE 
	 									item_id = ? 
	 								AND 
	 									status = 1 
	 									");

 	 		$stmt->execute(array($itemid));

 	 		$comments= $stmt->fetchAll();

 	 		foreach ($comments as $comment) {?>
 	 		<div class="comment-box">
 	 			<div class="row">
	 	 			<div class="col-md-2 text-center">
	 	 				<img class='img-responsive img-thumbnail img-circle center-block' src='image.jpg' alt='' />
	 	 				<?php echo $comment['member'] ;?>
	 	 			</div>
	 	 			<div class="col-md-10">
	 	 				<p class="lead"> <?php echo $comment['comment'] ;?> </p>			
	 	 				</div>
 	 			</div>
 	 			</div>
 	 			<hr class="castom-hr">
 	 	<?php 	}
 	 			
		
		

		
	echo "</div>";
 	}else{
 		echo "<div class='alert alert-danger'> there\'s no sush id or this item wait approved  </div>";
 	}

 	
 }else{
 	header('Location:login.php');
 }	
 include $tmp ."footer.php "; ?>