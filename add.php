<?php 
ob_start(); 
session_start();
$pagetitle =  'اضف اعلان';
include 'config.php';
if ($userSession == '') {
	header('Location: login.php');
	exit();
}
$formErrors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get post vars 
    $Name     = $_POST['name'];
    $desc     = $_POST['description'];
    $price    = $_POST['price'];
    $madeIN   = $_POST['madeIN'];
    $status   = $_POST['status'];
    $postCT   = $_POST['cats'];
    // files
    $type      = $_FILES['file'] ['type'];
    $size      = $_FILES['file'] ['size'];
    $file_name = $_FILES['file'] ['name'];
    $file_from = $_FILES['file'] ['tmp_name'];
    $dir = "img/" . $file_name;
    if (in_array($type,array('image/png','image/jpeg')) || $type == '') {
    	if ($size < 200000) {
    		move_uploaded_file($file_from, $dir);
    		$path = $type == '' ? '' :'img/' . $file_name;
        } else {
           $formErrors[] = 'يجب ان تقل حجم الصورة عن 200kb' ;
        }
    } else {
       $formErrors[] = 'هذا الملف ليس بصورة' ;
    }
    //validate
    if (empty($Name)) {
        $formErrors[] = 'Name shoudnt be <strong>empty</strong>';
    }
    if (empty($price)) {
        $formErrors[] = 'price shoudnt be <strong>empty</strong>';
    }
        //chek if errors [arry] isnt found
    if (empty($formErrors)) {
        //insert qury
        $stmt = $con->prepare("insert into items (name,description,price,made_in,status,date,cat_id,member_id,img,rating) values (?,?,?,?,?,now(),?,?,?,0)");
        //exute
        $stmt->execute(array($Name,$desc,$price,$madeIN,$status,$postCT,getUserId (),$path));
        if ($stmt->rowCount() > 0) {
        	header('Location: profile.php');
        }
    }   
}  
?>
<div class="container">
	<div class="row add">
		<div class="profile-block col-bxs-12">
			<div class="panel panel-info" style="margin-top: 150px">
				<div class="panel-heading">اضافة اعلان</div>
				<div class="panel-body">
				    <div class="col-bxs-2">
						<div class="card-elm add-card" style="width: 100%; margin: 0">
							<img src="img/flat.png" width="100%" height="110">
							<div class="hpd">
								<p></p>
							</div>
							<div class="ppd">
								<p class="pp"><span class="price-show-primry"></span><span> SDG</span></p>
							</div>
						</div>				    	
				    </div>
				    <div class="col-bxs-10">
			            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="POST" enctype="multipart/form-data" >
			                <!-- start name input-->
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">اسم الاعلان</label>
			                    <div class="col-bxs-10 col-xs-12">
			                        <input type="text" name="name" class="form-control txt-inpt">
			                    </div>
			                </div>
			                <!-- end name input-->
			                <!-- start desc input-->
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">الوصف</label>
			                    <div class="col-bxs-10 col-xs-12">
			                        <input type="text" name="description" class="form-control">
			                    </div>
			                </div>
			                <!-- end desc input--> 
			                <!-- start price input-->
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">السعر (ج.س)</label>
			                    <div class="col-bxs-10 col-xs-12">
			                        <input type="number" name="price" class="form-control" id="num-input">
			                    </div>
			                </div>
			                <!-- end price input-->
			                <!-- start made in input-->
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">بلد المنشأ</label>
			                    <div class="col-bxs-10 col-xs-12">
			                        <input type="text" name="madeIN" class="form-control">
			                    </div>
			                </div>
			                <!-- end made in input-->
			                <!-- start status input-->
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">حالة العنصر</label>
			                    <div class="col-bxs-10 col-xs-12">
			                       <select class="form-control" name="status">
			                           <option value="new">جديد</option>
			                           <option value="like new">مستعمل</option>
			                           <option value="old">قديم</option>
			                       </select>
			                    </div>
			                </div>
			                <!-- end status input-->
			                <!-- start cats input-->
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">القسم</label>
			                    <div class="col-bxs-10 col-xs-12">
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
			                <!-- start img input --> 
			                <div class="form-group">
			                    <label class="col-xs-12 col-bxs-2 control-label ">ادخل الصورة</label>
			                    <div class="col-bxs-10 col-xs-12">
			                        <input type="file" name="file" class="form-control">
			                    </div>
			                </div>			                
			                <!-- end img input -->                                        
			                <!-- start submit input-->
			                <div class="form-group">
			                    <div class="col-bxs-12">
			                        <input type="submit" value="اضف اعلان"  class="btn btn-sm btn-success" style="float:left">
			                    </div>
			                </div>
			                <!--end submit input-->
			            </form>
		            </div>
		            <div class="clear-fix"></div>		            
		            <?php foreach ($formErrors as $error) {?>
		            <div class="col-sm-12">
		            	<div class="alert alert-danger"><?php echo $error; ?></div>
		            </div>
		            <?php } ?>				
				</div>
			</div>
		</div>			
	</div>
</div>
<?php 
include  $temp .'footer.php';
ob_end_flush();
?>