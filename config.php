<?php

include 'admin/db.php';

//Routs

$temp = 'include/templets/';
$css  = 'layout/css/';
$js   = 'layout/js/';
$lan = 'include/lang/';
$func = 'include/function/';

$userSession = isset($_SESSION['user']) ? $_SESSION['user'] : '';
/*
** pagination settings
** $page = get page or 1
** $pageNum = number of results
** $num_page_count = number of page numbers block exp 2 left 2 right
*/
$page = isset($_GET["page"]) ? $_GET["page"] : 1 ;
$pageNum = 14;
$num_page_count = 2;

//includes
 include  $func . 'func.php';
 include  $lan  . 'english.php';
 !isset($noNav) ? include  $temp . 'header2.php' : null;

 /*$str = "/employee/defualt/desc/1";
 List($a,$b,$c) = explode("/", trim($str,"/"),3);
 $c = explode("/",$c);
 var_dump($a,$b,$c);*/

