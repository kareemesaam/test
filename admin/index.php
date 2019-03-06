<?php
 session_start();
 $pageTitle = 'Login';
 $noNavbar='';

 if (isset($_SESSION['Username'])) {
 	 header('Location: dashboard.php');
 }
 include 'inti.php'; 
 

 	if ($_SERVER['REQUEST_METHOD']=='POST') {

 		$username =$_POST['user'];
 		$password =$_POST['pass'];
 		$hashedpass=sha1($password);
 		
 		/*chek if user exist in database */
 		$stmt = $con->prepare("SELECT user_id ,username , password FROM users WHERE username = ? AND password = ? AND group_id = 1" );
 		$stmt->execute(array($username , $hashedpass));
 		$row = $stmt->fetch();
 		$count = $stmt->rowcount();
 		echo $count ;
 		if ($count > 0 ) {
 			$_SESSION['Username']= $username ; //register session name 
 			$_SESSION['id']= $row['user_id'] ;//register id name 
 			header('Location:dashboard.php');// redirect to dashboard page 
 			exit();
 		}
}
 ?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="Login" />
	


<?php include $tmp ."footer.php "; ?>