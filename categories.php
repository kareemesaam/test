<?php 
session_start();
include 'inti.php';?> 
 <div class="container">
 	 <h1 class="text-center">show items</h1>
 	<div class="row">
	 	<?php 
	 	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	 		
	 	
	 	 $items = getallfrom('*','items',"WHERE cat_id={$_GET['id']}",'AND approve=1','items_id');
	 		foreach ($items as $item) {
	 			echo "<div class='col-sm-6 col-md-3'>";
	 				echo "<div class='thumbnail item-box'>";
	 				echo '<span class="price-tag">'.$item['price'].'</span>';
	 					if (empty($item['image'])) {
								echo "<img class='responsive' src='image.jpg'>";
							}else{
								echo "<img class='responsive' src='admin/uploads/item_image//".$item['image'] ."'>";
							}
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