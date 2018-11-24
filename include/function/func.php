	<?php 
	/*
	** get title function
	** verission 1.0 
	*/
	function gettitle() {
			global $pagetitle;
			echo  isset($pagetitle) ? $pagetitle: "defult"; 
	}
	/*
	** getcat
	** verission 3.0 
	*/

	function getcats ( $order = 'asc',$lmtpar1 = 0,$lmtpar2 = 5) {
		     global $con;
		     $stmt = $con->prepare("select * from cats order by `order` $order limit $lmtpar1,$lmtpar2 ");
		     $stmt->execute();
		     return $stmt->fetchAll();
	} 
	/*
	** getitems
	** verission 5.0 
	*/

	function getitems ($where , $sign ,$value) {
		     //vars
		     global $con;
		     global $page;
		     global $pageNum;
		     //start_from
			 $start_from = ($page-1) * $pageNum;
			 //order
		     $order = isset($_GET['order']) && in_array($_GET['order'], array('asc','desc')) ? 'price '. $_GET['order'] : 'itemID desc';
		     // stmt & excute 
		     $stmt = $con->prepare("select * from items where $where $sign ? order by $order limit $start_from,$pageNum ");
		     $stmt->execute(array($value));
		     return $stmt->fetchAll();
	}
		/*
	** getitemsRow 
	** verission 1.0 
	*/

	function getitemsRow ($where , $sign ,$value,$order = '') {
		     //vars
		     global $con;
		     // stmt & excute 
		     $stmt = $con->prepare("select * from items where $where $sign ? $order limit 7");
		     $stmt->execute(array($value));
		     return $stmt->fetchAll();
	} 
	/*
	** getUser
	** verission 1.0 
	*/

	function getUser ($where,$value) {
		     global $con;
		     $stmt = $con->prepare("select * from users where $where = ?");
		     $stmt->execute(array($value));
		     return $stmt->fetchAll();
	}
	/*
	** getUserID
	** verission 1.0 
	*/

	function getUserId () {
		     global $con;
		     $stmt = $con->prepare("select * from users where username = ?");
		     $stmt->execute(array($_SESSION['user']));
		     $row = $stmt->fetch();
		     return $row['userID'];
	}		
	/*
	** redirect function
	** verission 2.0 
	*/

	function redirect ($msg,$url=null,$sec = 3) {
			if ($url == null) {
				$url  = 'index.php';
				$page = 'Home page'; 
			} else {
				$url = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : 'index.php' ;
				$page = 'Previous page';
			}
			echo '<h1 style="height: 40px;"></h1>';
			echo $msg;
			echo "<div class='alert alert-info'>this page will redirect to $page after $sec seconds</div>";
			header("refresh:$sec; url = $url");
			exit();
	}

	/*
	** check username,email...ets function
	** verission 1.0 
	*/

	function CheckSelect ($select,$from,$value) {
			global $con;
			$st = $con->prepare("select $select from $from where $select = ?");
			$st->execute(array($value));
			$cont = $st->rowCount();
			return $cont;
	}

	/*
	** TotalCount
	** verission 2.0 
	*/ 

	function TotalCount ($item,$table,$sign,$value) {
		     global $con;
		     $st2 = $con->prepare("select count($item) from $table where $item $sign ? ");
		     $st2->execute(array($value));
		     return $st2->fetchColumn();
	}

    /*
	** getlatest
	** verission 1.0 
	*/

	function getlatest ($select,$table,$order,$DESCorASC,$limit=4) {
		     global $con;
		     $stmt = $con->prepare("select $select from $table order by $order $DESCorASC limit $limit");
		     $stmt->execute();
		     return $stmt->fetchAll();
	}

	/*
	** silnce number
	** virssion 1.0
	*/
	/*
	** getitems
	** verission 5.0 
	*/

	function getAjaxitems ($where , $sign ,$order,$value) {
		     //vars
		     global $con;
		     global $page;
		     global $pageNum;
		     //start_from
			 $start_from = ($page-1) * $pageNum;
		     // stmt & excute 
		     $stmt = $con->prepare("select * from items where $where $sign ?  $order limit $start_from,$pageNum ");
		     $stmt->execute(array($value));
		     return $stmt->fetchAll();
	}

