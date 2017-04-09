<?php
namespace Index\Controller;
use Think\Controller;
/*
  后台后台统一在admin控制器下面
 */
class AdminController extends ComController {
    
    //不验证登陆的方法
    private $no_chack= ['login','chack_login','get_group_domain','get_packets','getpaydomaintwo'];
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
        //支付接口
        $paydomains = array();
        $payinfers = array();
        for ($i=1; $i <5 ; $i++) { 
            $paydomains[$i] = M('paydomain')->where("status<>3 AND sys=".$i)->select();
            $payinfers[$i] = M('payinfer')->where("status<>3 AND sys=".$i)->select();
        }
        // dump($paydomains);
        $this->assign('paydomains',$paydomains);
        $this->assign('payinfers',$payinfers);

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
        $where = "type = {$data['type']} and layer = {$data['layer']}";
        if(I("get.type") == 2){
            $order = "lanjie_time desc";
            if(I("get.layer") == 3){
                $time  = time()  - ( (60*60) * 48 );
                $where .= " and lanjie_time >= {$time}";
            }
        }
        //某一层被拦截数
        if(I("get.layer") == 3){
            $time2  = time()  - ( (60*60) * 48 );
            $wherelayerban = "type= 2 and layer = {$data['layer']} and lanjie_time >= {$time2}";
        }else{
            $wherelayerban = "type= 2 and layer = {$data['layer']}"; 
        }
        $data['domainlist'] = M('domain')->where($where)->order($order)->select();

        $domains = '';
        foreach($data['domainlist'] as $k=>$v){
            $domains .= ",".$v["url"];
        }
        $this->domains = trim($domains,",");

        $time1 = strtotime(date("Y-m-d 23:59:59",strtotime("-1 day")));
        $wherelayerun = "type= 1 and layer = {$data['layer']}";   //某一层启用数
        $wherelayerbantoday = "type= 2 and layer = {$data['layer']} and lanjie_time > {$time1}";   //今天某一层被拦截数
        $wherelayeready = "type= 3 and layer = {$data['layer']}";   //某一层备用数
        $data['domainruncount'] = M('domain')->where($wherelayerun)->count();
        $data['domainbancount'] = M('domain')->where($wherelayerban)->count();
        $data['domainbancountoday'] = M('domain')->where($wherelayerbantoday)->count();
        $data['domainreadycount'] = M('domain')->where($wherelayeready)->count();
        if (IS_POST) {
           $this->ajaxReturn($data);
           die();
        }
        $this->assign($data);
        $this->display();  
    }
   
    /*
     * 域名添加
     */
    public function add_paydomain(){
        $data = I("post.");
		$url  = nl2br( I("post.url") );
		$url = explode("<br />",$url);
		if (empty($data['url'])) {
            $this->error("请输入完整");
        }
	    $data['status'] = 0;
		foreach($url as $v){
			$v = trim($v);
			if($v){
				$data['paydomain'] = $v;
			    M("paydomain")->add($data);			
			}
		}
        $this->success("添加成功");
		
    }

    /*
     * 第二次域名添加
     */
    public function add_paydomaintwo(){
        $data = I("post.");
        $url  = nl2br( I("post.url") );
        $url = explode("<br />",$url);
        if (empty($data['url'])) {
            $this->error("请输入完整");
        }
        $data['status'] = 0;
        foreach($url as $v){
            $v = trim($v);
            if($v){
                $data['paydomain'] = $v;
                M("paydomaintwo")->add($data);
            }
        }
        $this->success("添加成功");

    }

    /*
     * 支付域名添加
     */
    public function add_domain(){
        $data = I("post.");
        $url  = nl2br( I("post.url") );
        $url = explode("<br />",$url);
        if (empty($data['url'])) {
            $this->error("请输入完整");
        }
        $data['look'] = 0;
        foreach($url as $v){
            $v = trim($v);
            if($v){
                $data['url'] = $v;
                M("domain")->add($data);            
            }
        }
        $this->success("添加成功");
        
    }

    /*
     * 支付接口添加
     */
    public function add_infer(){
        $data = I("post.");
        $url  = nl2br( I("post.url") );
        $url = explode(",",$url);
        if (empty($data['url'])) {
            $this->error("请输入完整");
        }
        $data['status'] = 0;
        foreach($url as $v){
            $v = trim($v);
            if($v){
                $data['infer'] = $v;
                M("payinfer")->add($data);            
            }
        }
        $this->success("添加成功");
        
    }
     
    /*
     * 域名更新
     */
    public function domain_save(){
        $data = I('get.');
		if($data['type'] == 1){
	        $data['qiyong_time']  =  time();
		}
    if ($data['lanjietype']==1) {
          $data['lanjie_reason'] = 1;
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
    public function domain_del(){
      $id = I("get.id");
      $res = M("domain")->where("id=".$id)->delete();
      if($res){
          $this->success("删除成功");
      }else{
          $this->success("删除失败");
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
        M('paydomain')->where(array('status'=>1))->save(array('status'=>0));
        M('payinfer')->where(array('status'=>1))->save(array('status'=>0));
        M('paydomain')->where("id in(" .$data['paydomain1'].")")->save(array('status'=>1));
        M('payinfer')->where("id in(".$data['payinfer1'].")")->save(array('status'=>1));


        $paydomain1 = M('paydomain')->where("id=".$data['paydomain1'])->find();
        $payinfer1 = M('payinfer')->where("id=".$data['payinfer1'])->find();
        $para['PAY_API_URL'] = "http://".$paydomain1['paydomain']."/Pay/".$payinfer1['infer'];


        $data = $para;
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

    /*
     *  经过检测的无法访问的域名列表
     *  检测功能位于index/task/qiniuSyncCheck.html
     */
    public function errDomain()
    {
        //        if(empty($_GET['layer'])) $_GET['layer']=3;
        $data['layer']      = intval(I("get.layer",0));
        $data['key']      = I("get.key") ? I("get.key") : '';
        $p                  = isset($_GET['p']) ? intval($_GET['p']) : '1';
        $pagesize           = 10;#每页数量
        $offset             = $pagesize * ($p - 1);//计算记录偏移量

        $filter = "checked=-1 and type=3";
        if(!empty($data['layer'])) $filter .= " AND layer={$data['layer']}";
        if(!empty($data['key'])) $filter .= " AND url LIKE '%{$data['key']}%'";

        $count              = M('domain')->where($filter)->count();
        $data['domainlist'] = M('domain')->where($filter)->select();
//                echo M('domain')->getLastSql();
        $page               = new \Think\Page($count, $pagesize);
        $page               = $page->show();
        $this->assign('page', $page);
        //var_dump($data);
        $this->assign($data);
        $this->display('err_domain');
    }
    
    

    public function get_layer_domain(){
    
        $domainlist = M("domain")->where("layer = 3 and lanjie_time >= UNIX_TIMESTAMP(2016-11-01) and lanjie_time <= UNIX_TIMESTAMP(2016-11-31)")->select(false);
        var_dump($domainlist);

    }

    //微信群域名分组管理
    public function grouppacket(){
        $get_web_type = I("get.web_type");
        if($get_web_type){            
           $packet = M('packet')->field('*')->where("web_type=".$get_web_type)->select();
        }else{            
          $packet = M('packet')->field('*')->select();
        }

        $domain = M('domain')->where("type=1 AND layer=9")->field('id,url')->select();

        $domain_arr = array();
        foreach($domain as $v){
            $domain_arr[$v['id']] = $v['url'];
        }
        $list = array();
        $web_type = [1=>"疯狂赚",2=>"悦涩吧",3=>"凌晨影院",4=>"激情影院"];
        if($packet){
            foreach($packet as $v){
                $domain_str = '';
                if($v['domain_id'] && is_array(unserialize($v['domain_id']))){
                    $domain_id_arr = unserialize($v['domain_id']);
                    foreach($domain_id_arr as $value){
                        $domain_str  .= $domain_arr[$value].", ";
                    }

                }
                $list[] = array('alias' =>"(".$web_type[$v['web_type']].")".$v['alias'], 'domains' =>$domain_str,'id' => $v['id'] );
            }
        }
        $this->assign('packet',$list);
        $this->assign('get_web_type',$get_web_type);
        $this->display();
    }

    //新增微信群域名分组
    public function add_packet(){
      //查询出所有分组已用域名
      $packets = M("packet")->field("domain_id")->select();
      $where = '';
      $domainArr = array();
      if($packets){
        foreach($packets as $k=>$v){
            $domainArr = array_merge($domainArr,unserialize($v['domain_id']));
        }
        if($domainArr){
          $where = " and id not in(".implode(",",$domainArr).") ";
        }
      }
      $domains = M("domain")->field("id,url")->where("layer=9 and type=1 ".$where)->select();

      $this->assign('domains',$domains);
      $this->display();
    }
    //修改微信群域名分组
    public function edit_packet(){
      $id = I("get.id");
      if(empty($id)){
          $this->error("参数错误");
          exit;
      }
      //查询出所有分组已用域名
      $packets = M("packet")->select();
      $where = '';
      $domainArr = array();
      foreach($packets as $k=>$v){
          if($v["id"]==$id){//当前分组域名
            $this_domain = unserialize($v['domain_id']);
            $web_type = $v['web_type'];
            $alias = $v["alias"];
          }else{
            $domainArr = array_merge($domainArr,unserialize($v['domain_id']));
          }
      }
      if($domainArr){
        $where = " and id not in(".implode(",",$domainArr).") ";
      }
      $domains = M("domain")->field("id,url")->where("layer=9 and type=1 ".$where)->select();
      foreach($domains as $k=>$v){
          if(in_array($v["id"],$this_domain)){
            $domains[$k]["is_sel"] = true;
          }else{
            $domains[$k]["is_sel"] = false;
          }
      }
      $this->assign('id',$id);
      $this->assign('alias',$alias);
      $this->assign('web_type',$web_type);
      $this->assign('domains',$domains);
      $this->display();
    }
    //处理更新分组操作
    public function update_packet(){
      $id = $_POST["id"] ? $_POST["id"] : '';
      $data["alias"] = $_POST["alias"];
      $data["web_type"] = $_POST["web_type"];
      $data["domain_id"] = serialize($_POST["domain_id"]);
      if(empty($data["alias"]) || empty($data["domain_id"])){
          $this->error("参数错误");
          exit;
      }
      if($id){
          $res = M("packet")->where("id=".$id)->save($data);
      }else{
          $res = M("packet")->add($data);
      }
      if($res){
          $this->success("操作成功",U('index/admin/grouppacket'));
      }else{
        $this->error("操作失败");
      }
    }


    //支付域名管理
    public function paydomain(){
        $paydomainlist = M('paydomain')->where("status<>3")->order('sys desc')->select();
        $this->assign('paydomainlist',$paydomainlist);
        $this->display();
    }

    //第二次支付域名管理
    public function paydomaintwo(){
        $paydomainlist = M('paydomaintwo')->where("status<>3")->order('sys desc')->select();
        $this->assign('paydomainlist',$paydomainlist);
        $this->display();
    }

    //获取第二次支付域名
    public function getpaydomaintwo () {
        $paydomainlist = M('paydomaintwo')->where(['status'=>1])->order('rand()')->getField('paydomain');
        if (!empty($paydomainlist)) {
            $this->ajaxReturn(["group_domain"=>$paydomainlist]);
        } else {
            $this->ajaxReturn(["group_domain"=>'']);
        }
    }

    //取消域名
    public function cacelpaydomain(){
        $data=I('get.');
        $id=intval($data['id']);
        $updateid = M('paydomain')->where(array('id'=>$id))->save(array('status'=>3));
        //echo M()->getLastSql();die;
        if ($updateid) {
            $this->success("取消成功");
        }else{
            $this->error("取消失败");
        }
    }

    //取消域名
    public function cacelpaydomaintwo(){
        $data=I('get.');
        $id=intval($data['id']);
        $updateid = M('paydomaintwo')->where(array('id'=>$id))->save(array('status'=>3));
        //echo M()->getLastSql();die;
        if ($updateid) {
            $this->success("取消成功");
        }else{
            $this->error("取消失败");
        }
    }


    //取消接口
    public function cacelinfer(){
        $data=I('get.');
        $id=intval($data['id']);
        $updateid = M('payinfer')->where(array('id'=>$id))->save(array('status'=>3));
        //echo M()->getLastSql();die;
        if ($updateid) {
            $this->success("取消成功");
        }else{
            $this->error("取消失败");
        }
    }
     
    //支付接口管理
    public function payinfer(){
        $payinferlist = M('payinfer')->where("status<>3")->select();
        $this->assign('payinferlist',$payinferlist);
        $this->display();
    }

    //cps获取微信群域名接口
    public function get_group_domain(){
      $packet_id = I("get.packet_id");
      $where = '';
      if($packet_id){
        $domains = M("packet")->where("id=".$packet_id)->getField("domain_id");
        if($domains){
          $where = " and id in(".implode(",",unserialize($domains)).")";
        }
      }
      $res = M("domain")->where("type=1 and layer=9 $where")->limit(1)->order("rand()")->getField("url");
      if(!$res){
          $res = M("domain")->where("type=1 and layer=9")->limit(1)->order("rand()")->getField("url");
      }
      $this->ajaxReturn(["group_domain"=>$res],'jsonp');
      /*echo json_encode(["group_domain"=>$res]);
      exit;*/
    }
    //分销商列表分组
    public function get_packets(){
      $web_type = I("get.web_type");
      $packets = M("packet")->field("id,alias")->where("web_type=".$web_type)->select();
      echo json_encode($packets);
      exit;
    }


}