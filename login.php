<?php 
session_start();
$pageTitle = 'Login';
if (isset($_SESSION['user'])) {
	header('Location: index.php') ;
}
include 'inti.php'; 

if ($_SERVER['REQUEST_METHOD']== 'POST') {

	if (isset($_POST['login'])) {

			$user= $_POST['username'];
			$pass= $_POST['password'];
			$hashedpass= sha1($pass);
			 
			 /*chek if user exist in database */
			 $stmt=$con->prepare('SELECT user_id ,username ,password FROM users WHERE username= ? AND password = ? ');
			 $stmt->execute(array($user,$hashedpass));
			 $get = $stmt->fetch();
			 $count = $stmt->rowCount();
			 if ($count > 0) {
			 	$_SESSION['user']=$user;//register session name 
			 	$_SESSION['uid']=$get['user_id'];//register session name 
			 	header('Location:index.php') ;
			 	exit();
	}		 
	}else{ 

		$formerror = array();

		$username= $_POST['username'];
		$email= $_POST['email'];
		$password= $_POST['password'];
		$password2= $_POST['password2'];
		// filter user name 
		if (isset($username)) {
			$filterUser= filter_var( $username , FILTER_SANITIZE_STRING);

			if (strlen($filterUser) <4 ) {
				$formerror[] = "username mast be larger than 4 char"; 
			}
		}
		//filter email
		if (isset($email)) {
			$filterUser= filter_var( $email, FILTER_SANITIZE_EMAIL);

			if (filter_var($filterUser, FILTER_VALIDATE_EMAIL) != true  ) {
				$formerror[] = "sorry the email not valide  "; 
			}
		}
		//filter password
		if (isset($password) && isset($password2)) {
			if (empty($password)) {
					$formerror[] = 'sorry password can\'t be empty';
			}
				if (sha1($password) !== sha1($password2)) {
					$formerror[] = 'sorry password is not match';
				}
		}
			if (empty($formErrors)) {

				//check if user exsit in database
				$check = checkItem('username','users',$username);
				if ($check > 0 ) {
					
					$formerror[] = 'sorry this user exist';
									
				}else{								
		 	 	    	// update the database with this data

	 	 	    	$stmt = $con->prepare("INSERT INTO users(username,password,email, regStatus , Date )
	 	 	    		 VALUES(:zuser, :zpass, :zemail, 0 ,now() )  ");

	 	 	    	$stmt->execute(array(
	 	 	    		'zuser' => $username ,
	 	 	    		'zpass' => sha1($password),
	 	 	    		'zemail'=> $email
	 	 	    		)); 
		 	 	    	// echo success messege 
	 	 	    	$succes_msg= 'congrats you are now register user ';
	 	        }
	 	    }
	}
}
?>
 


	<div class="container login-page">
		<h1 class="text-center">
			<span class="selected" data-class="login" >login</span>  |  <span data-class="SignUp"> signUp</span>
		</h1>
		<!--start login form -->
		<form class="login"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method ='POST'>
			<input class="form-control" type="text" name="username" autocomplete="off" placeholder="type your username" required="required">
			<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type your password" required="required">
			<input class="btn btn-primary" name="login" type="submit" value="login"  >
		</form>
		<!--end login form -->

			<!--start signup form -->
			<form class="SignUp" action="<?php echo $_SERVER['PHP_SELF'] ?>" method ='POST'>

			<input class="form-control" type="text" 
			pattern=".{4,}" title="username mast be larger than 4 char" 
			name="username" autocomplete="off" placeholder="type your username" required="required"  >

			<input class="form-control" type="email" name="email"  placeholder="type your email" required="required">

			<input class="form-control" type="password" name="password" minlength="4" 
			 autocomplete="new-password" placeholder="type your password" required="required" >

			<input class="form-control" type="password"  minlength="4" name="password2" autocomplete="new-password" placeholder="type your password agein " required="required" >
			<input class="btn btn-primary" name="signup"  type="submit" value="SignUp" >

		</form>
		<!--end signup form -->
		<div class="the-errors text-center">
			
			<?php if (!empty($formerror)) {
				foreach ($formerror as $error) {
				echo '<div class="msg error">' . $error . '</div>';

				}
			}
			if (isset($succes_msg)) {
			 	echo "<div class='msg succes'>".$succes_msg."</div>";
			 } 

			 ?>
		</div>
	</div>
 	
<?php include $tmp ."footer.php "; ?>