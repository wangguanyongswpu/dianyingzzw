<?php
/**   GID 对用公众号配置
 *    http://www.*.com/index.php/index/api?gid=0     公众号接口地址
 *    http://www.*.com/index.php/index/index?gid=0   自定义菜单配置url 
 *    
 */
return array(
		'DEFAULT_MODULE'        =>  'Index',  // 默认模块
		'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
		'DEFAULT_ACTION'        =>  'index', // 默认操作名称
        
		'URL_MODEL'          => '2',
		 
		'DB_TYPE'               =>  'mysql',     // 数据库类型
		'DB_HOST'               =>  '10.66.210.137', // 服务器地址
		'DB_NAME'               =>  'dianying1',          // 数据库名
		'DB_USER'               =>  'domain_ad',      // 用户名
		'DB_PWD'                =>  'k3FKB7aa5Y',          // 密码
        'DB_PORT'               =>  '3306', 
		'DB_PREFIX'             =>  'dy_',    // 数据库表前缀
	    'DB_CHARSET'=>  'utf8',      // 数据库编码默认采用utf8
        'URL_CASE_INSENSITIVE' =>true, //URL不区分大小写
    //充值vip跳转的url
    "DIANYING_YSE_VIP_URL" => array(
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_3.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_4.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_5.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_6.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_7.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_8.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_9.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_3.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_4.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_5.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_6.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_7.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_8.mp4',
			'http://txcdn1.hnszzqy.com/9e0120cv23/vip/2/om_9.mp4',		
       
    	),

    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
	   	   "s/:uid" => 'Index/Index/share', 
	   	   'S'=> 'Index/Index/share',
      		"/^ud\/(\S+)\/rh\/(\S+)\/id\/(\S+)\/(\S+)$/" => 'Index/Index/news?uid=:1&rhost=:2&view=:4',
      		"/^ud\/(\S+)\/rh\/(\S+)$/" => 'Index/Index/news?uid=:1&rhost=:2&view=:2',
      		
      
           "1/:str/:yztel/:yztel2" => 'Index/Index/news',
      
           "1/:str/:yztel" => 'Index/Index/news',
      
           "2/:str/:yztel/:yztel2" => 'Index/Index/news2',
      
           "2/:str/:yztel" => 'Index/Index/news2',    
      
            "3/:str/:yztel/:yztel2" => 'Index/Index/news3',
      
           "3/:str/:yztel" => 'Index/Index/news3',    
      
         /**  "/^(\d+)\/(\d+)\/(\d+)\/(.*?)$/" => 'Index/Index/news2?yztel=:4',
      
            "/^(\d+)\/(\d+)\/(.*?)$/" => 'Index/Index/news?yztel=:3', **/
      
      
	       'APP/:str/:yztel'=> 'Index/Index/news',
            
	       //'NEW/:str/:yztel'=> 'Index/Index/new2',
           'dow/:data'=> 'Index/Index/dow',
           'wai_dow/:data'=> 'Index/Index/wai_dow',
	        "/^(\d+)\/(\d+)$/" => 'Index/Index/share?uid=:2',
        "share" =>  "Index/Index/Qunshare",
	       
     ),
     
	 
	 "MIX_PRO" =>'50000',
	 "MAX_PRO" =>'50238',

    //支付完成回调密钥 
    "PAY_API_CALL_KEY" =>'18361130555',
    "PAY_API_URL_APP_ID" =>"1000000001",    
    'PAY_API_URL_APP_KEY'=> 'SKDJSKDJK123SDAS90SDDSA',

         


);