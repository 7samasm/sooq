<?php
ob_start();  
session_start();
$pagetitle = isset($_GET['do']) ? $_GET['do'] . ' comments' : 'Mange comments';
if (isset($_SESSION['username'])) {
	include 'config.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'mange';
    //start mange page ****************************************************************************************
	if ($do == 'mange') {
        // prepare , execute & fetchall
        $stmt = $con->prepare(" select
                                    comments.*,
                                    items.name as item_name,
                                    users.username
                                from
                                    comments
                                inner join
                                    items
                                on
                                    items.itemID = comments.item_id
                                inner join
                                    users
                                on
                                    users.userID = comments.user_id 
                                order by
                                    c_id desc");
        $stmt-> execute();
        $rows = $stmt->fetchall();
        if (empty($rows)) {
        	echo "<div class='container'>";
		        	 $msg = "<div class='alert alert-danger'>there're no recored yet </div>";
		        	 redirect($msg);
        	echo "</div>";
        } else {
		?>
			<h1 class="text-center">Mange Comments</h1>
		    <div class="container comments">
		    	<div class="table-responsive">
		    		<table class="table table-bordered css-table">
		    			<tr>
		    				<th>ID</th>
		    				<th>comment</th>
		    				<th>user</th>
		    				<th>item</th>
		    				<th>Date</th>
		    				<th>control</th>
		    			</tr>
		    			<?php 
		    			foreach ($rows as $key) {?>
		                    <tr>
			    				<td><?php echo $key['c_id']; ?></td>
			    				<td><?php echo $key['comment']; ?></td>
			    				<td><?php echo $key['username']; ?></td>
			    				<td><?php echo $key['item_name']; ?></td>
			    				<td><?php echo $key['c_date']; ?></td>
			    				<td>
			    					<a href="?do=edit&commentid=<?php    echo $key['c_id']; ?>" class="btn btn-success btn-width"><i class="fa fa-edit"></i>&nbsp Edit</a>
			    					<a href="?do=Delete&comment=<?php    echo $key['c_id']; ?>" class="btn btn-danger shure btn-width"><i class="fa fa-times"></i> Delete</a>
			    					<?php
		                             if ($key['status'] == 0) {?>
		                             <a href="?do=active&comment=<?php   echo $key['c_id']; ?>" class="btn btn-info btn-width"><i class="fa fa-check"></i>&nbsp Active</a>
		                        <?php } ?>  
			    				</td>
			    			</tr>	    			
		    	  <?php } ?>
		    		</table>
		    	</div>
		    </div>
 <?php
        } 
    }
    //start edit page*****************************************************************************************
	elseif ($do == 'edit') { 
		$commentid = (isset($_GET['commentid']) && is_numeric($_GET['commentid'])) ? intval($_GET['commentid']) :  0;
		$stmt = $con->prepare("select * from comments where c_id =? LIMIT 1");
		//i delete sission user name exucte
		$stmt->execute(array($commentid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count > 0) {?>
			<h1 class="text-center">Edit Comments</h1>
			<div class="container">
				<form class="form-horizontal col-md-offset-2" action="?do=update" method="POST">
				<input type="hidden" name="id" value="<?php echo $row ['c_id']; ?>">
					<!-- start comment input-->
					<div class="form-group">
						<label class="col-sm-2 control-label">comment</label>
						<div class="col-sm-10 col-md-6">
							<textarea  name="comment" class="form-control" autocomplete="off"  required="required"><?php echo $row ['comment']; ?></textarea>
						</div>
					</div>
					<!-- end comment input-->
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
    elseif ($do == 'update') {
		echo '<h1 class="text-center">Update</h1>';
		echo "<div class ='container'>";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//get post vars
	        $id       = $_POST['id'];
			$comment  = $_POST['comment'];
			//validate
			$formErrors = array();
			if (empty($comment)) {
				$formErrors[] = 'comment shoudnt be <strong>empty</strong>';
			}
			foreach ($formErrors as $key) {
				echo '<div class="alert alert-danger">'. $key . '</div>';
			}
				//chek if errors [arry] isnt found
			if (empty($formErrors)) {
				//qury
				$stmt = $con->prepare("UPDATE `comments` SET `comment` = ? WHERE `comments`.`c_id` = ?");
				//exute
				$stmt->execute(array($comment,$id));
				$countupdate = $stmt->rowCount();
				// the massege and redirect
				$msg = '<div class="alert alert-success">'. $countupdate . ' comment has been updated</div>';										
				redirect($msg,'BACK',2);
			}   
		} 
		else {
				$msg = "<div class=\"alert alert-danger\">you can not inter this page dirictaly</div>";
				redirect ($msg);
		}
		echo "</div>";
    }
    // start delete page ************************************************************************************ 
    elseif ($do == 'Delete') {
	    echo '<h1 class="text-center">Delete</h1>';
	    $comment = (isset($_GET['comment']) && is_numeric($_GET['comment'])) ? intval($_GET['comment']) :  0;
	    $del    = CheckSelect('c_id','comments',$comment);
		if ($del > 0) {
	        $stmt = $con->prepare("delete from comments where c_id = :zuserID ");
	        $stmt->bindparam(':zuserID',$comment);
	        $stmt->execute();
	        $countdel = $stmt->rowCount();
	        $msg = '<div class="alert alert-success">'. $countdel . ' comment has been Deleted</div>';
	        echo '<div class ="container">';
	        redirect ($msg,'back');
	        echo '</div>';
        }
    }
    // start active page ************************************************************************************
    elseif ($do == 'active') {
	    echo '<h1 class="text-center">Active Comments</h1>';
		$comment = (isset($_GET['comment']) && is_numeric($_GET['comment'])) ? intval($_GET['comment']) :  0;
	    $del = CheckSelect('c_id','comments',$comment);
		if ($del > 0) {
	        $stmt = $con->prepare("UPDATE `comments` SET `status` = 1 where c_id = :zuserID");
	        $stmt->bindparam(':zuserID',$comment);
	        $stmt->execute();
	        $countdel = $stmt->rowCount();
	        $msg = '<div class="alert alert-success">'. $countdel . ' comment has been actived</div>';
	        echo '<div class ="container">';	        
	        redirect ($msg,'back');
	        echo '</div>';
        }
    }
// end all pages *****************************************************************************************
    include  $temp .'footer.php';
} else {
	header('location: index.php');
	exit();
}
ob_end_flush();