<?php



   $url = $_GET['url'];
  
   if ( chackurl($url) == false){
      $data['code'] = 1;
   }else{
      $data['code']  = 0;
   }

   die( json_encode($data) );
 

 

 

    //检查链接 
   function chackurl($url){
       $_url = "http://api.fyguke.com/Api?token=DOELJBHUMQGVRCANWIZY&url=".$url;
       $data = httpGet($_url);
       if(strpos($data, '2')){
          return false;
       }else{
          return true; 
       }
    }

   

function httpGet($url) {
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



?>