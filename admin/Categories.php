<?php
ob_start();  
session_start();
$pagetitle = isset($_GET['do']) ? $_GET['do'] . ' Categories' : 'Mange Categories';
if (isset($_SESSION['username'])) {
	include 'config.php';
    $cat = new cat ;
	$do = isset($_GET['do']) ? $_GET['do'] : 'mange';
    //start mange page ****************************************************************************************
	if ($do == 'mange') {
        $updown = 'asc';
        $updown = isset($_GET['order']) && in_array($_GET['order'], array('asc','desc')) ? $_GET['order'] : 'asc'; 
        $stmt = $con->prepare("select * from cats order by Name $updown");
        $stmt-> execute();
        $rows = $stmt->fetchall();
        ?>
       <h1 class="text-center"><?php echo lang ('mange-cat') ; ?></h1>
       <div class="container cats">
           <div class="panel-default panel-border-none">
               <div class="panel-heading panel-color2">
                   <?php echo lang ('panel-cat') ; ?>
                   <span style="float: right; position: relative;">
                       <span id="sort-label"><?php echo lang ('sort-cat') ; ?> |</span>
                       <a href="?order=desc" class="sort <?php echo $updown == 'desc' ? 'active' : null;  ?>"><i class="fa fa-sort-asc"></i></a>
                       <a href="?order=asc"  class="sort <?php echo $updown == 'asc' ? 'active' : null;  ?>"><i class="fa  fa-sort-desc"></i></a>                                              
                   </span>
               </div>
               <div class="panel-body">
                   <?php
                     foreach ($rows as $row) {?>
                        <div class="mr">
                            <div class="hidden-btn">
                                <a href="?do=edit&catid=<?php echo $row ['ID']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>&nbsp Edit</a>
                                <a href="?do=Delete&catid=<?php echo $row ['ID']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-close"></i>&nbsp Delete</a>
                            </div>
                            <h3><?php echo $row ['Name']; ?></h3>
                            <div class="toggle-h3">
                                <p><?php  echo $row ['desc']       == "" ? 'no description' : $row['desc'] ; ?></p>
                                <?php     echo $row ['visibility'] == 1  ? "<span class='opt-c1'>hidden    </span>": null ; ?>
                                <?php     echo $row ['allow_cmnt'] == 1  ? "<span class='opt-c2'>No Cmnt</span>": null ; ?>
                                <?php     echo $row ['allow_ads']  == 1  ? "<span class='opt-c3'>No Ads    </span>": null ; ?>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
               </div>
           </div>
       </div>
		
 <?php 
    }
    //start add page ******************************************************************************************
	elseif ($do == 'add') { ?>
        <h1 class="text-center">Add Category</h1>
        <div class="container">
            <form class="form-horizontal col-md-offset-2" action="?do=insert" method="POST">
                <!-- start name input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" autocomplete="off"
                        required="required">
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
                <!--  start order input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Order</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="order" class="form-control">
                    </div>
                </div>
                <!-- end order input-->
                <!-- start visibility input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">visibility</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="radio-bg">
                            <div>
                                <input id="vis-y" type="radio" name="visibility" value="0" checked>
                                <label for="vis-y">Yes</label>
                            </div>
                            <div>
                                <input id="vis-n" type="radio" name="visibility" value="1">
                                <label for="vis-n">No</label>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!-- end visibility input-->
                <!-- start cmnt input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Allow_comment</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="radio-bg">
                            <div>
                                <input id="cmnt-y" type="radio" name="cmnt" value="0" checked>
                                <label for="cmnt-y">Yes</label>
                            </div>
                            <div>
                                <input id="cmnt-n" type="radio" name="cmnt" value="1">
                                <label for="cmnt-n">No</label>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!-- end cmnt input-->
                <!-- start ads input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Allow_ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="radio-bg">
                            <div>
                                <input id="ads-y" type="radio" name="ads" value="0" checked>
                                <label for="ads-y">Yes</label>
                            </div>
                            <div>
                                <input id="ads-n" type="radio" name="ads" value="1">
                                <label for="ads-n">No</label>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!-- end ads input-->                                
                <!-- start submit input-->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="add Category"  class="btn btn-primary">
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
           $cat->setattr('',$_POST['name'],$_POST['description'],$_POST['order'],$_POST['visibility'],$_POST['cmnt'],$_POST['ads']);
           $cat->add();
        } 
        else {
            $msg = "<div class=\"alert alert-danger\">you can not inter this page dirictaly</div>";
            redirect ($msg);
        }
        echo "</div>";
	}
    //start edit page*****************************************************************************************
	elseif ($do == 'edit') {
        $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) :  0; 
        $stmt = $con->prepare("select * from cats where ID =?");
        //i delete sission user name exucte
        $stmt->execute(array($catid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit Category</h1>
            <div class="container">
                <form class="form-horizontal col-md-offset-2" action="?do=update" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                    <!-- start name input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" autocomplete="off" required="required" value="<?php echo $row['Name']; ?>">
                        </div>
                    </div>
                    <!-- end name input-->
                    <!-- start desc input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class="form-control" value="<?php echo $row['desc']; ?>">
                        </div>
                    </div>
                    <!-- end desc input-->
                    <!--  start order input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Order</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="order" class="form-control" value="<?php echo $row['order']; ?>">
                        </div>
                    </div>
                    <!-- end order input-->
                    <!-- start visibility input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">visibility</label>
                        <div class="col-sm-10 col-md-6">
                            <div class="radio-bg">
                                <div>
                                    <input id="vis-y" type="radio" name="visibility" value="0" <?php echo $row['visibility'] == 0 ? 'checked' : null; ?>>
                                    <label for="vis-y">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-n" type="radio" name="visibility" value="1" <?php echo $row['visibility'] == 1 ? 'checked' : null; ?>>
                                    <label for="vis-n">No</label>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <!-- end visibility input-->
                    <!-- start cmnt input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Allow_comment</label>
                        <div class="col-sm-10 col-md-6">
                            <div class="radio-bg">
                                <div>
                                    <input id="cmnt-y" type="radio" name="cmnt" value="0" <?php echo $row['allow_cmnt'] == 0 ? 'checked' : null; ?>>
                                    <label for="cmnt-y">Yes</label>
                                </div>
                                <div>
                                    <input id="cmnt-n" type="radio" name="cmnt" value="1" <?php echo $row['allow_cmnt'] == 1 ? 'checked' : null; ?>>
                                    <label for="cmnt-n">No</label>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <!-- end cmnt input-->
                    <!-- start ads input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Allow_ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div class="radio-bg">
                                <div>
                                    <input id="ads-y" type="radio" name="ads" value="0" <?php echo $row['allow_ads'] == 0 ? 'checked' : null; ?>>
                                    <label for="ads-y">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-n" type="radio" name="ads" value="1" <?php echo $row['allow_ads'] == 1 ? 'checked' : null; ?>>
                                    <label for="ads-n">No</label>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <!-- end ads input-->                                
                    <!-- start submit input-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Edit Category"  class="btn btn-primary">
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
            $cat->setattr($_POST['id'],$_POST['name'],$_POST['description'],$_POST['order'],$_POST['visibility'],$_POST['cmnt'],$_POST['ads']);
            $cat->update();             
        } 
        else {
            $msg = "<div class=\"alert alert-danger\">you can not inter this page dirictaly</div>";
            redirect ($msg);
        }
        echo "</div>";        
    }
    // start delete page ************************************************************************************ 
    elseif ($do == 'Delete') {
	    echo "<h1 class='text-center'>Delete</h1>";
        $deletID = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $cs = CheckSelect ('ID','cats',$deletID);
        if ($cs) {
            $stmt = $con->prepare("delete from cats where ID = ?");
            $stmt->execute(array($deletID));
            $count = $stmt->rowCount();
            $msg = "<div class=\"alert alert-danger\"> $count Category has been deleted</div>";
            echo "<div class='container'>";
            redirect ($msg,'back',3); 
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