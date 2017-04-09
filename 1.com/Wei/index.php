<?php
require_once "jssdk.php";

$WeiXin = array(
      //桃源居客     
     1 =>array(
          'appid' => 'wxfb79cfa95cfee30c',
		  "apps" => "7b85d1145bb4e777b42f0406da73f658",
	   ),
	 //独享影音
	 2 => array(
	       'appid' =>"wx1abbffb3da8778bf",
		   'apps'  =>'240850a6cf146d39db3f71af9986d0e5',
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
