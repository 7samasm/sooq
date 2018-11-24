<?php 
ob_start(); 
session_start();
$pagetitle= "login";
include 'config.php';
include  'admin/' . $func . 'class.php';
if ($userSession != '') {
	header('Location: profile.php');
	exit();
}
$frontUser = new user;
//check if user comming from http post requset
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$full  = isset($_POST['fullname']) ? $_POST['fullname'] : '';
	$email = isset($_POST['email'])    ? $_POST['email']    : '';
    $frontUser->setattr('',$_POST['user'],$_POST['pass'], $full,$email);
    $frontUser->login('login-btn','','user','frontID','location: index.php');
    $frontUser->add('signup-btn','re-pass');
    if($countinsert > 0) {
        $_SESSION['user']     = $_POST['user'];       //REGESTER Session Name
       	header('location: profile.php');
        exit();	
    }
} ?>
    <div class="container login-signup">
        <h1 class="text-center">
	       <span data-class="login" class="selected">ادخل </span>|
	       <span data-class="signup"> سجل</span>
        </h1>
	    <form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
	      <input type="text" name="user" autocomplete="off" class="form-control" placeholder="اسم المستخدم">
	      <input type="password" name="pass" autocomplete="new-password" class="form-control" placeholder="كلمة المرور">
	      <input type="submit"  value="ادخل" class="btn btn-success text-center" name="login-btn">
	    </form>
	    <form class="signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
	      <input type="text" name="user" autocomplete="off" class="form-control " placeholder="اسم المستخدم">
	      <input type="password" name="pass" autocomplete="new-password" class="form-control" placeholder="كلمة المرور">
	      <input type="password" name="re-pass" autocomplete="new-password" class="form-control" placeholder="اعد كلمة المرور">
	      <input type="text" name="fullname" autocomplete="off" class="form-control " placeholder="الاسم الكامل">
	      <input type="email" name="email" placeholder="البريد الالكتروني" class="form-control">
	      <input type="submit"  value="سجل" class="btn btn-danger text-center" name="signup-btn">
	    </form>
	    <div class="text-center">
	    	<?php
	    	if (isset($_POST['signup-btn'])) {//check post signup 
		        foreach ($formErrors as $error) {
		    		echo '<p>'. $error . '</p>';
		    	}
	        }
	    	?>
	    </div>	    
    </div>

<?php 
include  $temp .'footer.php';
ob_end_flush();
?>