<?php
namespace Index\Controller;
use Think\Controller;
/*
  后台后台统一在admin控制器下面
 */
class AdminController extends ComController {
    
    //不验证登陆的方法
    private $no_chack= ['login','chack_login'];
    public function  _initialize(){
        parent::_initialize();
       if( in_array(ACTION_NAME , $this->no_chack) !== true){
            $this->chacklogin();
       }
    }

    /**验证登陆**/
    private function  chacklogin(){
       $admin = session("admin");
       if(!$admin){
           $this->error("未登陆",U("/index/admin/login"));
       }
    }
    
    //登陆
    public function login(){
       $this->display();
    }

    //注销
    public function logout(){
       session("admin",null);
       $this->success("注销成功");
    }

    //登陆验证
    public function chack_login(){
        $data = I('post.');
        $user = M('admin')->where(array("name"=>$data['name'],'password'=>md5($data['password'])))->find();
        if(!$user){
            $this->error("账号或者密码不存在");
        }else{
            session("admin",$user['name']);
            $this->success("登陆成功,",U('index/admin/index'));
        }

    }
    
    /*
     * 修改密码处理 
     */
    public function password(){
        $data = I('post.');
        if ($data['password'] !== $data['password1']) {
            $this->error("2次密码不一致");
        }else{
            $name = session("admin");
            $_data = array(
                 'password'=>md5($data['password'])
                );
            if( M('admin')->where(array("name"=>$name))->save($_data) !== false ){
                 $this->success("修改成功");
            }else{
                 $this->error("修改失败");
            }
        }
    } 



    //管理首页
    public function index(){
        $data['gznum'] = M('user')->where(array('follow'=>1))->count();
        $data['qxnum'] = M('user')->where(array('follow'=>0))->count(); 
        $jinri_time=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $data['jinri_num'] = M('user')->where("reg_time >=". $jinri_time)->count();
        $data['h24_num'] = M('user')->where("login_time >=". $jinri_time)->count();
        $data['task'] = M("task")->select();
        $this->assign($data);
        $this->display();
    }    
    
    /*
     * 公众号管理
     */
    public function weixin(){
        $data['weixin'] = M("weixin")->order("k asc")->select();
        foreach ($data['weixin'] as $key => $value) {
            $info = json_decode($value['info'],true);
            $data['weixin'][$key] = array_merge($value,$info);
        }
        $this->assign($data);
        $this->display();
    }
    
    
    /*
     * add_weixin 添加微信处理
     */ 
    public function add_weixin(){
        $data = I('post.');
        if(empty($data['k'] )  || empty($data['app_id'] )  || empty($data['secret'] ) || empty($data['token'] ) || empty($data['url']) )  {
           $this->error("请输入完成");
        }
        if( M('weixin')->where("k=".$data['k'])->find() ){
             $this->error("键值已存在,请修改");
        }
        $weixin = [
            'name'  => trim($data['name']),
            'app_id'=> trim($data['app_id']),
            "secret"=> trim($data['secret']),
            "token" => trim($data["token"]),
            "url"   => trim($data['url']),
        ];
        $_DATA = array(
              'k'=>trim($data['k']),
              'info' => json_encode($weixin)
              );
        if( M("weixin")->add($_DATA) ){
            $this->success("添加成功");
        }
    }
   
    /*
     * 删除微信
     */
    public function del_weixin(){
         $id = I('get.id');
         if( M('weixin')->where(array('id'=>$id))->delete() !== false){
             $this->success("删除成功");
         }else{
              $this->error("删除错误");
         }
    }
    

    /*
     *  更新微信
     */
    public function save_weixin(){
        $data = I("post.");
        if(empty($data['k'] )  || empty($data['app_id'] )  || empty($data['secret'] ) || empty($data['token'] ) || empty($data['url']) )  {
           $this->error("请输入完成");
        }
        $weixin = [
            'name'  => trim($data['name']),
            'app_id'=> trim($data['app_id']),
            "secret"=> trim($data['secret']),
            "token" => trim($data["token"]),
            "url"   => trim($data['url']),
        ];
        $_DATA = array(
              'k'=>trim($data['k']),
              'info' => json_encode($weixin),
              );          
        if( M("weixin")->where(array('id'=>$data['id']))->save($_DATA) !== false){
            $this->success("更新成功");
        }
    }
    
    /*
     * 设置自定义菜单
     */
    public function memu(){
        $menu = I("post.memu");
 
        if (empty($menu)) {
            $this->error("请输入菜单名称");
        }
        $weixin = M("weixin")->order("k asc")->select();
        foreach ($weixin as $k => $v) {
            $w= json_decode($v['info'],true);
            $url = "http://".$w['url']."?gid=".$v['k'];
            $data = '{
             "button":[{
               "type":"view",
               "name":"[menu]",               
                "url":"[url]"
               }]
             }';
            $data = str_replace("[menu]", $menu, $data);
            $data = str_replace("[url]", $url, $data);
            $Token  = $this->GetWeixinToken($w['app_id'],$w['secret']);
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$Token;
            $res = $this->https_request($url, $data);
            $code = json_decode($res,true);
            if ($code['errmsg'] == 'ok') {
                echo $w['name']."->自定义菜单设置成功!<BR />";
            }
        }
    }

    /*
     *   域名管理
     */
    public function domain(){
         $data['type']  = I("get.type") ? I("get.type") :1;
		     $data['layer'] = I("get.layer")?I("get.layer"):1;
         $data['domainlist'] = M('domain')->where(array("type"=> $data['type'],'layer'=>$data['layer']))->select();
         $this->assign($data);
         $this->display();  
    }
   
    /*
     * 域名添加
     */
    public function add_domain(){
        $data = I("post.");
        if (empty($data['url'])) {
            $this->error("请输入完整");
        }
        $data['look'] = 0;
        if(M("domain")->add($data) !== false){
            $this->success("添加成功");
        }else{
            $this->error("添加错误");
        }
    }
     
    /*
     * 域名更新
     */
    public function domain_save(){
        $data = I('get.');
		if($data['type'] == 1){
	        $data['qiyong_time']  =  time();
		}
		if($data['type'] == 2){
	        $data['lanjie_time']  =  time();
		}
	    if($data['type'] == 3){
	        $data['qiyong_time']  =  0;
		}
        if ( M('domain')->where(array('id'=>$data['id']))->save($data) !== false){
            $this->success("更新成功");
        }
    }
    

    /*
     * 推送管理
     */
    public function push(){
        $data['push'] =M('push')->order("id desc")->select();
        $this->assign($data);
        $this->display();  
    }
    
    /*
     * 添加推送
     */
    public function add_push(){
       $data = I('post.');
       if (empty($data['title'])  || empty($data['description']) || empty($data['picurl']) ) {
           $this->error("标题 描述 图片链接不可以为空");
       }
       $info = [
           'title'=>$data['title'],
           'description'=>$data['description'],
           'picurl'=>$data['picurl'],
           'url' =>$data['url'],
        ];
       $_data = [
            'time'=>time(),
            'info'=> json_encode($info),
            'status'=>0,
            'where' => $data['type'],
       ];
       if(M("push")->add($_data)!== false){
          $this->success("推送任务添加成功!");
       }
    }

   
    //系统设置
    public function site(){
        $data = I('post.');
        foreach ($data as $key => $v) {
            $data = array(
                     'name'=>$key,
                     'valus'=>$v
             );
            if( M("site")->where(array('name'=>$key))->find() ){
                M("site")->where(array('name'=>$key))->save($data);
            }else{
                M("site")->add($data);
            }
        }
        $this->success("设置成功");
    }




}