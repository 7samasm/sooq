<?php 

//Routs

$temp = 'include/templets/';
$css  = 'layout/css/';
$js   = 'layout/js/';
$lan = 'include/lang/';
$func = 'include/function/';

$pageNum = 10;
$num_page_count = 5;

//includes
 include          'db.php';
 include  $func . 'func.php';
 include  $func . 'class.php';
 include  $lan  . 'english.php';
 include  $temp . 'header.php';

//include navbar for all pages expect $nonavbar

!isset($nonavbar) ? include  $temp . 'navbar.php' : null;



 
