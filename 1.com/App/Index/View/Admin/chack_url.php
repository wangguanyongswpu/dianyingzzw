<?php
 
	 $url = $_GET['url'];
	 $url = "http://{$url}:9005/cdn_chack_url.txt";
	 $content =file_get_contents($url);
	 if ($content == "ISOK") {
	 	$msg['code'] = 1;
	 }else{
	 	$msg['code'] = 0;
	 }

	 die( $_GET['callback'] ."(" . json_encode($msg). ")" ) ;
	

?>