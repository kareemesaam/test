<!DOCTYPE HTML>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo getTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $css?>font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $css?>jquery-ui.css">
	<link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css">
	<link rel="stylesheet" href="<?php echo $css?>forntend.css">


</head>
<body>
<div class="upper-bar ">
  <div class="container">

          <?php  if(isset($_SESSION['user'])) {
         ?>
         <img class='my-imge  img-thumbnail img-circle' src='image.jpg' alt='' />
            <div class="btn-group my-info ">
                <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <?php echo $_SESSION['user'] ?>
                  <span class="caret"></span>
                </span>
                <ul class="dropdown-menu">
                  <li><a href='profile.php'> my profile</a></li>
                  <li><a href='newad.php'>New item</a></li>
                   <li><a href='profile.php#my-items'>my items</a></li>
                  <li><a href='logout.php'>logout</a></li>
                </ul>
            </div>

  <?php /* if(isset($_SESSION['user'])) {
            echo "<span class='name'>welcome <a href='profile.php'>". $_SESSION['user'] .'</a></span>' ;
            echo " ";
            echo " - <a href='newad.php'>New item</a>";
            echo " - <a href='logout.php'>logout</a>";
            $status= userstatus($_SESSION['user']);
            if ($status == 1 ) {
              //user is not active*/
           // }
  } else { ?>
    <a href="login.php">
      <span class="pull-right">login/signUp</span>
    </a>
    <?php } ?>
  </div>
</div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Homepage</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php 
      $getcats= getallfrom('*','categories',"where parent = 0",'','ordering','ASC');  
      foreach ($getcats as $cat) {
        echo '<li> <a href="categories.php?id='. $cat['id'].'&name='.str_replace(" ", "-", $cat['name']).'" >'. $cat['name'].' </a></li>';
      } ?>
      </ul>
     
    </div>
  </div>
</nav>
