<?php
/**
* user class
*/
class user {
	//attrs
	public $id;
	public $name;
	public $password;
	public $fullname;
	public $email;
    //method 1*****************************************************************************************
	function setattr ($i,$na,$pass,$full='',$em = '') {
	  	$this->id       = $i;
	  	$this->name     = $na;
	  	$this->password = $pass;
	  	$this->fullname = $full;
	  	$this->email    = $em;
	}
	//method 2*********************************************************************************************
    function login ($postBtn,$groupID,$setSession,$idSession,$location) {
    	global $con;
	  	if (isset($_POST["$postBtn"])) {
			$stmt = $con->prepare("select 
				                        userID,username,password 
				                   from
				                        users 
				                   where
				                        username = ? 
				                   and 
				                        password = ?
				                   $groupID
				                   LIMIT 1         ");
			$stmt->execute(array($this->name,sha1($this->password)));
			$row   = $stmt->fetch();
			$count = $stmt->rowCount();
		    if ($count > 0 && $this->name == $row['username'] ) {
		    $_SESSION["$setSession"]          = $this->name;       //REGESTER Session Name
		    $_SESSION["$idSession"]           = $row['userID'];  //REGESTER Session ID
		    header($location);
		    exit();
		    }else{
		   	echo "<script>alert('ربما ادخل الاسم او كلمة السر بصورة خاطئة')</script>";
		    } 
	    }
    }
    //method 3********************************************************************************************
    function add ($postBtn,$repass) {
        global $con;
        global $formErrors;
        global $countinsert;
		//validate
		if (isset($_POST["$postBtn"])) {
		    $formErrors = array();
			if (strlen($this->name) < 4) {
				$formErrors[] = 'user shoudnt be less than <strong>4 character</strong>';
			}
			if (empty($this->name)) {
				$formErrors[] = 'user shoudnt be <strong>empty</strong>';
			}
			if (sha1($_POST["$repass"]) != sha1($this->password) || $this->password == '') {
				$formErrors [] = "كلمتي المرور غير متطابقتان او خاليتان";
			}			
			if (empty($this->email)) {
				$formErrors[] = 'email shoudnt be <strong>empty</strong>';
			}
			if (empty($this->fullname)) {
				$formErrors[] = 'fullname shoudnt be <strong>empty</strong>';
			}
			if (empty($this->password)) {
				$formErrors[] = 'password shoudnt be <strong>empty</strong>';
			}
		    //check user & email doesnt found
			$chun = CheckSelect ('username','users',$this->name);
			$che = CheckSelect  ('email','users',$this->email);
			if ($chun == 1)  {$formErrors[] = 'sorry username had existed';}
			if ($che  == 1)  {$formErrors[] = 'sorry Email had existed';}		
			//chek if errors [arry] isnt found
			if (empty($formErrors)) {
				//insert qury
				$stmt = $con->prepare("insert into users (username,password,email,fullname,reg,date) values (?,?,?,?,1,now())");
				//exute
				$stmt->execute(array($this->name,sha1($this->password),$this->email,$this->fullname));
				$countinsert = $stmt->rowCount();
			} 
		}	    	
    }
    //method 4********************************************************************************************
    function update () {
    	global $con;
    	global $formErrors;
		//password trick $_post
		$pass = (empty($this->password)) ? $_POST['oldpassword'] : sha1($this->password); 
		//validate
		$formErrors = array();
		if (strlen($this->name) < 4) {
			$formErrors[] = 'user shoudnt be less than <strong>4 char</strong>';
		}
		if (empty($this->name)) {
			$formErrors[] = 'user shoudnt be <strong>empty</strong>';
		}
		if (empty($this->email)) {
			$formErrors[] = 'email shoudnt be <strong>empty</strong>';
		}
		if (empty($this->fullname)) {
			$formErrors[] = 'fullname shoudnt be <strong>empty</strong>';
		}		
		//chek if errors [arry] isnt found
		if (empty($formErrors)) {
			//qury
			$stmt = $con->prepare("UPDATE `users` SET `username` = ?,email = ?,fullname=?,password=? WHERE `users`.`userID` = ?");
			//exute
			$stmt->execute(array($this->name,$this->email,$this->fullname,$pass,$this->id));
			$countupdate = $stmt->rowCount();
			// rename session name after edit
			$_SESSION['username']  = $_SESSION['ID'] == $_POST['id'] ? $this->name : $_SESSION['username'];
			// the massege and redirect
			$msg = '<div class="alert alert-success">'. $countupdate . ' row has updated</div>';										
			redirect($msg,'BACK',2);
		}
    }
    //method 5********************************************************************************************
    function mange () {
    	global $con;
    	global $start_from;
    	global $pageNum;
    	global $rows;
    	//check if mange page has get [&mange = pending] to execute [value or null]
		$qury         = isset($_GET['page']) && $_GET['page'] == 'pending' ? 'and reg  = 0': '';
		$aa           = isset($_GET['page']) && $_GET['page'] == 'aa' && $_SESSION['ID'] == 1     ? 'and reg  = 1': '';
		$toggleadmins = isset($_GET['page']) && $_GET['page'] == 'admins'  ? 'groupID  = 1': 'groupID != 1';
        // prepare , execute & fetchall
        $stmt = $con->prepare("select * from users where $toggleadmins $qury $aa order by userID desc limit $start_from,$pageNum ");
        $stmt-> execute();
        $rows = $stmt->fetchall();
    }
    //method 6********************************************************************************************
    function delete () {
    	global $con;
	    $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) :  0;
	    $dda    = $userid == 1 ? 0 : $userid;
	    $del    = CheckSelect('userID','users',$userid);
		if ($del > 0) {
	        $stmt = $con->prepare("delete from users where userID = :zuserID ");
	        $stmt->bindparam(':zuserID',$dda);
	        $stmt->execute();
	        $countdel = $stmt->rowCount();
	        $msg = '<div class="alert alert-success">'. $countdel . ' row has Deleted</div>';
	        echo '<div class ="container">';
	        redirect ($msg,'back');
	        echo '</div>';
        }    	
    }
    //method 6********************************************************************************************
    function active () {
    	global $con;
		$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) :  0;
	    $del = CheckSelect('userID','users',$userid);
		if ($del > 0) {
	        $stmt = $con->prepare("UPDATE `users` SET `reg` = 1 where userID = :zuserID");
	        $stmt->bindparam(':zuserID',$userid);
	        $stmt->execute();
	        $countdel = $stmt->rowCount();
	        $msg = '<div class="alert alert-success">'. $countdel . ' user has been active</div>';
	        echo '<div class ="container">';	        
	        redirect ($msg,'back');
	        echo '</div>';
        }    	
    }
    //method 7********************************************************************************************
    function setAdmin () {
    	global $con;
		$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) :  0;
	    $del = CheckSelect('userID','users',$userid);
		if ($del > 0) {
	        $stmt = $con->prepare("UPDATE `users` SET `groupID` = 1 where userID = :zuserID");
	        $stmt->bindparam(':zuserID',$userid);
	        $stmt->execute();
	        $countdel = $stmt->rowCount();
	        $msg = '<div class="alert alert-success">'. $countdel . ' admin has been added</div>';
	        echo '<div class ="container">';	        
	        redirect ($msg,'back');
	        echo '</div>';
        }    	
    }
    //method 8********************************************************************************************
    function removeAdmin () {
    	global $con;
		$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) :  0;
	    $del = CheckSelect('userID','users',$userid);
		if ($del > 0) {
	        $stmt = $con->prepare("UPDATE `users` SET `groupID` = 0 where userID = :zuserID");
	        $stmt->bindparam(':zuserID',$userid);
	        $stmt->execute();
	        $countdel = $stmt->rowCount();
	        $msg = '<div class="alert alert-success">'. $countdel . ' admin has been Removed</div>';
	        echo '<div class ="container">';	        
	        redirect ($msg,'back');
	        echo '</div>';
        }  	
    }              
}
/*===================================================================
** class cat
** by Hussam  abdAallah
=====================================================================*/
class cat {
	//attrs
	public $ID;
	public $Name;
	public $description;
	public $order;
	public $visibility;
	public $allow_comnt;
	public $allow_ads;
    //method 1*****************************************************************************************
	function setattr ($ID,$Name,$description,$order,$visibility,$allow_comnt,$allow_ads) {
	  	$this->ID          = $ID;
	  	$this->Name        = $Name;
	  	$this->description = $description;
	  	$this->order       = $order;
	  	$this->visibility  = $visibility;
	  	$this->allow_comnt = $allow_comnt;
	  	$this->allow_ads   = $allow_ads;
	}
	//method 2*********************************************************************************************
    function add () {
    	global $con;
        //check name doesnt found
        $chn = CheckSelect ('Name','cats',$this->Name);
        if ($chn == 1)  {
            $msg = "<div class='alert alert-danger'>sorry Category name had existed</div>";
            redirect($msg,'BACK',2);
        }
        else {
            //insert qury
            $stmt = $con->prepare("INSERT INTO `cats` (`Name`, `desc`, `order`, `visibility`, `allow_cmnt`, `allow_ads`) values (:zname,:zdesc,:zorder,:zvis,:zcmnt,:zads)");
            //exute
            $stmt->execute(array(
                'zname'  => $this->Name,
                'zdesc'  => $this->description,
                'zorder' => $this->order,
                'zvis'   => $this->visibility,
                'zcmnt'  => $this->allow_comnt,
                'zads'   => $this->allow_ads
                ));
            $countupdate = $stmt->rowCount();
            $msg = '<div class="alert alert-success">'. $countupdate . ' Category has added</div>';
            redirect($msg,'BACK',10);
        }
    }
	//method 3*********************************************************************************************
    function update () {
    	global $con;
	    //qury
	    $stmt = $con->prepare("UPDATE `cats` SET `Name`= ?,`desc`= ?,`order`=?,`visibility`=?,`allow_cmnt`=?,`allow_ads`=? WHERE `cats`.`ID` = ?");
	    //exute
	    $stmt->execute(array($this->Name,$this->description,$this->order,$this->visibility,$this->allow_comnt,$this->allow_ads,$this->ID));
	    $countupdate = $stmt->rowCount();
	    $msg = '<div class="alert alert-success">'. $countupdate . ' Category has been updated</div>';
	    redirect($msg,'BACK',2); 
    }
}