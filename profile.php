<?php 
ob_start(); 
session_start();
$pagetitle =  'My Profile';
include 'config.php';
//func
$getUserInfos = getUser('username',$userSession) ;
$getitems = getitems('member_id','=',getUserId ());
if ($userSession == '') {
	header('Location: login.php');
	exit();
} 
?>
<div class="container">
	<div class="row profile">
		<div class="profile-block col-xs-12 col-bxs-12">
			<div class="panel panel-info" style="margin-top: 70px">
				<div class="panel-heading">معلومات الحساب</div>
				<div class="panel-body">
				    <ul>
				        <?php foreach ($getUserInfos as $info) { ?>
						<li>
						    <i class="fa fa-unlock-alt fa-fw"></i>
							<span>اسم المستخدم</span>       : <?php echo $userSession; ?>
						</li>
	                    <li>
	                        <i class="fa fa-envelope-o fa-fw"></i>
	                    	<span>البريد الاكتروني</span>      : <?php echo $info['email'];  ?>
	                    </li>
	                    <li>
	                        <i class="fa fa-user fa-fw"></i>
	                    	<span>الاسم الكامل</span>  : <?php echo $info['fullname'];  ?>
	                    </li> 
	                    <li>
	                        <i class="fa fa-calendar fa-fw"></i>
	                    	<span>تاريخ التسجيل</span>  : <?php echo $info['date'];  ?>
	                    </li>
	                    <li>
	                        <i class="fa fa-lock fa-fw"></i>
	                    	<span>حالة الحساب</span> : <?php echo $info['reg']== 1 ? "<strong style='color : #5cb85c'>مفعل</strong>" : "<strong style='color : #f00'>غير مفعل</strong>" ?>
	                    </li>
						<?php  }  ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="clear-fix"></div>
		<div class="profile-block col-xs-12 col-bxs-12">
			<div class="panel panel-info">
				<div class="panel-heading">اعلاناتي</div>
				<div class="panel-body">
					<?php
					   echo empty($getitems) ? "ليس لديك اعلانات لعرضها <strong><a href='add.php' class='btn btn-warning btn-sm'>اضف اعلان</a></strong>" : null;
					   foreach ($getitems as $item) 
					   {
						 	include $temp . 'cards.php';
				       } ?>
					<div class="clear-fix"></div>
				</div>
			</div>
		</div>
		<div class="clear-fix"></div>				
	</div>
</div>
<?php 
include  $temp .'footer.php';
ob_end_flush();
?>