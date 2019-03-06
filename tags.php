<?php 
session_start();
include 'inti.php';?> 
 <div class="container">
 	 
 	<div class="row">
	 	<?php 
	 	if (isset($_GET['name']) ) {
	 		$tag = $_GET['name'];
			echo "<h1 class='text-center'>".$tag."</h1>";
	 	
	 	 $tagitems = getallfrom('*','items',"WHERE tags like '%$tag%'",'AND approve=1','items_id');
	 		foreach ($tagitems as $item) {
	 			echo "<div class='col-sm-6 col-md-3'>";
	 				echo "<div class='thumbnail item-box'>";
	 				echo '<span class="price-tag">'.$item['price'].'</span>';
	 					echo "<img class='responsive' src='image.jpg' alt='' />";
	 					echo "<div class='caption'>";
	 						echo "<h3> <a href='items.php?itemid=".$item['items_id'] ."'>".$item['name'] ."</a></h3>";
	 						echo "<p>".$item['describtion'] ."</p>";
	 						echo "<div class='date'>".$item['add_date'] ."</div>";
	 					echo "</div>";
	 				echo "</div>";
	 			echo "</div>";
	 		}
	 	}else{
	 		 echo "<div class='alert alert-danger'>there/'s no sush id </div>"  ;
	 	}
	 	?>
	</div>		 
 </div>
 <?php include $tmp ."footer.php "; ?>