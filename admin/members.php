<?php
ob_start();  
session_start();
$pagetitle = isset($_GET['do']) ? $_GET['do'] . ' Member' : 'Mange Member';
if (isset($_SESSION['username'])) {
	include 'config.php';
	$user = new user;
	$do = isset($_GET['do']) ? $_GET['do'] : 'mange';
    $current_page = isset($_GET['pn']) ? (int) $_GET['pn'] : 1;
    $start_from   = ($current_page - 1 ) * $pageNum ;
    //start mange page ****************************************************************************************
	if ($do == 'mange') { $user->mange(); ?>
		<h1 class="text-center">Mange Members</h1>
	    <div class="container">
	    	<div class="table-responsive">
	    		<table class="table table-bordered css-table">
	    			<tr>
	    				<th>ID</th>
	    				<th>Username</th>
	    				<th>Email</th>
	    				<th>fullName</th>
	    				<th>reg Date</th>
	    				<th>control</th>
	    			</tr>
	    			<?php 
	    			foreach ($rows as $key) {?>
	                    <tr>
		    				<td><?php echo $key['userID']; ?></td>
		    				<td><?php echo $key['username']; ?></td>
		    				<td><?php echo $key['email']; ?></td>
		    				<td><?php echo $key['fullname']; ?></td>
		    				<td><?php echo $key['date']; ?></td>
		    				<td>
		    					<a href="?do=edit&userid=<?php   echo  $key['userID']; ?>" class="btn btn-success btn-width"><i class="fa fa-edit"></i>&nbsp Edit</a>
		    					<a href="?do=Delete&userid=<?php echo $key['userID']; ?>" class="btn btn-danger shure btn-width"><i class="fa fa-times"></i> Delete</a>
		    					<?php
	                             if ($key['reg'] == 0) {?>
	                             <a href="?do=active&userid=<?php echo $key['userID']; ?>" class="btn btn-info btn-width"><i class="fa fa-check"></i>&nbsp Active</a>
	                        <?php } 
	                             if (isset($_GET['page']) && $_GET['page'] == 'aa' && $_SESSION['ID'] == 1) {?>
	                             <a href="?do=admin&userid=<?php echo $key['userID']; ?>" class="btn btn-warning btn-width"><i class="fa fa-plus"></i>&nbsp Admin</a>
	                        <?php } 
	                             if (isset($_GET['page']) && $_GET['page'] == 'admins' && $_SESSION['ID'] == 1) {?>
	                             <a href="?do=removeadmin&userid=<?php echo $key['userID']; ?>" class="btn btn-default btn-width"><i class="fa fa-times"></i> R-adm</a>
	                        <?php } ?>  
		    				</td>
		    			</tr>	    			
	    	  <?php } ?>
	    		</table>
                <div class="pagnation">
                    <div id="nums-container">
                        <?php
                        if (isset($_GET['page']) && $_GET['page'] == 'pending')  {
                            $count = TotalCount ('reg','users','=','0');
                        } elseif (isset($_GET['page']) && $_GET['page'] == 'aa') {
                            $count = TotalCount ('reg','users','=','1') - TotalCount ('groupID','users','=','1');	
                        } elseif (isset($_GET['page']) && $_GET['page'] == 'admins') {
                        	$count = TotalCount ('groupID','users','=','1');
                        } else {
                        	$count = TotalCount ('groupID','users','!=','1');
                        }         
                        $num = (int) ceil($count / $pageNum);
                        for ($i= $current_page - $num_page_count; $i <= $current_page + $num_page_count; $i++) {
                            if ($i > 0 && $i <= $num){
                                if (!isset($_GET['order'])) {?> 
                                    <a  class='pn <?php echo $i == $current_page ? "selected-page" : null  ?>  '  href="<?php echo isset($_GET['page']) ? '?page='. $_GET['page'] .  '&pn=' . $i : '?pn=' . $i ?>">
                                        <?php echo $i ?>
                                    </a>
                                 <?php 
                                } 
                            }
                        } ?>
                    </div>
                </div> 	    		
	    		<a href="?do=add" class="btn btn-primary btn-sm btn-ad"><i class="fa fa-plus"></i>&nbsp New Member</a>
	    	</div>
	    </div>
 <?php 
    }
    //start add page ******************************************************************************************
	elseif ($do == 'add') { ?>
		<h1 class="text-center">Add Member</h1>
		<div class="container">
			<form class="form-horizontal col-md-offset-2" action="?do=insert" method="POST">
				<!-- start username input-->
				<div class="form-group">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off"
						required="required">
					</div>
				</div>
				<!-- end username input-->
				<!-- start password input-->
				<div class="form-group">
					<label class="col-sm-2 control-label">password</label>
					<div class="col-sm-10 col-md-6">
						<input type="password" name="password" class="form-control" autocomplete="new-passwoed" >
					</div>
				</div>
				<!-- end password input-->
				<!-- start repassword input-->
				<div class="form-group">
					<label class="col-sm-2 control-label">re-password</label>
					<div class="col-sm-10 col-md-6">
						<input type="password" name="repassword" class="form-control" autocomplete="new-passwoed" >
					</div>
				</div>
				<!-- end repassword input-->				
				<!--  start Email input-->
				<div class="form-group">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control"
						required="required">
					</div>
				</div>
				<!-- end Email input-->
				<!-- start fullname input-->
				<div class="form-group">
					<label class="col-sm-2 control-label">fullname</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full" class="form-control"
						required="required">
					</div>
				</div>
				<!-- end fullname input-->
				<!-- start submit input-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="add Member" name="add-btn" class="btn btn-sm btn-primary">
					</div>
				</div>
				<!--end submit input-->
			</form>
		</div>
<?php
    } 
    //start insert page****************************************************************************************
	elseif ($do == 'insert') { ?>
		<h1 class="text-center">insert</h1>
		<div class ='container'>
	     <?php
			//check if admin comming from post [which coming from add form] not get
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$user->setattr('',$_POST['username'],$_POST['password'],$_POST['full'],$_POST['email']);
		     	$user->add('add-btn','repassword','password');
		     	if ($countinsert >= 0 && empty($formErrors)) {
		     	    $msg = '<div class="alert alert-success">'. $countinsert . ' row has added</div>';
			        redirect($msg,'BACK',5);
		     	}
		        foreach ($formErrors as $key) {
					echo '<div class="alert alert-danger">'. $key . '</div>';
		        }	     	  
			} 
			else {
				$msg = "<div class=\"alert alert-danger\">you can not inter this page dirictaly</div>";
				redirect ($msg);
			} ?>
	    </div>
	     <?php
	}
    //start edit page*****************************************************************************************
	elseif ($do == 'edit') { 
		$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) :  0;
		// disable admin edit
		if ($_SESSION['ID'] != 1 && $userid == 1) {
			$adminc = 0;
		} else {
			$adminc = $_SESSION['ID'] != 1 && in_array($userid, array(2,24)) && $userid != $_SESSION['ID'] ? 0 : $userid; 
		}
		$stmt = $con->prepare("select * from users where userID =? LIMIT 1");
		//i delete sission user name exucte
		$stmt->execute(array($adminc));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count > 0) {?>
			<h1 class="text-center">Edit Member</h1>
			<div class="container">
				<form class="form-horizontal col-md-offset-2" action="?do=update" method="POST">
				<input type="hidden" name="id" value="<?php echo $row ['userID']; ?>">
					<!-- start username input-->
					<div class="form-group">
						<label class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="username" class="form-control" autocomplete="off"
							value="<?php echo $row ['username']; ?>" required="required">
						</div>
					</div>
					<!-- end username input-->
					<!-- start password input-->
					<div class="form-group">
						<label class="col-sm-2 control-label">password</label>
						<div class="col-sm-10 col-md-6">
							<input type="hidden" name="oldpassword" value="<?php echo $row ['password']; ?>">
							<input type="password" name="password" class="form-control" autocomplete="new-passwoed">
						</div>
					</div>
					<!-- end password input-->
					<!--  start Email input-->
					<div class="form-group">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-6">
							<input type="email" name="email" class="form-control"
							value="<?php echo $row ['email']; ?>" required="required">
						</div>
					</div>
					<!-- end Email input-->
					<!-- start fullname input-->
					<div class="form-group">
						<label class="col-sm-2 control-label">fullname</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="full" class="form-control"
							value="<?php echo $row ['fullname']; ?>" required="required">
						</div>
					</div>
					<!-- end fullname input-->
					<!-- start submit input-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="save"  class="btn btn-sm btn-success">
						</div>
					</div>
					<!--end submit input-->
				</form>
			</div>
		<?php 
		} else {
			echo "<div class='container'>";
			$msg = "<div class ='alert alert-danger'>there no such id</div>";
			redirect($msg);
			echo "</div>";
		}
    } 
    // start update page **************************************************************************************
    elseif ($do == 'update') { ?>
		<h1 class="text-center">Update Member</h1>
		<div class ='container'>
		 <?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$user->setattr($_POST['id'],$_POST['username'],$_POST['password'],$_POST['full'],$_POST['email']);
		     	$user->update();
		        foreach ($formErrors as $key) {
					echo '<div class="alert alert-danger">'. $key . '</div>';
		        }
			} 
			else {
				$msg = "<div class=\"alert alert-danger\">you can not inter this page dirictaly</div>";
				redirect ($msg);
			} ?>
	    </div>
	 <?php 
    }
    // start delete page ************************************************************************************ 
    elseif ($do == 'Delete') {
	    echo '<h1 class="text-center">Delete Member</h1>';
        $user->delete();
    }
    // start active page ************************************************************************************
    elseif ($do == 'active') {
	    echo '<h1 class="text-center">Active</h1>';
        $user->active();
    }
    // start add admin ************************************************************************************
    elseif ($do == 'admin' && $_SESSION['ID'] == 1 ) {
	    echo '<h1 class="text-center">Add Admins</h1>';
        $user->setAdmin();
    }
    // start remove admin ************************************************************************************
    elseif ($do == 'removeadmin' && $_SESSION['ID'] == 1 ) {
	    echo '<h1 class="text-center">Remove Admins</h1>';
        $user->removeAdmin();
    }
// end all pages *****************************************************************************************
    include  $temp .'footer.php';
} else {
	header('location: index.php');
	exit();
}
ob_end_flush();