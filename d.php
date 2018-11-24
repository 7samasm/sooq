<?php


$str = "/controller/action/param1/param2";
$str = trim($str,'/');
$explode = explode("/", trim($str,'/'),3);
$arr = [
		   $explode[0],
		   $explode[1],
		   explode('/', $explode[2])
	   ];
var_dump($arr);

$arrayName = array(
			 'id'     => 2, 
			 'name'   => 2,
			 'age'    => 2,
			 'adress' => 2,
			 'salary' => 2,
			 'tax'    => 2,
			 'mobile' => 2,
			 'ms'     => 2
	                       );
function buildParam()
{
	global $arrayName;
	$param = '';
	foreach ($arrayName as $key => $value) 
	{
		$param = $param . $key . ":" . $key . ' , ';
	}
	return rtrim($param,' , ');
}

echo buildParam();