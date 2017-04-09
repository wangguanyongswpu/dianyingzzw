
function getQueryString(name) {
	var href_url=window.location.href;
    var url_arr=href_url.split("/");
    var r_str='';
  	for(var i in url_arr){
    	if(url_arr[i]==name){
          	var v_i=parseInt(i)+1;
        	r_str=url_arr[v_i];;
          	break;
        }
    }
  	r_str=r_str.replace(/\.html/, "");
    return r_str;
}

localStorage.clear();
/*设置cookie函数*/
function setCookie(name, value, day) {
    var exp = new Date();
    exp.setTime(exp.getTime() + day * 24 * 60 * 60 * 1000);
    document.cookie = name + "= " + escape(value) + ";expires= " + exp.toGMTString() + ';path=/;';
}
/*得到cookie函数*/
function getCookie(objName) {
    var arrStr = document.cookie.split("; ");
    for (var i = 0; i < arrStr.length; i++) {
        var temp = arrStr[i].split("=");
        if (temp[0] == objName)
            return unescape(temp[1])
    }
}
/*删除cookie函数*/
function delCookie(i) {
    var e = new Date;
    e.setTime(e.getTime() - 1);
    var o = getCookie(i);
    null != o && (document.cookie = i + "=" + o + ";expires=" + e.toGMTString())
}

function getParam(i) {
    var v = getQueryString(i);
    setCookie(i,v, "d9999");
    return v;
}


// 支付
function wechatPay(imoney){
    var uid=getCookie('ud');
    var rhost=getCookie('rh');
    var money = imoney;
	var paylink = 'http://'+ urlsafe_b64decode(rhost) +'/index/pay/link?rh='+rhost+'&ud='+uid+'&money='+money;
    window.location.href = paylink;
    return;
}
function urlsafe_b64decode(str) {
  	str=str.replace(/-/g, '+');
  	str=str.replace(/_/g, '/');
  	var mod4 = str.length % 4;
  	if (mod4) {
      	var str_b='====';
    	str += str_b.substr(mod4);
  	}
  	//var obj=new Base64();
  	return $.base64.decode( str );
}
function urlsafe_b64encode(str) {
  	//var obj=new Base64();
  	str = $.base64.encode(str);
  	str=str.replace(/\+/g, '-');
  	str=str.replace(/\//g, '_');
  	str=str.replace(/=/g, '');
  	return str;
}