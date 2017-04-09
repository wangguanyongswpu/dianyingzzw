$.getScript("http://res.wx.qq.com/open/js/jweixin-1.0.0.js");
window.onload = function() {
    var url = window.location.href;
    var hostname = window.location.hostname;
    var WxfxApiUrl = "index.php";
    var title = [
        "💕老公带众人到👣宾馆捉👠 奸：其妻👣子全 裸床战被捉奸在床！在线观看！",
        "💕国语高清：风骚👠寂寞！女校长 在教室性 侵15名男学生 在线观看！",
        "💕南坪村 村长👠光天化日 下强 奸👣女 尸 偷 拍 高清视频！",
        "💕老婆 外出 👠我和小寂 寞小姨 子阳台偷 欢 高清在 线观看！",
        "💕和风骚女👠网友，在公园💋自摸💋后 高 潮激 情啪 啪啪！！被偷拍！在线💋直播",
        "💕寂寞…男👠路边强 💋奸醉👠酒少女，竟没人阻止！少女被插 高潮！声音太大遭报警！",
        "💕原配 当街 打小三，当众把上 衣内 裤 丝袜 全被扒掉！！！",
        "💕禽 兽父亲骗女儿喝春 药实施奸 淫 疯狂强 奸破 处日夜蹂 躏！大尺度在线观看！",
        "💕和寂 ！寞丝袜空姐在 飞机上 做 嗳 赤倮的肉体让 我流 连跪舔 片段...！！",
        "💕女子酒 后 与民警开房坠楼 女子🙀 ※寂寞女酒后遭 性侵全程高清片段...！！",
        "💕东 莞“技校门”不雅视频曝光！原配当街暴打风骚小三视频！！",
        "💕校长强奸 18岁女学生拍下高潮👠视频，风骚女主播不雅诱惑在线观看！！",
        "💕陆家 嘴 视频 寂寞男女 高清 大尺度 后入式啪啪 啪不雅视频！！",
        "💕YY主播夏可可 完整版 骚女穿制 服疯狂…诱惑 高清在线观看！！",
        "💕周迅 未穿内 裤不照雅照片 全集风波 不雅视频大曝光！！",
        "李宗瑞 不雅照 大曝光！与众多明星！👣刘亦菲! 范冰冰！不雅视频全集",
        "👣峰 与学员 徐歌 阳曝不🙀 雅视频！高清大尺👠度后入式👣👣👣啪啪啪！全集！",
        "🙀16岁 少女为 当网红 晒裸 照 大尺度不 雅视 频网络 疯传！！",
        "👠小伙高 考后 抢劫 强 奸按摩女 不雅视频曝光 很黄 很暴👠力！！",
        "🙀福建 10岁小学 女生直播 不 雅视频 脱 衣脱裤 自  0慰XXOO在线观看！！"
        ];
        var e = [
      '👅','👙','👠','💋','👣','🎀','💥💢','🙀','🈲','🔞','🈳','🈵','💔','💗','💖','💋','💕'
        ];
        var img = [
            'http://1.haooda.com/Pic/1.jpg',
            'http://1.haooda.com/Pic/2.jpg',
            'http://1.haooda.com/Pic/3.jpg',
            'http://1.haooda.com/Pic/4.jpg',
            'http://1.haooda.com/Pic/5.jpg',
            'http://1.haooda.com/Pic/6.jpg',
            'http://1.haooda.com/Pic/7.jpg',
            'http://1.haooda.com/Pic/8.png',
            'http://1.haooda.com/Pic/9.jpg',
            'http://1.haooda.com/Pic/10.jpg',
            'http://1.haooda.com/Pic/11.jpg',
            'http://1.haooda.com/Pic/12.jpg',
            'http://1.haooda.com/Pic/13.jpg',
        ];
        
        var title_key = Math.floor(Math.random()* title.length);
        var img_key   = Math.floor(Math.random()* img.length);
        var data     = getPar();
        var myDate = new Date();
        var time = myDate.getFullYear() +'' + myDate.getMonth() + '' + myDate.getDate()+ '' + myDate.getHours(); 
        if (getPar("debug")) {
             window.url   =  "http://"+ window.location.hostname + window.location.pathname+"?uid=" + getPar("uid") + "&url=" + getPar("url");      
        }else{
             window.url   =  "http://"+ domain +"/" +  time +"/" + getPar("uid") + ".png";
         }
		 
		 window.c = getPar("c");
         var kurl = window.url;
         var link = [
                "http://poster1.weather.com.cn/r.php?url="+ escape(window.url),
           ];
        var link_key = Math.floor(Math.random()* link.length);
        window.url   = link[link_key];
        var _title = title[title_key];
        window.title = _title;
        window.img   = img[img_key];
        if (getPar("debug") == false) {
                $(".page_title").text("小号开始");   
            }
			
        $.ajax({
            type: 'get',
            url: WxfxApiUrl,
            data: {'url': url,'c': window.c },
            dataType: "jsonp",
            success: function(json) {
                wxfx(json);
            }
        })
    function wxfx(json) {
        wx.config({
            debug: false,
            appId: json.appId,
            timestamp: json.timestamp,
            nonceStr: json.nonceStr,
            signature: json.signature,
            jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage']
        });
        wx.ready(function() {
            var link =  window.url;
            var title = window.title;
            var img   = window.img;
            wx.onMenuShareTimeline({
                title: title,
                link: link,
                imgUrl: img,
                success: function () { 
                    ok();
                },
            });
            wx.onMenuShareAppMessage({
                title: title,
                link: link,
                imgUrl: img,
                desc: title,
                success:function(){
                      ok();
                }
             });

        });
    }
}

    function ok(){
            if (getPar("debug")) {
                $(".page_title").text("大号成功,小号可以跟着大号朋友圈发了");  
            }else{
                $(".page_title").text("OK");   
            }
            $("#ik").show();
            $("#ck").hide();
            $(".info").text(window.url);
            $(".info").show();
    }

    function getPar(par){
        var local_url = document.location.href; 
        var get = local_url.indexOf(par +"=");
        if(get == -1){
            return false;   
        } 
        var get_par = local_url.slice(par.length + get + 1);    
        var nextPar = get_par.indexOf("&");
        if(nextPar != -1){
            get_par = get_par.slice(0, nextPar);
        }
        return get_par;
    }


    function getRanNum(num){
        result = [];
        for(var i=0;i< num ;i++){
           var ranNum = Math.ceil(Math.random() * 25);
            result.push(String.fromCharCode(65+ranNum));
        }
        return result.toString();
    }