<?php
require_once "jssdk.php";

$WeiXin = array(
      //影音浪派    
     1 =>array(
     	    'appid' => 'wxb9476c40ccfde4c8',
			 "apps" => "f857c7f19ecd183ddb94d3994ab94207",
	   ),
	 //游走旧时光   
	 2 => array(
	         'appid' => 'wxe2495813e43ccb39',
			 "apps" => "808ce1c2d81417cafa6c674bc11f1a4a",
	 ),
	 
 );
$url   = trim($_GET['url']);
$c     = $_GET['c'];
$appid = $WeiXin[$c]['appid'];
$apps = $WeiXin[$c]['apps'];
$jssdk = new JSSDK($appid, $apps,$url,$c);
$signPackage = $jssdk->GetSignPackage();
die($_GET['callback']."(".json_encode($signPackage) . ");");
?>
