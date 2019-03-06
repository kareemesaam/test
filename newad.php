<?php
session_start();
$pageTitle='creat new item';
 include 'inti.php'; 
 if (isset($_SESSION['user'])) {

 	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 		$formerroes = array();

 		$title 		= filter_var($_POST['name'],FILTER_SANITIZE_STRING);
 		$desc  		= filter_var($_POST['Discription'],FILTER_SANITIZE_STRING);
 		$price 	    = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
 		$country 	= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
 		$tags 		= filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
 		$status 	= filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
 		$category 	= filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);


 		if (strlen($title)< 4 ) {
 			$formerroes[] = "the title mast be more than 4 char";
 		}

 		if (strlen($desc)< 8 ) {
 			$formerroes[] = "the description mast be more than 8 char";
 		}

 		if (strlen($country)< 3) {
 			$formerroes[] ="the country mast be more than 3 char";
 		}

 		if (empty($price)) {
 			$formerroes[] = "price cant be empty";
 		}
 		if (empty($status)) {
 			$formerroes[] = "status cant be empty";
 		}
 		if (empty($category)) {
 			$formerroes[] = "category cant be empty";
 		}
 	

 		if (empty($formerroes)) {
					
				
			$stmt = $con->prepare("INSERT INTO
					 items(name,describtion,price,add_date,	country_made,tags,status ,cat_id,member_id) 
					 VALUES(:zname , :zdesc, :zprice , now() , :zcountry ,:ztags,:zstat,:zcat, :zmember) ");

					$stmt->execute(array(
						':zname' 	=>$title,
						':zdesc'	=>$desc,
						':zprice'	=>$price,
						':zcountry' =>$country,
						':ztags'    =>$tags,
						':zstat'	=>$status,
						':zcat'	    =>$category,
						':zmember'	=>$_SESSION['uid']	
						));
						//success massege
					if ($stmt) {
						$succesmsg = ' item has been added ';
					}
}

 	}
 ?>

<h1 class='text-center'><?php echo $pageTitle ?></h1>
<div class="infromation block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"> <?php echo $pageTitle ?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal" action="?do=insert" method="POST">
								
								<!-- Start name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">name</label>
									<div class="col-sm-10 col-md-9">
										<input pattern=".{4,}" title="this faild require least 4 char" 
										type="text" name="name" class="form-control live" 
										 placeholder="name of the items"/
										 data-class='.live-name' autocomplete="off"  required>
									</div>
								</div>
								<!-- End name Field -->
								<!-- Start Discription Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Discription</label>
									<div class="col-sm-10 col-md-9"> 
										<input <input pattern=".{10,}" title="this faild require least 10 char"
										type="text" name="Discription" class="form-control live"   placeholder="Discription of the items"
										data-class='.live-desc' autocomplete="off" required />
										
									</div>
								</div>
								<!-- End Discription Field -->
								<!-- Start price Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">price</label>
									<div class="col-sm-10 col-md-9">
										<input type="text" name="price" autocomplete="off"  class="form-control live"  placeholder="price of the item "
										data-class='.live-price' required />
									</div>
								</div>
								<!-- End price Field -->
									<!-- Start country Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">country</label>
									<div class="col-sm-10 col-md-9">
										<input type="text" name="country" autocomplete="off"  class="form-control"  placeholder="country of made " required/>
									</div>
								</div>
								<!-- End price Field -->
								<!-- Start tags Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">tags</label>
									<div class="col-sm-10 col-md-9">
										<input type="text" name="tags"  class="form-control"  placeholder="separate tags with comma (,)" />
									</div>
								</div>
								<!-- End tags Field -->
										<!-- Start status Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">status</label>
									<div class="col-sm-10 col-md-9">
										<select  name="status" required >
											<option value="">....</option>
											<option value="1">new</option>
											<option value="2">like new </option>
											<option value="3">used</option>
											<option value="4">very old</option>
										</select>	
									</div>
								</div>
								<!-- End status Field -->
												
				           <!-- Start category Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">category</label>
									<div class="col-sm-10 col-md-9">
										<select  name="category" required >
											<option value="">....</option>
										<?php 
											$cats= getallfrom('*','categories', '','' ,'id');
											
											foreach ($cats as $cat) {
												echo "<option value='". $cat['id'] ."'>". $cat['name']."</option>";
											}
										 ?>
										</select>	
									</div>
								</div>
								<!-- End category Field -->
								<!-- Start Submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-3 col-sm-9">
										<input type="submit" value="add item" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
							</form>
					</div>
					<div class="col-md-4">
						<div class='thumbnail item-box live-preview'>
				 				<span class="price-tag">$
				 					<span class="live-price">0</span>
				 				</span>
				 					<img class='responsive' src='image.jpg' alt='' />
				 					<div class='caption'>
				 						<h3 class="live-name">test</h3>
				 						<p class="live-desc">description</p>
				 					</div>
				 				</div>					
					</div>
					</div>
					<!--start lopping through error -->
					<?php  
						if (!empty($formerroes)) {
							foreach ($formerroes as $error ) {
							 echo "<div class='alert alert-danger'>".$error."</div>";
							}
						}
						if (isset($succesmsg)) {
							echo '<div class="alert alert-success">'.$succesmsg.'</div>';
						}
					?>
					<!--start lopping through error -->
				</div>
			</div>	
		</div>	
	</div>
</div>
 <?php 
 }else{
 	header('Location:login.php');
 }	
 include $tmp ."footer.php "; ?>