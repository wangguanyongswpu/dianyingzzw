<?php

$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
 
$is_android = (strpos($agent, 'android')) ? true : false; 

if($is_android){
	 require 'index.html';
}else{
	require '404.html'; 
}

?>