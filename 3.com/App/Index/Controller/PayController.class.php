<?php
namespace Index\Controller;
use Think\Controller;
class PayController extends ComController {
    
    public function link(){

        $this->index();
    }

  public function pay_set()
    {
    		echo '3层1';exit;
    }
    public function index(){
	     $data      = I('get.');
         if (empty($_user)) {
            $data['openid'] =  time().rand(10000,999999);
         }
 
         $OrderInfo = [
              'gid'    => 1,
              'orderid'=> "ln".time().rand(10000,999999),
              'openid' => 'ln1111',
              'money'  => $data['money'],
              's_time' => time(),
              'status' => 0,
              'info'   => "电影Vip充值"
         ];
         $oid = M('order')->add($OrderInfo);
         $this->push_weixin($oid);
         $this->data['uid'] = I('get.uid');
         $this->data['timestamp'] = time();
         $sign=$this->get_pay_sign();
         $url = C("PAY_API_URL");
//         $url = 'http://hudo.hbtongshengjc.com/PayApi/index';
		 $refid = (int) I('get.uid');
         $where  = array( 'type'=>1, 'layer'=>2 );    
         $domain2 = M('domain')->where($where)->order( "rand()" )->find();
      
         $call_url = "http://". $domain2['url'] . ":9005/index/pay/pay_callback";  //支付完成回调地址
         
         $url.="?uid=".$refid."&timestamp=".$this->data['timestamp']."&sign=".$sign;
         $url.="&call_url=".$call_url ."&money=".$data['money']."&orderid=".$OrderInfo['orderid'];
         
         $this->push_orderInfo('ln1111',$url);
         header("Location:".$url);
    }


    //微信接口推送
    private function push_weixin($oid){
        $order = M('order')->where(array("id"=>$oid))->find();
        //var_dump($order);
        //die();
    }



    private function get_pay_sign(){
        $app_id  = C("PAY_API_URL_APP_ID");
        $app_key = C("PAY_API_URL_APP_KEY");
        $sign = md5($app_id . '+' . $this->data['uid']  . '+' . $this->data['timestamp'] . '+' . $app_key);//签名规则
        return $sign;
    }
     
    
     //回调方法 pay/callback
     public function pay_callback(){
        $where  = array( 'type'=>1, 'layer'=>3 );
        $domain = M('domain')->where($where)->order( "rand()" )->find();
        $url  = $domain['url'];
        $url = $url2 = trim($url);
        $url = "http://{$url}:9007/Index/Index/dapp";
        header("Location:".$url);
        die;
        if (I('get.type') == 'jscall') {
            $this->jscall();
            die();
        }
        $data = I('get.');
        $_key = I('get.key');
        $key = C("PAY_API_CALL_KEY");
        if ($key !== $_key) {
            die("404");
        }
        $_data = array(
            'e_time'=>time(),
            'status'=>1,
          );
        $where = array("orderid"=>$data['orderid'],'status'=>0);
        $orderinfo = M("order")->where($where)->find();
        if (!$orderinfo) {
           die("300"); //已处理不在处理
         } 
        if( M("order")->where(array("orderid"=>$data['orderid'],'status'=>0))->save($_data) !== false){
            $orderinfo = M("order")->where(array("orderid"=>$data['orderid'],'status'=>1))->find();
            $_u = array(
                'vip'=>1,
                "vip_time"=> time()
              );
            if( M("user")->where(array("openid"=>$orderinfo['openid']))->save($_u) !== false){
                $user = M("user")->where(array("openid"=>$orderinfo['openid']))->find();
                $_user_data = array(
                    'id'                 => $user['id'],
                    'uid'                => $user['uid'],
                    'user_name'            => $user['user_name'],
                    'openid'              => $orderinfo['openid'],
                    'pay_serial'          => $data['orderid'],
                    'pay_channel'        => 1,
                    'pay_amount'         => $orderinfo['money'],
                    'pay_type'           => 1,
                    'pay_time'           => $orderinfo['e_time'],
                    'timestamp'          => time(),
                  );
                if( $this->cps_add_pay($_user_data) ){
                    die("200");
                }else{
                    die("400");
                }
            } 
        }else{
           die("400");
        }
     }


     private function jscall()
     {  
        $where  = array( 'type'=>1, 'layer'=>3 );
        $domain = M('domain')->where($where)->order( "rand()" )->find();
        $url  = $domain['url'];
        $url = $url2 = trim($url);
        $url = "http://{$url}:9007/appdown/index.html";
        header("Location:".$url);
        die;
        if(I('uiver') !== 'xie_2016_19' ){
            $this->app_call();
        }else{
            $url = C("DIANYING_YSE_VIP_URL");
            $key = array_rand($url);   //获取 url
            $url = $url[$key];
            $url.= "?openid=".$open_id."&uid=".$uid."&gid=".$this->GID;
            header("Location:".$url);    
        }
     }



    public function app_call(){
        $money = I('get.money');
        $uid   = I('get.refid');
        $ext   = I('get.ext');
        $where  = array( 'type'=>1, 'layer'=>3 );
        $domain = M('domain')->where($where)->order( "rand()" )->find();
        $url  = $domain['url'];
        $randstr = GetRandStr(6);
        $url = "http://".$url."/APP/".$randstr."/daog.html";
        $url.= "?refid={$uid}&rhost=".$_SERVER['HTTP_HOST']. "&money={$money}&ext={$ext}"."&utype=paycall";
        header("Location:".$url);
    }  



}
