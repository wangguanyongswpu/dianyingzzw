<?php
namespace Index\Controller;
use Think\Controller;
/*
  后台后台统一在admin控制器下面
 */
class JsController extends ComController {
	
	 public function index(){
			$uid    =  I('get.uid');
			$domain =  $this->GetDomain(2,1);
			$_uid   =  $uid;
			$uid    =  base64_encode($uid);
			$url    =  'http://'.$domain."/?d={$uid}&from=Js";
			if(I('get.pic')){
			   $pic    =  I('get.pic');		
			}else{
			   $pic    =  "http://js.cywl5.com/640200/".rand(1,100) .".gif";				 
			}
            $data   =  'document.writeln("<div id=\"guoguo\" style=\"padding-top:2px;padding-bottom:2px;margin-top:0px;margin-bottom:0px;margin-left:auto;margin-eight:auto;width:100%\"><a href=\"'.$url.'\" target=\"_blank\"><img id=\"image111\" style=\"width: 100%; bottom: 0px; left: 0px; z-index: 12147483647;\" src=\"'.$pic.'\"></a></div>");';
            echo $data;
	 }

     
     public function domain(){
			$uid    =  I('get.uid');
			$domain =  $this->GetDomain(2,1);
			header ( 'Content-type: application/x-javascript');
			$uid    =  base64_encode($uid);
			$url    =  'http://'.$domain."/?d={$uid}";
			if(I('get.name')){
				$name   = I('get.name');
				$data   = "var {$name} = '{$url}';"; 
			}else{
				$data   = "var HkDomain = '{$url}';";
			}
			die($data);
     }

}

?>