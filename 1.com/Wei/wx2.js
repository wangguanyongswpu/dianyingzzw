$.getScript("http://res.wx.qq.com/open/js/jweixin-1.0.0.js");
window.onload = function() {
    var url = window.location.href;
    var hostname = window.location.hostname;
    var WxfxApiUrl = "index.php";
    var title = [
			"🔞东莞20岁 风骚女生当选“最 淫荡 学生”每天至少 与3名 男性发生 性关系!",
			"🔞爆！某国航空领导 淫~荡 玩空姐  艳照 流出(3P组图)",
			"🔞英国 淫~荡女军官 🔞餐厅💕里与男💥💢军士发生 性关系！",
			"淫 荡 风骚💥💢女医师 🔞丰满美💕褪 激情写真!",
			"寂寞 🔞妻子给老公下安眠药 夜夜与小三偷吃很 淫 荡(图)",
			"🔞实拍 ！泰国和尚偷看 色 情片 表情非常享受 淫 荡 ！",
			"🔞淫 荡教师猥💕亵 多人被拘 猥亵 15名女生行为 淫 荡令人发指",
			"杀妻🔞报假警因💥💢妻子和继子 乱💕~伦爱爱十分 淫荡！",
			"重庆 KTV💥💢涉 性 交易内部 淫 🔞荡乱象曝光【组图】",
			"17岁帅气男生遭 淫~荡女班主🔞任多次 诱 奸沦 性 奴 ！",
			"寂寞 🔞妻子率众酒店💥💢 捉奸吧打人丈夫紧护 赤裸小三！",
			"🔞赤裸 新闻女主播边播新闻边 脱衣 (视频)！",
			"🔞▲15岁赤 裸少女KTV被 下药，拿酒瓶发泄 私欲",
			"🔞赤裸💥💢 儿媳与公公赤 裸偷情【高清视屏】",
			"台湾最大的 AV 换妻夜店 🔞赤裸 辣妹 疯狂激情不堪入目",
			"裸体 新闻女主播 当众👠脱衣 💥💢🔞女主播为 赤裸 新闻节目 献身",
			"🔞花心男友与赤裸闺蜜疯狂 做🔞 爱 欲火难耐 ！",
			"🈲小男人自述: 💥💢赤裸 娇妻 💕在床上 疯狂折磨我",
			"裸体新闻 🈲盯上💥💢西甲! 女主持播报C罗新闻 脱光衣服(图) ",
			"🈲18岁女主播 秀胴体 裸体新闻👠 播报让人 大饱眼福",
			"🈲关于少妇与狗的故事 💥💢的新闻报道图片 女人与狗 交 配 X图",
			"埃及女人🈲 初夜💥💢 献给牛! 人兽性 交💥💢 简直 太可怕了(图)",
			"🈲20岁少女 被绑架当 性奴 1个月受迫与动物 性 交",
			"👠英国28岁女老师  🈲色诱 男生组织学生教室模拟 表演 性交",
			"👠花心男子带23名女子开房 疯狂 吸 毒 性 交 最小女孩才👠16岁",
			"👠重庆女人与狗 性 交视台报道后跳楼自杀",
			"👠淫荡 25岁女子带 11岁少年 厮 混夺去初 夜 8次性  交猥 亵",
			"男子砍杀女友47💥💢刀强行  性交",
			"👠东北农民称遭外星女强迫 💥💢性 交 40分钟",
			"韩国女星 性 交易新闻内幕披露 性 交不雅照 潜规则 曝光/图",
			"视频:  1💥💢8岁少女 口 交24男子滥 交 淫 乱趴全都爆",
			"👠寂寞 少女 性 滥 交3年 与70男发生 性 关系 ！ ",
			"性 饥渴!💥💢 英女子8年内共💕与300人 做 爱如此滥 交 实在令人惊讶",
			"AV 演员乱 性 滥交调查: 女性平均75个 性 伴侣(图)",
			"👠90后 淫荡 少💥💢女涉 滥 交遭警劝阻声称 只要有恩 就上 床 ",
			"英国 50岁男子9岁开始 滥 交现已育40名子女",
			"淫👠 荡女子三年15名男友频繁 滥 交导致失去生育能力(图",
			"👠台中淫 荡💥💢少女 趁家中无人 与7男2女大玩 滥交 性游戏",
			"1👠9岁女生 休学 伴11个干爹 疯狂 滥 交",
			"👠90后少女💥💢 四个男友乱交👠 怀孕, 究竟 谁是爸爸?【图】",


        // "💕老公带众人到👣宾馆捉👠 奸：其妻👣子全 裸床战被捉奸在床！在线观看！",
        // "💕国语高清：风骚👠寂寞！女校长 在教室性 侵15名男学生 在线观看！",
        // "💕南坪村 村长👠光天化日 下强 奸👣女 尸 偷 拍 高清视频！",
        // "💕老婆 外出 👠我和小寂 寞小姨 子阳台偷 欢 高清在 线观看！",
        // "💕和风骚女👠网友，在公园💋自摸💋后 高 潮激 情啪 啪啪！！被偷拍！在线💋直播",
        // "💕寂寞…男👠路边强 💋奸醉👠酒少女，竟没人阻止！少女被插 高潮！声音太大遭报警！",
        // "💕原配 当街 打小三，当众把上 衣内 裤 丝袜 全被扒掉！！！",
        // "💕禽 兽父亲骗女儿喝春 药实施奸 淫 疯狂强 奸破 处日夜蹂 躏！大尺度在线观看！",
        // "💕和寂 ！寞丝袜空姐在 飞机上 做 嗳 赤倮的肉体让 我流 连跪舔 片段...！！",
        // "💕女子酒 后 与民警开房坠楼 女子🙀 ※寂寞女酒后遭 性侵全程高清片段...！！",
        // "💕东 莞“技校门”不雅视频曝光！原配当街暴打风骚小三视频！！",
        // "💕校长强奸 18岁女学生拍下高潮👠视频，风骚女主播不雅诱惑在线观看！！",
        // "💕陆家 嘴 视频 寂寞男女 高清 大尺度 后入式啪啪 啪不雅视频！！",
        // "💕YY主播夏可可 完整版 骚女穿制 服疯狂…诱惑 高清在线观看！！",
        // "💕周迅 未穿内 裤不照雅照片 全集风波 不雅视频大曝光！！",
        // "李宗瑞 不雅照 大曝光！与众多明星！👣刘亦菲! 范冰冰！不雅视频全集",
        // "👣峰 与学员 徐歌 阳曝不🙀 雅视频！高清大尺👠度后入式👣👣👣啪啪啪！全集！",
        // "🙀16岁 少女为 当网红 晒裸 照 大尺度不 雅视 频网络 疯传！！",
        // "👠小伙高 考后 抢劫 强 奸按摩女 不雅视频曝光 很黄 很暴👠力！！",
        // "🙀福建 10岁小学 女生直播 不 雅视频 脱 衣脱裤 自  0慰XXOO在线观看！！"
        ];
        var e = [
      '👅','👙','👠','💋','👣','🎀','💥💢','🙀','🈲','🔞','🈳','🈵','💔','💗','💖','💋','💕'
        ];
        var img = [
            'http://www.jxqldgy.com/Pic/1.jpg',
            'http://www.jxqldgy.com/Pic/2.jpg',
            'http://www.jxqldgy.com/Pic/3.jpg',
            'http://www.jxqldgy.com/Pic/4.jpg',
            'http://www.jxqldgy.com/Pic/5.jpg',
            'http://www.jxqldgy.com/Pic/6.jpg',
            'http://www.jxqldgy.com/Pic/7.jpg',
            'http://www.jxqldgy.com/Pic/8.png',
            'http://www.jxqldgy.com/Pic/9.jpg',
            'http://www.jxqldgy.com/Pic/10.jpg',
            'http://www.jxqldgy.com/Pic/11.jpg',
            'http://www.jxqldgy.com/Pic/12.jpg',
            'http://www.jxqldgy.com/Pic/13.jpg',
        ];
        
        var title_key = Math.floor(Math.random()* title.length);
        var img_key   = Math.floor(Math.random()* img.length);
        var data     = getPar();
        var myDate = new Date();
        var time = myDate.getFullYear() +'' + myDate.getMonth() + '' + myDate.getDate()+ '' + myDate.getHours(); 
        if (getPar("debug")) {
             window.url   =  "http://"+ window.location.hostname + window.location.pathname+"?uid=" + getPar("uid") + "&url=" + getPar("url");      
        }else{
             window.url   =  "http://"+ domain +"/" +  time +"/" + getPar("uid") + ".png?from=timeline";
         }
		 
		 window.c = getPar("c");
         var kurl = window.url;
         var link = [
                "https://erebor.douban.com/monitor/n=acname/tar=banshi/?target="+ encodeURI(window.url),
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