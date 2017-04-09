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
          redirect("http://m.sohu.com/?_trans_=000115_3w&jump=front");
       }
    }

      
    public function IsLeiLu(){
       if(empty($_SERVER["HTTP_REFERER"])){
         // redirect("http://m.sohu.com/?_trans_=000115_3w&jump=front");
       } 
    }
       
      public function paylink(){
            $domain =  $this->GetDomain(2,1);
            echo "window.paylink = '{$domain}';";
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
              $url = $url . "&cv=".I('get.cv')."&mtype=".I('get.mtype');
            }
            if($_GET['from'] == 'timeline'){
              $url .= "&from=pyq";
            }else{
              $url .= "&from=wxq";
            } 
            $url .= "&t=". time();
            $data['url'] = "http://imp.pftools.focus.cn/wwhhhcom?redirect=". $url;
            $data['url'] =  $url;
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
          $this->IsWeiXin();
           if(I('get.from') !== 'img'){
             $this->IsLeiLu();            
           }
           $url = $this->GetDomain(3,1);
           $where  = array(
             'type'=>1,
             'layer'=>3
           );
           $domain = M('domain')->where($where)->order("id asc")->limit("2")->select();
           $key  = array_rand($domain);
           $url  = $domain[$key]['url'];
           $url = $url2 = trim($url);
           $randstr = GetRandStr(6);
           $uid = I('get.d');
           $uid = base64_decode($uid);
           $num1 = GetRandNum(6);
           $num2 = $this->getRandChar(8);
           $num3 =  GetRandNum(4); 
           if(I('get.cv')){
              $num1  =  I('get.cv');
              $url   =  "http://".$url."/{$num1}/{$num2}/daog.html";
            }else{
              $num1  =  1;
              $url   =  "http://".$url."/{$num1}/{$num2}/daog.html";
           }
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
           $url.= "?refid={$uid}&gid=1&utype=".$utype."&rhost=".$host['0'];
           if(I('get.cv')){
              $url = $url . "&cv=".I('get.cv');
            }
            //判断是否为二维码支付
            $pay = M('site')->where(array('name'=>'PAY_API_URL'.I('get.cv')))->find();
           if (strpos($pay['valus'], 'wechatqr')===false) {
              $payewm = 0;
           }else{
              $payewm = 1;
              $url = $url . "&payhost=" . $pay['valus'];
           }
           $url = $url . "&payewm=".$payewm."&mtype=".I('get.mtype');
           header("Location:".$url);die;
    }
  

     public function getRandChar($length){
         $str = null;
         $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
         $max = strlen($strPol)-1;

         for($i=0;$i<$length;$i++){
          $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
         }
         return $str;
      }
  
  
  
  
  
}
