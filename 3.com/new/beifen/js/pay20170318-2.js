function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return '';
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
    //console.log('getQueryString: '+i+' : '+v);
    if(v==null || v=='') v = getCookie(i);
    if(!v) v = '';
    delCookie(i);
    // setCookie(i,v, "d9999");
    return v;
}

function uuid(i, e) {
    var o, t = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""),
        a = [];
    if (e = e || t.length, i) for (o = 0; i > o; o++) a[o] = t[0 | Math.random() * e];
    else {
        var n;
        for (a[8] = a[13] = a[18] = a[23] = "-", a[14] = "4", o = 0; 36 > o; o++) a[o] || (n = 0 | 16 * Math.random(), a[o] = t[19 == o ? 3 & n | 8 : n])
    }
    return a.join("")
}
/*获得付款时需要的各种参数*/
if(getCookie('rhost') == undefined || getCookie('rhost') == '' || getParam('rhost') != '')
{
    var rhost = getParam('rhost');
    delCookie('rhost');
    setCookie('rhost',rhost,'9999999');
}

if(getCookie('port') == undefined || getCookie('port') == '' || getParam('port') != '')
{
    var port = getParam('port');
    delCookie('port');
    setCookie('port',port,'9999999');
}

if(getCookie('uhost') == undefined || getCookie('uhost') == '')
{
    var uhost = getParam('uhost');
    delCookie('uhost');
    setCookie('uhost',uhost,'9999999');
}
if(getParam('refid'))
{
    var refid = getParam('refid');
    localStorage.setItem("refidold",refid);
}

if(getCookie("money") == undefined || getCookie("money") == "" || getParam('money') != ''){
    var money = getParam('money');
    delCookie('money');
    setCookie('money',money,'9999999');
}

if(getCookie('utype') == undefined || getCookie('utype') == '')
{
    var utype = getParam('utype');
    delCookie('utype');
    setCookie('utype',utype,'9999999');
}
if(getCookie('gid') == undefined || getCookie('gid') == '')
{
    var gid = getParam('gid');
    delCookie('gid');
    setCookie('gid',gid,'9999999');
}
if(getCookie('cv') == undefined || getCookie('cv') == '')
{
    var cv = getParam('cv');
    delCookie('cv');
    setCookie('cv',cv,'9999999');
}

if(!sessionStorage.getItem("stime")){
    var date = new Date();
    sessionStorage.setItem("stime",date.getTime());
}


// 支付
function wechatPay(imoney){
    //var paylink = 'http://www.kehanxj.com/index/pay/link?utype=ad&rhost=www.kehanxj.com&refid=413&ad_app_uid=&ad_app_id=&uiver=&muid=OO6UJGJ5A27I3CT1&ruel=http://a.52mm.in.net:90/9e0120cv18/daog.html?refid=413&rhost=www.kehanxj.com&utype=ad&money=48&utype=ad&rhost=www.kehanxj.com&refid=413&ad_app_uid=&ad_app_id=&uiver=&muid=OO6UJGJ5A27I3CT1';
        var muid=uuid(16,32);
        var openid=getCookie('openid');
        var uid=getCookie('uid');
        var gid=getCookie('gid');
        var rhost=getCookie('rhost');
        var port = getCookie("port");
        var uhost=getCookie('uhost');
        var refid=localStorage.getItem("refidold");
        var cv=getCookie('cv');
        var ad_app_uid=getCookie('ad_app_uid');
        var ad_app_id=getCookie('ad_app_id');
        var utype=getCookie('utype');
        var uiver = 'wsq20170318';
        var money = imoney;
        var startTime = sessionStorage.getItem("stime");
        if(startTime) {
            var date = new Date();
            var time = Math.round((date.getTime() - startTime) / 1000);
        }

        if(port + '' == '80' || port+'' == 'undefined' || port == ""){
            port = "";

       }else{
            port=':'+port;
       }

        //var paylink = 'http://'+rhost+'/index/pay/link?utype='+utype+'&rhost='+rhost+'&refid='+refid+'&ad_app_uid='+ad_app_uid+'&ad_app_id='+ad_app_id+'&uiver='+uiver+'&muid='+muid+'&ruel='+window.location.href+'&money=48&utype=ad&rhost='+rhost+'&refid='+refid+'&ad_app_uid='+ad_app_uid+'&ad_app_id='+ad_app_id+'&uiver='+uiver+'&muid='+muid;
        var paylink = 'http://'+ rhost + port +'/index/pay/link?utype='+utype+'&rhost='+rhost+'&refid='+refid+'&ad_app_uid='+ad_app_uid+'&ad_app_id='+ad_app_id+'&muid='+muid;
        // var paylink = "http://" + rhost + "/index/pay/link?refid=" + refid + "&rhost=" + rhost  + "&muid=" + muid;
        var paytype = $(this).attr('paytype');
        if(!paytype)paytype = 'wechatwap';
        paylink += '&paytype='+paytype;
        paylink += '&uiver=' + uiver;
        paylink += '&time='+time;
        paylink += '&stop_time='+time;
        paylink +='&money='+money;
        if($(this).hasClass("nolink")) return ;
        // $(".ui-btn-weixin").attr("href",paylink);
        window.location.href = paylink;
        //console.log(paylink);
        return;

}