<?php
namespace Index\Controller;
use Think\Controller;
use EasyWeChat\Message\News;
use EasyWeChat\Foundation\Application;
set_time_limit(0);
/*
 * 任务管理模块
 */
class TaskController extends ComController {
    
    private $tasklist;

    public function  _initialize(){
         parent::_initialize();
        $this->tasklist = M('task')->select();
    } 
    
    //任务执行
    public function run(){
      foreach ($this->tasklist as $key => $v) {
        if ($v['status'] == 0) {
                  //任务执行周期 默认为5分钟
                  $chacktime = $v['chacktime'] ? $v['chacktime'] : 5;
                  $newtime = $v['thistime'] + ( $chacktime * 60 ); 
                  if (time() >= $newtime) {
                     echo "Run:".$v['name']."<br/>";
                     $this->$v['name']();                
                  }
           }else{
                  //超时处理
              if ($v['overtime']) {
                      $overtime = $v['overtime'] * 60;
                       //超时
                      if( (time() -  $v['thistime']) > $overtime ){
                         $_data = [
                             'status'=>0,
                          ];
                         M("task")->where(array('id'=>$v['id']))->save($_data);
                      }
               }  
          }
       }
    }

    //检查微信自定义菜单拦截情况
    private function ChackWeixinUrl(){
       $ChackWeixinUrl = M("task")->where(array('name'=>'ChackWeixinUrl'))->find();
       if ($ChackWeixinUrl['status'] == 0) {
           $task_data = [
              'status'=> 1,
              'lasttime'=>  $ChackWeixinUrl['thistime'],
              'thistime'=>  time(),
           ];
           M("task")->where(array('id'=>$ChackWeixinUrl['id']))->save($task_data);
           $weixin = M('weixin')->field("info")->select();
           $k_time = time();
           foreach ($weixin as $key => $v) {
               $info = json_decode($v['info'],true);
               $url  = "http://".$info['url']."?gid=".$v['k'];
               if( $this->chackurl($url) ==false){
                   $msg = "公众号".$info['name']."入口网址被拦截";
                   $this->push_weihu_tel($msg);
               }
           }
           $task_data = [
              'status'=>0,
              'consuming'=> time() - $k_time,
           ];
           M("task")->where(array('id'=>$ChackWeixinUrl['id']))->save($task_data);
       }
    } 



    //检查支付接口链接
    private function ChackPayUrl(){
       $ChackPayUrl = M("task")->where(array('name'=>'ChackPayUrl'))->find();
       if ($ChackPayUrl['status'] == 0) {
           $task_data = [
              'status'=> 1,
              'lasttime'=>  $ChackPayUrl['thistime'],
              'thistime'=>  time(),
           ];
           M("task")->where(array('id'=>$ChackPayUrl['id']))->save($task_data); //更新任务
           $k_time = time();//开始时间
           $url = C("PAY_API_URL");
           if( $this->chackurl($url) ==false){
                $msg = "支付接口网址被拦截";
                $this->push_weihu_tel($msg);
           }
           $task_data = [
              'status'=>0,
              'consuming'=> time() - $k_time,
           ];          
           M("task")->where(array('id'=>$ChackPayUrl['id']))->save($task_data);
       }
    }



    //检查展示页链接
    private function ChackIndexUrl(){
        $ChackIndexUrl = M("task")->where(array('name'=>'ChackIndexUrl'))->find();
        $this->IndexUrl1(); //检查替换
        if ($ChackIndexUrl['status'] == 0) {    
            $this->indexurl_jb();    
            $domain = M("domain")->where(array("type"=>1))->select();
            $task_data = [
              'status'=> 1,
              'lasttime'=>  $ChackIndexUrl['thistime'],
              'thistime'=>  time(),
           ];
           M("task")->where(array('id'=>$ChackIndexUrl['id']))->save($task_data); //更新任务
           $k_time = time();//开始时间             
           foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( $this->chackurl($url)  == false){
                  $d = array(
                    'type' => 2,
                     'lanjie_time' => time()
                    );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
               }
           }
           $task_data = [
              'status'=>0,
              'consuming'=> time() - $k_time,
           ];          
           M("task")->where(array('id'=>$ChackIndexUrl['id']))->save($task_data);
       }
    } 

    /*
     * 检查展示页域名
     */
    private function indexurl(){
        $num  = M('domain')->where("type=1")->count();
        $num  = $num ? $num : 0;
        $_num = 3;
        if ($num <= 2) {
            $rnad = $_num - $num;
            $beiyong = M("domain")->where(array('type'=>3))->limit($rnad)->select();
            foreach ($beiyong as $key => $v) {
                   M('domain')->where(array("id"=>$v['id']))->save(array(
                        'type'=>1
                    ));
               }
        }
    }
	
	//检查第一层域名 及时切换备用
	private function IndexUrl1(){
		 for($i=1;$i <= 2; $i++){
			 $num  = M('domain')->where(array("type"=>1,'layer'=>$i))->count();
			 $num  = $num ? $num : 0;
			 $_num = 3;
	         if ($num <= 2) {
	            $rnad = $_num - $num;
	            $beiyong = M("domain")->where(array("type"=>3,'layer'=>$i))->limit($rnad)->select();
	            foreach ($beiyong as $key => $v) {
	                   M('domain')->where(array("id"=>$v['id']))->save(array(
	                        'type'=>1
	                    ));
	               }
	         }
		 }	 
	}
	



    //展示页域名警报
    private function indexurl_jb(){
        $num = M('domain')->where("type =1 or type = 3")->count();
        if ($num ==1) {
              $this->push_weihu_tel("展示页域名还是剩下一个!立刻补充!");
          }  
    }
    

     

  /**  //检查链接 
    private function chackurl($url){
       $_url = "http://www.yundq.cn/url/wx?key=693E6C9885DC4231&url=".$url;
       $data = $this->httpGet($_url);
       if(strpos($data, '黑名单')){
          return false;
       }else{
          return true; 
       }
    }
    
**/
        //检查链接 
    private function chackurl($url){
       $_url = "http://hao.wxyun.org/hao.do?url=".$url;
       $data = $this->httpGet($_url);
       if(strpos($data, '2')){
          return false;
       }else{
          return true; 
       }
    }


    
    protected function push_WeixinInfo($data,$weixin){
        $json = '{"touser":"'.$data["touser"].'","msgtype":"news","news":{"articles": [ { "title":"'.$data["title"].'","description":"'.$data["description"].'","url":"'.$data['url'].'","picurl":"'.$data["picurl"].'"}]}}';
        $Token  = $this->GetWeixinToken($weixin['app_id'],$weixin['secret']);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$Token;
        $user   = $this->https_request($url,$json); 
        return json_decode($user,true);
     }


 
    /**
    * 智能匹配模版接口发短信
    * apikey 为云片分配的apikey
    * text 为短信内容
    * mobile 为接受短信的手机号
    */
    private function send_sms($apikey, $text, $mobile){
        $url="http://yunpian.com/v1/sms/send.json";
        $encoded_text = urlencode("$text");
        $mobile = urlencode("$mobile");
        $post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }


    /**
    * 模板接口发短信
    * apikey 为云片分配的apikey
    * tpl_id 为模板id
    * tpl_value 为模板值
    * mobile 为接受短信的手机号
    */
    private function tpl_send_sms($apikey, $tpl_id, $tpl_value, $mobile){
        $url="http://yunpian.com/v1/sms/tpl_send.json";
        $encoded_tpl_value = urlencode("$tpl_value");  //tpl_value需整体转义
        $mobile = urlencode("$mobile");
        $post_string="apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }


    /**
    * url 为服务的url地址
    * query 为请求串
    */
    private function sock_post($url,$query){
        $data = "";
        $info=parse_url($url);
        $fp=fsockopen($info["host"],80,$errno,$errstr,30);
        if(!$fp){
            return $data;
        }
        $head="POST ".$info['path']." HTTP/1.0\r\n";
        $head.="Host: ".$info['host']."\r\n";
        $head.="Referer: http://".$info['host'].$info['path']."\r\n";
        $head.="Content-type: application/x-www-form-urlencoded\r\n";
        $head.="Content-Length: ".strlen(trim($query))."\r\n";
        $head.="\r\n";
        $head.=trim($query);
        $write=fputs($fp,$head);
        $header = "";
        while ($str = trim(fgets($fp,4096))) {
            $header.=$str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp,4096);
        }
        return $data;
    }


    /*
     * 检测备用七牛域名是否配置正常
     *
     * 只检查域名网络可否访问及返回的是否是七牛的配置错误提醒消息,不检查微信拦截
     */
    public function qiniuSyncCheck(){
        //只取一个,防止获取太多,检测时候这个记录被其它进程重复检测
        //$domain = M("domain")->where(array("type" => 3,'layer'=>3,'checked'=>['EXP','IS NULL']))->order('id ASC')->limit(10)->select();
        $domain = M("domain")->where(array("type" => 3,'_string'=>'layer=3 OR layer=4','checked'=>['EXP','IS NULL']))->order('id ASC')->limit(10)->select();
        //echo M('domain')->getLastSql()."\n";

        $webbr = '';
        if(php_sapi_name() != 'cli'){
			echo '<script language="javascript">
setTimeout("self.location.reload();",60000);
</script>';
            $webbr = '<br />';
        }

        if(!$domain){
            echo "没有可检测域名{$webbr}\n";
            return true;
        }
        foreach ($domain as $key => $v) {
            if (strpos($v['url'], 'qnssl.com') === false || strpos($v['url'], '.clouddn.com') === false) {
                //目前只检测七牛域名
//                continue;
//                unset($domain[$key]);
            }
            //正在检测,防止其它进程获取到
            $d = ['checked' => 0];
            M("domain")->where(array('id' => $v['id']))->save($d);
        }

        foreach ($domain as $key => $v) {

            $url = "http://" . $v['url'].'/cdn7041a5d93d4ccb94ef533ab7025c5f90.html';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_URL, $url);
            try{
                $res = curl_exec($curl);
            }catch (Exception $e){
                $res = $e->getMessage();
            }
            curl_close($curl);
            $res = trim($res);

            //if($res!='cdn-a5d93d4ccb94ef533ab7025c5f90'){
            if($res=='' || strpos($res,'5d93d4ccb94ef533ab7025c5f90')===false){
                if(!$res) $res='unknown err.';

                $d=['type'=>2,'check_ret'=>$res,'checked'=>-1];
                $d=['check_ret'=>$res,'checked'=>-1];
                $msg = "<span style='color:red'>域名访问异常:{$v['url']}: '{$res}'</span>{$webbr}\n";
                echo $msg;
                M("domain")->where(array('id' => $v['id']))->save($d);
                //echo M('domain')->getLastSql()."\n";
            }else{
                $d=['checked'=>1];
                M("domain")->where(array('id' => $v['id']))->save($d);
                $msg = "域名访问正常:{$v['url']}: {$res}{$webbr}\n";
                echo $msg;
            }
        }
    }

}
?>