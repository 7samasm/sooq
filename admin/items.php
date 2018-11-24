<?php
ob_start();  
session_start();
$pagetitle = isset($_GET['do']) ? $_GET['do'] . ' items' : 'Mange items';
if (isset($_SESSION['username'])) {
	include 'config.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'mange';
    $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $start_from   = ($current_page - 1 ) * $pageNum ;
    //start mange page ****************************************************************************************
	if ($do == 'mange') {
        // prepare , execute & fetchall
        $stmt = $con->prepare(" select
                                    items.*,
                                    cats.Name as category_name,
                                    users.username
                                from
                                    items
                                inner join
                                    cats
                                on
                                    cats.ID = items.cat_id
                                inner join
                                    users
                                on
                                    users.userID = items.member_id
                                order by
                                    itemid desc
                                limit 
                                    $start_from,$pageNum
                                ");
        $stmt-> execute();
        $rows = $stmt->fetchall();
        ?>
        <h1 class="text-center">Mange items</h1>
        <div class="container mange-items">
            <div class="table-responsive">
                <table class="table table-bordered css-table">
                    <tr>
                        <th>#ID</th>
                        <th>item name</th>
                        <th>description</th>
                        <th>prise</th>
                        <th>Date</th>
                        <th>username</th>
                        <th>category</th>
                        <th>control</th>
                    </tr>
                    <?php 
                    foreach ($rows as $key) {?>
                        <tr>
                            <td><?php echo $key['itemID']; ?></td>
                            <td><?php echo $key['name']; ?></td>
                            <td><?php echo $key['description']; ?></td>
                            <td><?php echo $key['price'] . ' SDG'; ?></td>
                            <td><?php echo $key['date']; ?></td>
                            <td><?php echo $key['username']; ?></td>
                            <td><?php echo $key['category_name']; ?></td>
                            <td>
                                <a href="?do=edit&itemid=<?php echo $key['itemID']; ?>" class="btn btn-success btn-width"><i class="fa fa-edit"></i>&nbsp Edit</a>
                                <a href="?do=Delete&itemid=<?php echo $key['itemID']; ?>" class="btn btn-danger shure btn-width"><i class="fa fa-times"></i>&nbsp Delete</a> 
                            </td>
                        </tr>                   
              <?php } ?>
                </table>
                <div class="pagnation">
                    <div id="nums-container">
                        <?php
                        $count = TotalCount ('itemID','items','>','0');
                        $num = (int) ceil($count / $pageNum);
                        for ($i= $current_page - $num_page_count; $i <= $current_page + $num_page_count; $i++) {
                            if ($i > 0 && $i <= $num){
                                if (!isset($_GET['order'])) {?> 
                                    <a  class='pn <?php echo $i == $current_page ? "selected-page" : null  ?>  '  href="?page=<?php echo $i ?>">
                                        <?php echo $i ?>
                                    </a>
                                 <?php 
                                } 
                            }
                        } ?>
                    </div>
                </div>                
                <a href="?do=add" class="btn btn-primary btn-sm btn-ad"><i class="fa fa-plus"></i>&nbsp New item</a>
            </div>
        </div>
 <?php 
    }
    //start add page ******************************************************************************************
	elseif ($do == 'add') { ?>
		<h1 class="text-center">Add item</h1>
        <div class="container">
            <form class="form-horizontal col-md-offset-2" action="?do=insert" method="POST">
                <!-- start name input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Item Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" required="required">
                    </div>
                </div>
                <!-- end name input-->
                <!-- start desc input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control">
                    </div>
                </div>
                <!-- end desc input--> 
                <!-- start price input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">price (SDG)</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="number" name="price" class="form-control" required="required">
                    </div>
                </div>
                <!-- end price input-->
                <!-- start made in input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">made in</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="madeIN" class="form-control">
                    </div>
                </div>
                <!-- end made in input-->
                <!-- start status input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">status</label>
                    <div class="col-sm-10 col-md-6">
                       <select class="form-control" name="status">
                           <option value="new">new</option>
                           <option value="like new">like new</option>
                           <option value="old">old</option>
                       </select>
                    </div>
                </div>
                <!-- end status input-->
                <!-- start cats input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">catigory</label>
                    <div class="col-sm-10 col-md-6">
                       <select class="form-control" name="cats">
                           <?php
                              $st = $con->prepare("select Name,ID from cats order by ID asc");
                              $st->execute();
                              $cats = $st->fetchall();
                              foreach ($cats as $cat) { ?>
                                  <option value="<?php echo $cat['ID']; ?>"><?php echo $cat['Name']; ?></option>
                              <?php } ?>
                       </select>
                    </div>
                </div>
                <!-- end cats input-->                                        
                <!-- start submit input-->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="add item"  class="btn btn-sm btn-primary">
                    </div>
                </div>
                <!--end submit input-->
            </form>
        </div>	
<?php
    } 
    //start insert page****************************************************************************************
	elseif ($do == 'insert') {
		echo '<h1 class="text-center">insert</h1>';
        echo "<div class ='container'>";
        //check if admin comming from post [which coming from add form] not get
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //get post vars 
            $Name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];
            $madeIN   = $_POST['madeIN'];
            $status   = $_POST['status'];
            $postCT   = $_POST['cats'];
            //validate
            $formErrors = array();
            if (empty($Name)) {
                $formErrors[] = 'Name shoudnt be <strong>empty</strong>';
            }
            if (empty($price)) {
                $formErrors[] = 'price shoudnt be <strong>empty</strong>';
            }
            foreach ($formErrors as $key) {
                echo '<div class="alert alert-danger">'. $key . '</div>';
            }
                //chek if errors [arry] isnt found
            if (empty($formErrors)) {
                //insert qury
                $stmt = $con->prepare("insert into items (name,description,price,made_in,status,date,cat_id,member_id) values (?,?,?,?,?,now(),?,?)");
                //exute
                $stmt->execute(array($Name,$desc,$price,$madeIN,$status,$postCT,$_SESSION['ID']));
                $countupdate = $stmt->rowCount();
                $msg = '<div class="alert alert-success">'. $countupdate . ' item has added</div>';
                redirect($msg,'BACK',2);
            }   
        } 
        else {
            $msg = "<div class=\"alert alert-danger\">you can not inter this page dirictaly</div>";
            redirect ($msg);
        }
        echo "</div>";
	}
    //start edit page*****************************************************************************************
	elseif ($do == 'edit') {
        $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        $stmt   =  $con->prepare("select * from items where itemID = ?");
        $stmt   -> execute(array($itemid));
        $iu     =  $stmt -> fetch();
        $iucount=  $stmt -> rowCount();
        if ($iucount > 0) {
     ?>
            <h1 class="text-center">Edit item</h1>
            <div class="container">
                <form class="form-horizontal col-md-offset-2" action="?do=update" method="POST">
                <input type="hidden" name="itemhid" value="<?php echo $iu['itemID']; ?>">
                    <!-- start name input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Item Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" required="required" value="<?php echo $iu['name']; ?>">
                        </div>
                    </div>
                    <!-- end name input-->
                    <!-- start desc input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class="form-control" value="<?php echo $iu['description']; ?>">
                        </div>
                    </div>
                    <!-- end desc input--> 
                    <!-- start price input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">price (SDG)</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="number" name="price" class="form-control" required="required" value="<?php echo $iu['price']; ?>">
                        </div>
                    </div>
                    <!-- end price input-->
                    <!-- start made in input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">made in</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="madeIN" class="form-control" value="<?php echo $iu['made_in']; ?>">
                        </div>
                    </div>
                    <!-- end made in input-->
                    <!-- start status input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">status</label>
                        <div class="col-sm-10 col-md-6">
                           <select class="form-control" name="status">
                               <option value="new">new</option>
                               <option value="like new">like new</option>
                               <option value="old">old</option>
                           </select>
                        </div>
                    </div>
                    <!-- end status input-->
                    <!-- start cats input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">catigory</label>
                        <div class="col-sm-10 col-md-6">
                           <select class="form-control" name="cats">
                               <?php
                                  $st = $con->prepare("select Name,ID from cats order by ID asc");
                                  $st->execute();
                                  $cats = $st->fetchall();
                                  foreach ($cats as $cat) { ?>
                                      <option value="<?php echo $cat['ID']; ?>"><?php echo $cat['Name']; ?></option>
                                  <?php } ?>
                           </select>
                        </div>
                    </div>
                    <!-- end cats input-->                                        
                    <!-- start submit input-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Edit item"  class="btn btn-sm btn-primary">
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
            $ii       = $_POST['itemhid'];
            $Name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];
            $madeIN   = $_POST['madeIN'];
            $status   = $_POST['status'];
            $postCT   = $_POST['cats'];
            //validate
            $formErrors = array();
            if (empty($Name)) {
                $formErrors[] = 'Name shoudnt be <strong>empty</strong>';
            }
            if (empty($price)) {
                $formErrors[] = 'price shoudnt be <strong>empty</strong>';
            }
            foreach ($formErrors as $key) {
                echo '<div class="alert alert-danger">'. $key . '</div>';
            }
                //chek if errors [arry] isnt found
            if (empty($formErrors)) {
                //qury
                $stmt = $con->prepare("UPDATE `items` SET `name` = ?,description = ?,price=?,made_in=?, status=?, cat_id=? WHERE `items`.`itemID` = ? ");
                //exute
                $stmt->execute(array($Name,$desc,$price,$madeIN,$status,$postCT,$ii));
                $countupdate = $stmt->rowCount();
                // the massege and redirect
                $msg = '<div class="alert alert-success">'. $countupdate . ' item has been updated</div>';                                        
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
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;
        $del    = CheckSelect('itemID','items',$itemid);
        if ($del > 0) {
            $stmt = $con->prepare("delete from items where itemID = :zuserID ");
            $stmt->bindparam(':zuserID',$itemid);
            $stmt->execute();
            $countdel = $stmt->rowCount();
            $msg = '<div class="alert alert-success">'. $countdel . ' item has been Deleted</div>';
            echo '<div class ="container">';
            redirect ($msg,'back');
            echo '</div>';
        }		    
    }
    // start active page ************************************************************************************
    elseif ($do == 'active') {
		    
    }
// end all pages *****************************************************************************************
    include  $temp .'footer.php';
} else {
	header('location: index.php');
	exit();
}
ob_end_flush();