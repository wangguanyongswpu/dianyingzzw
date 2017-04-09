<?php
namespace Index\Controller;
use Think\Controller;
class PayController extends ComController {
    
     public function link(){
       $this->index();
     }
 
    public function index(){
	     $data      = I('get.');
         if (empty($_user)) {
            $data['openid'] =  time().rand(10000,999999);
         }
         $OrderInfo = [
              'gid'    => (int)$data['gid'],
              'orderid'=> "v".time().rand(10000,999999),
              'openid' => $data['openid'],
              'money'  => 48,
              's_time' => time(),
              'status' => 0,
              'info'   => "电影Vip充值"
         ];
         $oid = M('order')->add($OrderInfo);
         $this->push_weixin($oid);
         $this->data['uid']   =  1;
         $this->data['refid'] = I('get.refid');
         $this->data['timestamp'] = time();
         $sign=$this->get_pay_sign();
         $url = C("PAY_API_URL");
         if( I('get.cv') ){
           $payname =  "PAY_API_URL" .  I('get.cv'); 
           $url = C($payname) ? C($payname) : $url;           
         }         
      
//         $url = 'http://hudo.hbtongshengjc.com/PayApi/index';
		 $refid = (int) I('get.refid');
         $call_url = U("/index/pay/pay_callback",'','',true);  //支付完成回调地址
         $url.="?refid=".$refid."&uid=1&timestamp=".$this->data['timestamp']."&sign=".$sign;
         $url.="&openid=".$data['openid']."&call_url=".$call_url ."&money=".$data['money']."&orderid=".$OrderInfo['orderid'];
         // time 访客开始访问时间  utype 推广渠道  uiver 版本
         $url.="&time={$data['time']}&utype={$data['utype']}&uiver={$data['uiver']}";
         
         $this->push_orderInfo($data['openid'],$url);
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
        $sign = md5($app_id . '+' . $this->data['uid'] . '+' . $this->data['refid'] . '+' . $this->data['timestamp'] . '+' . $app_key);//签名规则
        return $sign;
    }
     
    
     //回调方法 pay/callback
     public function pay_callback(){
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
        $order_id = I("get.orderid");
        $order = M('order')->where(array("orderid"=>$order_id))->find();
 
            $url = C("DIANYING_YSE_VIP_URL");
            $key = array_rand($url);   //获取 url
            $url = $url[$key];
            $url.= "?openid=".$open_id."&uid=".$uid."&gid=".$this->GID;
            header("Location:".$url);
 
     }

    public function payurl(){
         $data      = I('get.');

         $data['openid'] =  time().rand(10000,999999);
         $this->data['uid']   =  I('get.uid');
         $this->data['refid'] = I('get.refid');
         $this->data['timestamp'] = time();
         $sign=$this->get_pay_sign();
         $url = C("PAY_API_URL");
         $payP = parse_url($url);
         
//         $url = 'http://hudo.hbtongshengjc.com/PayApi/index';
         $refid = (int) I('get.refid');
         $rhost = I('get.rhost');
         if(!empty($rhost)){
            $call_url = "http://{$rhost}/index/pay/pay_callback";
         }else{
            $call_url = U("/index/pay/pay_callback",'','',true);  //支付完成回调地址
         }
         
         $url.="?refid=".$refid."&uid=1&timestamp=".$this->data['timestamp']."&sign=".$sign;
         $url.="&call_url=".$call_url ."&money=".$data['money'];
         // time 访客开始访问时间  utype 推广渠道  uiver 版本
         $url.="&time={$data['time']}&utype={$data['utype']}&uiver={$data['uiver']}";
         

         echo json_encode(array('status'=>0,'url'=>$url,'domain'=>$payP['host']));
    }
}
