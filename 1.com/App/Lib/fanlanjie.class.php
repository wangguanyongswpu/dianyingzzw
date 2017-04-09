<?php
 /**
  *  微信反拦截类
  *  data: 2016-12-26 15:07
  *  截取微信ip思路  1,
  */
 class fanlanjie{
        
        private $iptables = '1939800064~1939865599|977012992~977013247|977084416~977084927|1743654912~1743655935|1949957632~1949958143|2006126336~2006127359|2111446272~2111446527|3418570752~3418578943|3419242496~3419250687|3419250688~3419275263|3682941952~3682942207|3682942464~3682942719|3682986660~3682986663|1998389248~1998454783|2077163520~2077229055';
		//后续追加
		private $ip_table = array(
				'61.151.0.0~61.151.255.255',
				'122.228.0.0~122.228.255.255',
				'101.69.0.0~101.69.255.255',
				'180.153.0.0~180.153.255.255',
				'101.226.0.0~101.226.255.255',
				'122.246.0.0~122.246.255.255',
				'117.185.0.0~117.185.255.255',
				'180.163.0.0~180.163.255.255',
				'140.207.0.0~140.207.255.255',
				'183.192.0.0~183.192.255.255',
				'112.65.0.0~112.65.255.255',
				//edit 1.4
				'125.39.0.0~125.39.255.255',
				'163.177.0.0~163.177.255.255',
				'183.61.0.0~183.61.255.255',
				'14.17.0.0~14.17.255.255',
				'14.17.0.0~14.17.255.255',
				'219.133.0.0~219.133.255.255',
				'113.108.0.0~113.108.255.255',
				'183.57.0.0~183.57.255.255',
				'119.147.0.0~119.147.255.255',
				'58.251.0.0~58.251.255.255',
				//edit 1.5
				'172.18.0.0~172.18.255.255',
				//edit 1.6
				'123.151.0.0~123.151.255.255',
          		//edit 1.12
          		'183.60.0.0~183.60.255.255',
          		//edit 1.15
          		'106.38.0.0~106.38.255.255',
          		'220.181.0.0~220.181.255.255',
          		'218.30.0.0~218.30.255.255',
          		//edit 1.18
          		'106.120.0.0~106.120.255.255',

		);
       
	    public function GetIpList(){
	    	$iptables = $this->iptables;
			foreach($this->ip_table as $v){
			    $ipbanrange   =  explode('~',$v);
				$iptables    .=  "|" .$this->ip2long2( $ipbanrange[0] ) . "~" . $this->ip2long2( $ipbanrange[1] );	
			}
			return $iptables;
	    }
         
		 
        public function ip2long2($ip){
            return bindec(decbin(ip2long( $ip ) ) );
        }
		
		
        public function getip2long2(){
        	return $this->ip2long2 ( $this->get_real_ip() );
        }


        public function init(){
 
			$remoteiplong = $this->getip2long2();
			$iptables     = $this->GetIpList();
			foreach(explode('|',$iptables) as $iprows){
				$ipbanrange=explode('~',$iprows);
				if($remoteiplong>=$ipbanrange[0] && $remoteiplong<=$ipbanrange[1]){
                   // $this->qq301();
                }
 
			}
          
          	//特定IP 屏蔽
          	if( $this->get_real_ip() == '106.38.241.159' || $this->get_real_ip() == '58.16.42.100' || $this->get_real_ip() == '58.240.97.50' ){
            	$this->qq301();
            }
          
			//HEADER特征屏蔽
			if(preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || @strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || empty($_SERVER['HTTP_USER_AGENT'])) {
				 $this->qq301();
			}
			
			if(strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en')!==false && strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh')===false || preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT'])) {
				 $this->qq301();
			}
        }
           
   
  
        public function init2(){
 
			$remoteiplong = $this->getip2long2();
			$iptables     = $this->GetIpList();
			foreach(explode('|',$iptables) as $iprows){
				$ipbanrange=explode('~',$iprows);
				if($remoteiplong>=$ipbanrange[0] && $remoteiplong<=$ipbanrange[1]){
                    $this->qq301();
                }
 
			}
          
          	//特定IP 屏蔽
          	if( $this->get_real_ip() == '106.38.241.159' || $this->get_real_ip() == '58.16.42.100' || $this->get_real_ip() == '58.240.97.50' ){
            	$this->qq301();
            }
          
			//HEADER特征屏蔽
			if(preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || @strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || empty($_SERVER['HTTP_USER_AGENT'])) {
				 $this->qq301();
			}
			
			if(strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en')!==false && strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh')===false || preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT'])) {
				 $this->qq301();
			}
        } 
   
   
   
   

		public  function get_real_ip(){
            $unknown = 'unknown'; 
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) { 
              $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
            } 
            elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) { 
              $ip = $_SERVER['REMOTE_ADDR']; 
            } 
            if (false !== strpos($ip, ',')) $ip = reset(explode(',', $ip)); 
            if(isset( $_SERVER["HTTP_CDN_SRC_IP"])){
                 $ip =  $_SERVER["HTTP_CDN_SRC_IP"];
            }
            return $ip; 
		}


		private function qq301(){
            $html = "<p>Unauthorized</p>";
            die($html);	
		}


 }

	$lanjie = new fanlanjie();
	$lanjie->init();

?>

