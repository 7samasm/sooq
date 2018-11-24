<?php 
session_start();
$nonavbar = '';
$pagetitle= "login";
include 'config.php';
if (isset($_SESSION['username'])) {
	header('location: dashboard.php');
}
$user     = new user;
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
$user->setattr('',$_POST['user'],$_POST['pass']);
$user->login('login','and groupID = 1','username','ID','location: dashboard.php');
}
 ?>

    <form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
      <input type="text" name="user" autocomplete="off" class="form-control f" placeholder="username">
      <input type="password" name="pass" autocomplete="new-password" class="form-control f" placeholder="password">
      <input type="submit"  value="login" name="login" class="btn btn-info btn-block">
    </form>

   <?php include  $temp .'footer.php';?>