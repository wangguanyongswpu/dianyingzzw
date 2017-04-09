<?php
namespace Index\Controller;
use Think\Controller;
use EasyWeChat\Message\News;
use EasyWeChat\Foundation\Application;
set_time_limit(0);


class Task5Controller extends ComController {
  
  
    public function index(){
       // var_dump(pingAddress('www.baidu.com'));die;
        $this->domain1();
        $this->domain2();
        $this->domain3();
        $this->domain4();
     }
    
  

    private function domain1(){
     $domain = M("domain") ->where(array('layer'=>1,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( pingAddress($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_reason'=>1,
                      'qidong_type' => 1,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>1))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'qidong_type'=>1,
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
                          'qidong_type'=>1,
                          'type'=>1
                      ));
               }
        }
  }


    private function domain2(){
     $domain = M("domain") ->where(array('layer'=>2,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( pingAddress($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_reason'=>1,
                      'qidong_type' => 1,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>2))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'qidong_type'=>1,
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
                          'qidong_type'=>1,
                          'type'=>1
                      ));
               }
        }
  }







  private function domain3(){
     $domain = M("domain") ->where(array('layer'=>3,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( pingAddress($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_reason'=>1,
                      'qidong_type' => 1,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>3))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'qidong_type'=>1,
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
                          'qidong_type'=>1,
                          'type'=>1
                      ));
               }
        }
  }




  private function domain4(){
     $domain = M("domain") ->where(array('layer'=>4,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( pingAddress($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_reason'=>1,
                      'qidong_type' => 1,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>4))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'qidong_type'=>1,
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
                          'qidong_type'=>1,
                          'type'=>1
                      ));
               }
        }
  }

   private function domain9(){
     $domain = M("domain") ->where(array('layer'=>9,'type'=>1))->select();
         foreach ($domain as $key => $v) {
               $url = "http://".$v['url'];
               if( pingAddress($url)  == false){
                  $d = array(
                      'type' => 2,
                      'lanjie_reason'=>1,
                      'qidong_type' => 1,
                      'lanjie_time' => time()
                  );
                  M("domain")->where(array('id'=>$v['id']))->save($d);
                  $domain = M("domain")->where(array("type"=>3,'layer'=>9))->find();
                  M('domain')->where(array("id"=>$domain['id']))->save(array(
                                          'qiyong_time'=> time(),
                                          'qidong_type'=>1,
                                          'type'=>1
                                    ));
              }else{
                 M("domain")->where(array('id'=>$v['id']))->save( array("auto_chack_time"=> time() ));
              }
          }
        $num  = M("domain") ->where(array('layer'=>9,'type'=>1))->count();
        if($num <=1){
              $beiyong = M("domain")->where(array("type"=>3,'layer'=>9))->limit(1)->select();
              foreach ($beiyong as $key => $v) {
                     M('domain')->where(array("id"=>$v['id']))->save(array(
                          'qiyong_time'=> time(),
                          'qidong_type'=>1,
                          'type'=>1
                      ));
               }
        }
  }





     

    //检查链接 
    private function chackurl($url){
       $_url = "http://api.fyguke.com/Api?token=DOELJBHUMQGVRCANWIZY&url=".$url;
       $data = $this->httpGet($_url);
       if($data=="[2]"){
          return false;
       }else{
          return true; 
       }
    }
 



}


?>