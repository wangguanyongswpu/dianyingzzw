<?php
namespace Index\Controller;
use Think\Controller;
use EasyWeChat\Message\News;
use EasyWeChat\Foundation\Application;
set_time_limit(0);


class Task2Controller extends ComController {
  
  
    public function index(){
       // die('xxxxxx');
        $this->domain1();
        $this->domain2();
        $this->domain3();
        $this->domain4();
     }
    
  
  public function chack3(){
      $beiyong = M("domain")->where(array("type"=>3,'layer'=>4))->select();
 
      foreach($beiyong as $v){
        $url = "http://".$v['url'];
        $code = $this->ChackUrl2($url);
        echo $url . json_encode($code)."\r\n";
      }
  }
  
  private function ChackUrl2($url){
     $_url = "http://www.3045.com.cn/Api.php?url=".$url;
       $data = $this->httpGet($_url);
       $data = json_decode($data,true);
     return $data; 
       if($data['code'] == 0){
       return true;
     }else{
        return false;
     }     
    
  }
  

    private function domain1(){
     $domain = M("domain") ->where(array('layer'=>1,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( $this->chackurl($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>1))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'type'=>1
                                    ));
              }else{
                 M("domain")->where(array('id'=>$v['id']))->save( array("auto_chack_time"=> time() ));
              }
          }
        $num  = M("domain") ->where(array('layer'=>1,'type'=>1))->count();
        if($num <=1){
              $beiyong = M("domain")->where(array("type"=>3,'layer'=>1))->limit(1)->select();
              foreach ($beiyong as $key => $v) {
                     M('domain')->where(array("id"=>$v['id']))->save(array(
                          'qiyong_time'=> time(),
                          'type'=>1
                      ));
               }
        }
  }


    private function domain2(){
     $domain = M("domain") ->where(array('layer'=>2,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( $this->chackurl($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>2))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'type'=>1
                                    ));
              }else{
                 M("domain")->where(array('id'=>$v['id']))->save( array("auto_chack_time"=> time() ));
              }
          }
        $num  = M("domain") ->where(array('layer'=>2,'type'=>1))->count();
        if($num <=1){
              $beiyong = M("domain")->where(array("type"=>3,'layer'=>2))->limit(1)->select();
              foreach ($beiyong as $key => $v) {
                     M('domain')->where(array("id"=>$v['id']))->save(array(
                          'qiyong_time'=> time(),
                          'type'=>1
                      ));
               }
        }
  }







  private function domain3(){
     $domain = M("domain") ->where(array('layer'=>3,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( $this->chackurl($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>3))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'type'=>1
                                    ));
              }else{
                 M("domain")->where(array('id'=>$v['id']))->save( array("auto_chack_time"=> time() ));
              }
          }
        $num  = M("domain") ->where(array('layer'=>3,'type'=>1))->count();
        if($num <=1){
              $beiyong = M("domain")->where(array("type"=>3,'layer'=>3))->limit(1)->select();
              foreach ($beiyong as $key => $v) {
                     M('domain')->where(array("id"=>$v['id']))->save(array(
                          'qiyong_time'=> time(),
                          'type'=>1
                      ));
               }
        }
  }




  private function domain4(){
     $domain = M("domain") ->where(array('layer'=>4,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( $this->chackurl($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>4))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'type'=>1
                                    ));
              }else{
                 M("domain")->where(array('id'=>$v['id']))->save( array("auto_chack_time"=> time() ));
              }
          }
        $num  = M("domain") ->where(array('layer'=>4,'type'=>1))->count();
        if($num <=1){
              $beiyong = M("domain")->where(array("type"=>3,'layer'=>4))->limit(1)->select();
              foreach ($beiyong as $key => $v) {
                     M('domain')->where(array("id"=>$v['id']))->save(array(
                          'qiyong_time'=> time(),
                          'type'=>1
                      ));
               }
        }
  }





     

    //检查链接 
    private function chackurl($url){
       $_url = "http://api.tcncn.com/Api?token=qwds0sdjmk2&url=".$url;
       $data = $this->httpGet($_url);
       if(strpos($data, '2')){
          return false;
       }else{
          return true; 
       }
    }
    
 



}


?>