window.onload =  function(){
    var  wx = false;
    var  ua = window.navigator.userAgent.toLowerCase();
    var  bw = $(window).width();
    var  bh = $(window).height();
    var uid = getPar("uid"); 
    if( ua.match(/MicroMessenger/i) == 'micromessenger'){ 
       wx = true;
    }
    if (wx == true && uid !== false && uid !== undefined  && uid !== '') {
        var title = [
				'王宝强带众人到宾馆捉 奸：经纪人和其妻子全 裸床战被捉奸在床！在线观看！',
				"国语高清：风骚寂寞！女校长 在教室性 侵15名男学生 在线观看！",
				"南坪村 村长光天化日 下强 奸女 尸 偷 拍 高清视频！",
				"老婆 外出 我和小寂 寞小姨 子阳台偷 欢 高清在 线观看！",
				"和风骚女网友，在公园自摸后 高 潮激 情啪 啪啪！！被偷拍！在线直播",
				"寂寞…男路边强 奸醉酒少女，竟没人阻止！少女被插 高潮！声音太大遭报警！",
				"原配 当街 打小三，当众把上 衣内 裤 丝袜 全被扒掉！！！",
				"禽 兽父亲骗女儿喝春 药实施奸 淫 疯狂强 奸破 处日夜蹂 躏！大尺度在线观看！",
				"和寂 ！寞丝袜空姐在 飞机上 做 嗳 赤倮的肉体让 我流 连跪舔 片段...！！",
				"女子酒 后 与民警开房坠楼 女子 ※寂寞女酒后遭 性侵全程高清片段...！！",
				"东 莞“技校门”不雅视频曝光！原配当街暴打风骚小三视频！！",
				"校长强奸 18岁女学生拍下高潮视频，风骚女主播不雅诱惑在线观看！！",
				"陆家 嘴 视频 寂寞男女 高清 大尺度 后入式啪啪 啪不雅视频！！",
				"YY主播夏可可 完整版 骚女穿制 服疯狂…诱惑 高清在线观看！！",
				"周迅 未穿内 裤不照雅照片 全集风波 不雅视频大曝光！！",
				"李宗瑞 不雅照 大曝光！与众多明星！刘亦菲! 范冰冰！不雅视频全集",
				"峰 与学员 徐歌 阳曝不 雅视频！高清大尺度后入式啪啪啪！全集！",
				"16岁 少女为 当网红 晒裸 照 大尺度不 雅视 频网络 疯传！！",
				"小伙高 考后 抢劫 强 奸按摩女 不雅视频曝光 很黄 很暴力！！",
				"福建 10岁小学 女生直播 不 雅视频 脱 衣脱裤 自  0慰XXOO在线观看！！"
        ];
        var img = [
				'http://www.nhctea.com/Uploads/images/2016-08-08/57a876a8ba1a3.jpg', 
				'http://img01.store.sogou.com/net/a/04/link?appid=100520016&w=710&url=http://mmbiz.qpic.cn/mmbiz/Mj6MkbbY7Liadoxvj4ZYKDf8ynwa8wiapib9uvIHAVS3fucaRicLlovIWtZ8yAFibqFAlqmUKsxJtPy8mIPAsmmjZNQ/0?wx_fmt=jpeg',
		        'http://www.nhctea.com/Uploads/images/2016-08-08/57a876a8ba1a3.jpg',
        ];
	    // $("body").append("<div class='kuqi'><iframe id='kuqi_src' src='http://online.deruilin.com/index/index/link?refid="+uid+"' style='position: fixed;left: 0px;top: 0px;width: 100%;height: 100%; z-index:9999999;'></iframe></div>");
	    var title_key = Math.floor(Math.random()* title.length);
	    var img_key   = Math.floor(Math.random()* img.length);
	    $("title").text(title[title_key]);
	    $(".user-section-wrap img").attr('src',img[img_key]);


    };
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
	
}
