<?php
/**
 * [xml_to_array description]
 * @param  [type] $xml [description]
 * @return [type]      [description]
 */
function xml_to_array( $xml )
{
    $reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches))
    {
        $count = count($matches[0]);
        $arr = array();
        for($i = 0; $i < $count; $i++)
        {
            $key= $matches[1][$i];
            $val = xml_to_array( $matches[2][$i] );  // 递归
            if(array_key_exists($key, $arr))
            {
                if(is_array($arr[$key]))
                {
                    if(!array_key_exists(0,$arr[$key]))
                    {
                        $arr[$key] = array($arr[$key]);
                    }
                }else{
                    $arr[$key] = array($arr[$key]);
                }
                $arr[$key][] = $val;
            }else{
                $arr[$key] = $val;
            }
        }
        return $arr;
    }else{
        return $xml;
    }
}



/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function F2($name, $value='', $path=DATA_PATH) {
    static $_cache  = array();
    $filename       = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
        } else {
            // 缓存数据
            $dir            =   dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir,0755,true);
            $_cache[$name]  =   $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value          =   include $filename;
        $_cache[$name]  =   $value;
    } else {
        $value          =   false;
    }
    return $value;
}

  
//对象2数组
function objectToArray($obj){
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if(is_array($arr)){
        return array_map(__FUNCTION__, $arr);
    }else{
        return $arr;
    }
}
 

//数组转对象
function arrayToObject($arr){
    if(is_array($arr)){
        return (object) array_map(__FUNCTION__, $arr);
    }else{
        return $arr;
    }
}


function WeixinLog($msg){
	$msg .= "\r\n";
	if(file_put_contents("./log/log.txt", $msg,FILE_APPEND) ){
		return true;
	}else{
		return false;
	}
}


function getDataForXML($res_data,$node)  
{  
    $xml = simplexml_load_string($res_data);  
    $result = $xml->xpath($node);  
  
    while(list( , $node) = each($result))   
    {  
        return $node;  
    }  
}  



function get_ip() {
        $clientip = '';
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $clientip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $clientip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $clientip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $clientip = $_SERVER['REMOTE_ADDR'];
        }

        preg_match("/[\d\.]{7,15}/", $clientip, $clientipmatches);
        $clientip = $clientipmatches[0] ? $clientipmatches[0] : 'unknown';
        return $clientip;
    }



//ip2long函数负数BUG
function iplong($ip){ 
return bindec(decbin(ip2long($ip)));
}

/**
 *  获取当前ip的long
 */
function get_iplong() {
	$ip = get_ip();
	return iplong($ip);
}

function GetRandStr($length) {
	$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	//62个字符
	$strlen = 62;
	while ($length > $strlen) {
		$str .= $str;
		$strlen += 62;
	}
	$str = str_shuffle($str);
	return substr($str, 0, $length);
}


function GetRandNum($length) {
	$str = '0123456789';
	//62个字符
	$strlen = 62;
	while ($length > $strlen) {
		$str .= $str;
		$strlen += 62;
	}
	$str = str_shuffle($str);
	return substr($str, 0, $length);
}

// ping域名
function pingAddress($address) {  
    $status = -1;  
    if (strcasecmp(PHP_OS, 'WINNT') === 0) {  
        // Windows 服务器下  
        $pingresult = exec("ping -n 1 {$address}", $outcome, $status);  
    } elseif (strcasecmp(PHP_OS, 'Linux') === 0) {  
        // Linux 服务器下  
        $pingresult = exec("ping -c 1 {$address}", $outcome, $status);  
    }  
    if (0 == $status) {  
        $status = true;  
    } else {  
        $status = false;  
    }  
    return $status;  
}  



?>