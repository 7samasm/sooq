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
