<?php
ob_start();  
session_start();
$pagetitle = "";
if (isset($_SESSION['username'])) {
	include 'config.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'mange';
    //start mange page ****************************************************************************************
	if ($do == 'mange') {?>
		
 <?php 
    }
    //start add page ******************************************************************************************
	elseif ($do == 'add') { ?>
			
<?php
    } 
    //start insert page****************************************************************************************
	elseif ($do == 'insert') {
		
	}
    //start edit page*****************************************************************************************
	elseif ($do == 'edit') { 
		
    } 
    // start update page **************************************************************************************
    elseif ($do == 'update') {
			
    }
    // start delete page ************************************************************************************ 
    elseif ($do == 'Delete') {
		    
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