<?php
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$is_android = (strpos($agent, 'android')) ? true : false;
$is_weixin  = (strpos($agent, 'micromessenger')) ? true :false;
if($is_android ){
	$r   = rand(1000,9999999);
	//echo '<script language="javascript">window.location.href="http://gd.cz150.com/app/gd347-'.$r.'.apk";</script>';
$filename = 'gd347-taj1kz.apk'; 
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="xxxx.apk"'); 
readfile("$filename"); 
exit(); 

}else{
	header('HTTP/1.1 403 Forbidden');  
	require '404.html'; 
}








?>

