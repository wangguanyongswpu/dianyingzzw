<?php
namespace Index\Controller;
use Think\Controller;

class IndexController extends ComController {
      
     public function test(){
         $url = "http://www.lotteyw.com/index/index/test2/";
         //redirect( $url); 
      }
     
    
  public function test2(){
        $this->display();
        redirect("http://m.sohu.com/?_trans_=000115_3w&jump=front");
  }
  
  
	  public function IsWeiXin(){
        //import("Lib/fanlanjie");
        //$fanlanjie = new \fanlanjie();
        //$fanlanjie->init();
	  	if($this->IsWeiXinApp() == false){
	  	    redirect("http://www.baidu.com");
	  	 }
	  }

      
	  public function IsLeiLu(){
	  	 if(empty($_SERVER["HTTP_REFERER"])){
			   // redirect("http://m.sohu.com/?_trans_=000115_3w&jump=front");
		   } 
	  }

		
      /**
	   *  分享页面
	   *  [第1层]
	   *  1.haooda.com/index/index/share/?uid=32323 
	   */
	  public function share(){
            $this->IsWeiXin();
            $uid    =  I('get.uid');
            $domain =  $this->GetDomain(2,1);
            $_uid   =  $uid;
            $uid    =  base64_encode($uid);
            $url    = 'http://'.$domain."/?d={$uid}";
            if(I('get.cv')){
              $url = $url . "&cv=".I('get.cv');
            }
            if($_GET['from'] == 'timeline'){
              $url .= "&from=pyq";
            }else{
              $url .= "&from=wxq";
            } 
 
            $url .= "&t=". time();
            $str  =  GetRandStr(5);
            $str2  =  GetRandStr(8);
            $data['url'] = "http://imp.pftools.focus.cn/{$str}/{$str2}?redirect=". $url;
         $data['url'] =   $url;
            $this->assign($data);
            $this->display('t');
           // header("Location:".$url); 
	  }
	 
 
  /**
	   *   跳转入口
	   *   [第2层]
	   *   1.haooda.com/?d=32323
	   *    "http://" + rhost + "/?d=" + window.btoa(refid) + "&do=check.html" 
	   *    from = js  微信群  朋友圈 
	   */
	   public function index(){
           //import("Lib/fanlanjie");
           //$fanlanjie = new \fanlanjie();
           //$fanlanjie->init2();
           $this->IsWeiXin();
           if(I('get.from') !== 'img'){
             $this->IsLeiLu();						
           }
           //$url = $this->GetDomain(3,1);
           $where  = array(
             'type'=>1,
             'layer'=>3
           );
           $domain = M('domain')->where($where)->order("id asc")->limit("2")->select();
           $key  = array_rand($domain);
           $url  = $domain[$key]['url'];
           $url = $url2 = trim($url);
           $randstr = GetRandStr(6);
           $uid = I('get.uid');
           //$uid = base64_decode($uid);
           //$num1 = GetRandNum(6);
           //$num2 = GetRandNum(8);
          //$num3 =  GetRandNum(4); 
            
           /*if(I('get.cv')){

              $url = "http://".$url."/{$num1}/{$num2}/{$num3}/daog.html";
         
            }else{
             $url = "http://".$url."/".time()."/index.html";
           }*/
           
           $open_id =  time().rand(10000,999999);
           //判断客户端
           if ($_GET['from']) {
             $utype = $_GET['from'];
           }else{
             $utype = 'null';
           }
           $host = explode(":", $_SERVER['HTTP_HOST']);
           $where  = array( 'type'=>1, 'layer'=>2 );    
           $domain2 = M('domain')->where($where)->order( "rand()" )->find();
           $host['0']  = $domain2['url'];
           //$url.= "?rid={$uid}&phost=".$host['0'];
         	$host_r=$this->urlsafe_b64encode($host['0']);
          	$url = "http://".$url."/ud/{$uid}/rh/{$host_r}.html";
           header("Location:".$url);die;
	  }
	  
	  function urlsafe_b64encode($string) {
         $data = base64_encode($string);
         $data = str_replace(array('+','/','='),array('-','_',''),$data);
         return $data;
      }
	  
}