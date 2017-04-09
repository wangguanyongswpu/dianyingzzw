<?php
namespace Index\Controller;
use Think\Controller;
use EasyWeChat\Message\News;
use EasyWeChat\Foundation\Application;

class ComController extends Controller {
      
    public $WEIXIN_USER_LIST;
    public $GID;

    public function  _initialize(){
        if(I('get.gid')){
            $this->GID = $gid = I("get.gid") ? I("get.gid") : 0 ;
            $weixin = M("weixin")->where(array('k'=>$gid))->find();
        }else{
            $weixin = M("weixin")->order('rand()')->find();
            $this->GID = $weixin['k'];
        }
        $weixin = json_decode($weixin['info'],true);
        $this->WEIXIN_USER_LIST = $weixin;
        $site = M('site')->select();
        foreach ($site as $key => $v) {
            C($v['name'],$v['valus']);
        }
        //配置未充值跳转url
        $DIANYING_NO_VIP_URL = M('domain')->where(array('type'=>1,'layer'=>3))->select();
        $URL = [];
        foreach ($DIANYING_NO_VIP_URL as $k => $v) {
            $URL[] = "http://".$v['url']."";
        }
        C("DIANYING_NO_VIP_URL",$URL);
    }

   //获取当前域名
   public function GetDomain($layer,$type){
   	    $where  = array(
	   	            'type'=>$type,
	   	            'layer'=>$layer
				         );
        $domain = M('domain')->where($where)->order("id asc")->find();
		    $domain = $domain['url'];
        return $domain;
   }    
	

   public function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
  }

  
   protected function https_request($url, $data = null)
     {
         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
             curl_setopt($curl, CURLOPT_POST, 1);
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         }
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         $output = curl_exec($curl);
         curl_close($curl);
         return $output;
     }




  
  private function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
  }

  private function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
  }
  


  public function GetWeixinToken($appId, $appSecret) {
    $data = json_decode($this->get_php_file($appId."_access_token.php"));
    if ($data->expire_time < time()) {
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $this->set_php_file($appId."_access_token.php", json_encode($data));
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

   

   public function cps_add_user($data){
      $url = C("CPS_API_URL")."index.php?m=Qwadmin&c=api&a=register";
      $_data['app_id']     = C("PAY_API_URL_APP_ID");
      $_data['uid']        = $data['id'];
      $_data['refid']      = $data['uid'];
      $_data['username']   = $data['user_name'];
      $_data['sex']        = $data['sex'];
      $_data['timestamp']  = time();
      $_data['openid']     = $data['openid'];
      $_data['gid']        = $data['gid'];
      $_data['sign']       = $this->get_cps_sign($_data);
      $_data['reg_ip']     = get_iplong();
      foreach ($_data as $k => $v) {
         $url .= "&".$k."=".$v;
       }
      WeixinLog($url);
      $code =  $this->httpGet($url);
      WeixinLog($code);
   }
   
  
   public function cps_add_pay($data){
      $url = C("CPS_API_URL")."index.php?m=Qwadmin&c=api&a=pay";
      $_data['app_id']     = C("PAY_API_URL_APP_ID");
      $_data['uid']        = $data['id'];
      $_data['refid']      = $data['uid'];
      $_data['username']   = $data['user_name'];
      $_data['sex']        = $data['sex'];
      $_data['timestamp']  = time();
      $_data['openid']     = $data['openid'];
      $_data['gid']        = $data['gid'];
      $_data['sign']       = $this->get_cps_sign($_data);
      $_data['reg_ip']     = get_iplong();
      $_data['pay_serial'] = $data['pay_serial'];
      $_data['pay_channel'] = 1;
      $_data['pay_amount'] = $data['pay_amount'];
      $_data['pay_type']           = 1;
      $_data['pay_time']   =$data['pay_time'];
      foreach ($_data as $k => $v) {
           $url.="&".$k."=".$v;
      }
      $code = $this->httpGet($url);
      $call = json_decode($code,true);
      if ($call['ret'] == '00') {
        return true;
      }else{
        return false;
      }
   }


   //生成sign
   private function get_cps_sign($_data){
      $app_id  = C("PAY_API_URL_APP_ID");
      $app_key = C("PAY_API_URL_APP_KEY");
      $sign = md5( $app_id  . '+' . $_data['uid'] . '+' . $_data['refid'] . '+' . $_data['timestamp'] . '+' . $app_key );
      return $sign;
   }

 
    private function p($code){
       echo "<pre>";
       print_r($code);
       echo "</pre>";
    }
   
    

 
   
   /*
     *  time  2016/7/25 23:15
     *  $openid str
     *  重新写的关注推送方案
    */
   protected function push_subscribe_info($openid){
        $url = $this->WEIXIN_USER_LIST['url'];
        $data = [
            "touser" =>$openid,
            'title'       => "蜜桃欢迎您",
            'description' => '',
            'url'         => "http://".$url."?gid=".$this->GID,
            'picurl'       => "http://".$url."/void/play_files/images/1456042049751A.jpg",
        ];
        $code = $this->push_imgInfo($data);
        return $code;
   }
   

    /*
     * 发送图文信息
     */
   protected function push_imgInfo($data){
        $json = '{"touser":"'.$data["touser"].'","msgtype":"news","news":{"articles": [ { "title":"'.$data["title"].'","description":"'.$data["description"].'","url":"'.$data['url'].'","picurl":"'.$data["picurl"].'"}]}}';
        $weixin = $this->WEIXIN_USER_LIST;
        $Token  = $this->GetWeixinToken($weixin['app_id'],$weixin['secret']);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$Token;
        $user   = $this->https_request($url,$json); 
        return json_decode($user,true);
     }

   
   //发送订单信息
   protected function push_orderInfo($openid,$url){
        //$openid ='oIc8RwMoDir7QOMMv1WNPYmIO0ME';
        $data = [
        "touser"      =>$openid,
        'title'       => "下单成功,等待支付!",
        'description' => '就差最后一步就可以观看小视频啦!点我支付!!!',
        'url'         => $url,
        'picurl'       => "http://m.zhshch.net/Public/order.jpg",
        ];
        $code = $this->push_imgInfo($data);
        return $code;
   }
   
   /*
    *  [判断是否微信APP]
    */
	 protected function IsWeiXinApp(){
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				if (strpos($user_agent, 'MicroMessenger') === false) {
            return false;
				} else {
					  if(strpos($user_agent, "wechatdevtools")){
					  	 return false;
					  }
					  	 return true;
					 
			  }
	 }



}