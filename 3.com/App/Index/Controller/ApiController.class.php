<?php
namespace Index\Controller;
use Think\Controller;
class ApiController extends ComController {
  
  
  //获取第一层域名    
	public function GetDomain(){
		 if(I('get.code') !== "18361130555"){
		 	 die("400");
		 }
		 $data['domain'] = M("domain")->field("url")->where(array("type"=>1,'layer'=>1))->select();
		 foreach($data['domain'] as $key=>$v){
		 	 $domain[] = $v['url'];
		 }
		 die(json_encode($domain));
	}

    //获取各层域名
    public function GetDomain2(){
        if(I('get.code') !== "18361130555"){
            die("400");
        }

        $layer = intval(I('get.layer'));
        if(!$layer) $layer=1;
        $filter = array("type"=>1,'layer'=>$layer);

        $data['domain'] = M("domain")->field("url")->where($filter)->select();
        foreach($data['domain'] as $key=>$v){
            $domain[] = trim($v['url']);
        }
        die(json_encode($domain));
    }
	
	
	//获取js推广域名
	public function GetJsDomain(){
		  $data['domain'] = M("domain")->field("url")->where(array("type"=>1,'layer'=>1))->select();
		  
	}
	
	//获取图片广告
	public function GetAdImg(){
		$uid = base64_encode(I('get.uid'));
		$url = M("domain")->field("url")->where(array("type"=>1,'layer'=>2))->find();
		$Url = "http://". $url['url'] . "/?from=img&d=".$uid; 
		echo $Url;	  
	    
	}	 

   	public function wx(){
	 $domain = M("domain")->field("url")->where(array("type"=>1,'layer'=>1))->order("rand()")->find();
		$domain = $domain['url'];
		header('Content-Type: application/x-javascript; charset=UTF-8');
		$data = file_get_contents(FCPATH ."/fx/wx.js");
		$time = C("FANGWEN_TIME");
		$data=str_replace("<{url}>", $domain,$data);
		die($data);
	} 

	 public function wx2(){
	 $domain = M("domain")->field("url")->where(array("type"=>1,'layer'=>1))->order("rand()")->find();
		$domain = $domain['url'];
		header('Content-Type: application/x-javascript; charset=UTF-8');
		$data = file_get_contents(FCPATH ."/fx2/wx.js");
		$time = C("FANGWEN_TIME");
		$data=str_replace("<{url}>", $domain,$data);
		die($data);
	} 
   
   public function wx3(){
	 $domain = M("domain")->field("url")->where(array("type"=>1,'layer'=>1))->order("rand()")->find();
		$domain = $domain['url'];
		header('Content-Type: application/x-javascript; charset=UTF-8');
		$data = file_get_contents(FCPATH ."/fx3/wx.js");
		$time = C("FANGWEN_TIME");
		$data=str_replace("<{url}>", $domain,$data);
		die($data);
	} 

}
