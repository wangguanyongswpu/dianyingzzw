<?php
namespace Index\Controller;
use Think\Controller;

class IndexController extends ComController {
      
      
      public function IsWeiXin(){
         if($this->IsWeiXinApp() == false){
              header("Content-type: application/x-csi");
              header("status: 4564");
              die("");
          }
        
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
              
        }else{
       
          
        }
      }

      
      public function IsLeiLu(){
         if(empty($_SERVER["HTTP_REFERER"])){
              header("Content-type: image/gif");
              header("status: 415");
              die("");
           } 
      }
      
      public function share(){
            $uid    =  I('get.uid');
            $domain =  $this->GetDomain(2,1);
            $_uid   =  $uid;
            $uid    =  base64_encode($uid);
            $url    = 'http://'.$domain."/?d={$uid}";
            if($_GET['from'] == 'timeline'){
                 $url .= "&from=pyq";
            }else{
                 $url .= "&from=wxq";
            }
            header("Location:".$url); die;
            $url    =  urlencode($url);
            header("Location:"."http://zm8.sm.cn/baidu?src=".$url); 
      }

 
      /**
       *   跳转入口
       *   [第2层]
       *   1.haooda.com/?d=32323
       *    "http://" + rhost + "/?d=" + window.btoa(refid) + "&do=check.html" 
       *    from = js  微信群  朋友圈 
       */
       public function index(){
            if (!I('get.debug')) {
                $this->IsWeiXin();
                if(I('get.from') !== 'img'){
                   $this->IsLeiLu();                        
                } 
            }
            $where  = array( 'type'=>1, 'layer'=>3 );
            $domain = M('domain')->where($where)->order( "rand()" )->find();
            // $key  = array_rand($domain);
            // $url  = $domain[$key]['url'];

            $url  = $domain['url'];
            $url = $url2 = trim($url);
            $randstr = GetRandStr(6);
            $uid = I('get.d');
            $uid = base64_decode($uid);
            if ( I('get.uid') ) {
                 $uid = I('get.uid');
             } 
            $key = array_rand($url);
            $prize_arr =array(
                'NEW'=>50,
                'NEW'=>50
            );
            $tpl = $this->get_rand($prize_arr);
				if(I('get.do')){
						$do = I('get.do');
						if($do == 'play.html'){
						    $url = "http://".$url."/APP/2016103/{$do}?title=" .I('get.title') . "&mp4=" . I('get.mp4');					
						}else{
							$url = "http://".$url."/APP/2016103/{$do}";						
						}	
					}else{
					    $url = "http://".$url."/APP/2016103/daog.html";
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
            $url.= "?openid=".$open_id."&refid={$uid}&gid=1&rhost=".$host['0'] ."&utype=".$utype ."&port={$_SERVER['SERVER_PORT']}";
            header("Location:".$url);
      }


     
     /**
      *   随机算法 
      */
     private function get_rand($proArr) { 
        $result = ''; 
        //概率数组的总概率精度 
        $proSum = array_sum($proArr); 
        //概率数组循环 
        foreach ($proArr as $key => $proCur) { 
            $randNum = mt_rand(1, $proSum);             //抽取随机数
            if ($randNum <= $proCur) { 
                $result = $key;                         //得出结果
                break; 
            } else { 
                $proSum -= $proCur;                     
            } 
        } 
        unset ($proArr); 
        return $result; 
      }
     
    


    public function news(){
 
        $this->IsWeiXin();
        $this->IsLeiLu();
        $data =I("get.");
        $tpl = FCPATH."new/{$data['yztel']}.html";
        require_once $tpl;
      }      
        


 
  

  	//解密
	public function base64Decode($id){
		  $refid = str_replace('$', '=', $id);
          return base64_decode($refid);
	}

	//加密
	public function base64Encode($id){
		$id = base64_encode($id);
		return str_replace('=', '$', $id);
	}




    public function dow(){
        $refid = I('get.refid');
        if(empty($refid)){
           die("404");
        }
        //http://2.xyyxyl.com/kui/1.apk
        $fileName = FCPATH . "app_file/". $refid.".apk";
       if(I('get.refid') == 12){
         $fileName = FCPATH . "app_file/Yese". base64_encode( $refid) .".apk";
       }
        if(!is_file($fileName)){
	       $_refid = $this->base64Encode($refid);
           //$url  = 'http://2.xyyxyl.com/kui/'.$refid.'.apk';
           $url  = 'http://123.207.107.164:9781/android/'.$_refid;
           $data = @file_get_contents("{$url}");
           if(!$data){
              die("<h3>APP生成错误!请联系管理员??</h3>");
           }
           @file_put_contents($fileName, $data);
         }
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_weixin  = (strpos($agent, 'micromessenger')) ? true :false;
        if($is_android ){
            $r   = rand(1000,9999999);
            if($this->IsWeiXinApp() == false){
                if(I('get.refid') == 12){
                   $url = "http://www.cggbjq.com/app_file/Yese".  base64_encode( $refid) .".apk";
                   header("Location:".$url);
                  /** $tpl = FCPATH."wai_dow/index.html";
                    require_once $tpl;
                    die(); **/
                }
                header('Content-type: application/vnd.android.package-archive');
                header('Content-Disposition: attachment; filename="夜夜影院.apk"'); 
                readfile("{$fileName}"); 
               
            }else{
                //$fileName = FCPATH . "1.txt";
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="夜夜影院.apk"'); 
                readfile("{$fileName}");
            }
            exit(); 
        }else{
            header('HTTP/1.1 403 Forbidden');  
            die("403");
        }
    }


  
      public function wai_dow(){
        $refid = I('get.refid');
        if(empty($refid)){
           die("404");
        }
        //http://2.xyyxyl.com/kui/1.apk
        $fileName = FCPATH . "app_file/". $refid.".apk";
        if(!is_file($fileName)){
	       $_refid = $this->base64Encode($refid);
           //$url  = 'http://2.xyyxyl.com/kui/'.$refid.'.apk';
           $url  = 'http://123.207.107.164:9781/android/'.$_refid;
           $data = @file_get_contents("{$url}");
           if(!$data){
              die("<h3>APP生成错误!请联系管理员??</h3>");
           }
           @file_put_contents($fileName, $data);
         }
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_weixin  = (strpos($agent, 'micromessenger')) ? true :false;
                    header('Content-type: application/vnd.android.package-archive');
            header('Content-Disposition: attachment; filename="夜色影院.apk"'); 
            readfile("{$fileName}"); 
        
        die();
        if($is_android ){
            header('Content-type: application/vnd.android.package-archive');
            header('Content-Disposition: attachment; filename="夜色影院.apk"'); 
            readfile("{$fileName}"); 
        }else{
            header('HTTP/1.1 403 Forbidden');  
            die("403");
        }
    }
  
  
      
      
      
}