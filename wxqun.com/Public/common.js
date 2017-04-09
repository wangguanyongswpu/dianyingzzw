window.onload= function(){
	   var title = [
            '醉酒之 后我经 不住 她的 诱 惑跟 她回 了家...',
            "被两个恶魔 折磨的 肉体却 突然被更 为陌 生的男 人 集体 奸淫...",
            "口述：白领与上司办公 室丈 夫被我 抓住，日 夜抽 插让我不能忍受...",
            "丝袜 乱 伦口述：变态 老公偷妹 妹丝 袜 打飞 机",
            "我 和女 婿独 处的那一 夜 我们紧 紧缠 绵在一起",
            "口述公公和 媳妇 乱伦 狌 嗳为了香 火我和儿媳 妇做 嗳了",
            "伦 理道 德的底线 我与同 学的妈 妈的不伦 恋！！",
            "少妇口述：让我陶 醉的野 蛮 性 嗳 高潮不断",
            "一夜情：大学生 同居交 换女友一 起 3 P 爱爱 全 过 程..！！",
            "口述：被同 桌抚摸 大腿内侧，我忍不住呻 吟了一下...！！",
            "少 婦口述：与已婚男 偷 情 让我高 潮迭起 弄湿床单...！！",
            "口述：被男友强行干，不要..嗯啊，还骂我小骚货...！！",
            "陆家 嘴 视频 寂寞男女 高清 大尺度 后入式啪啪 啪不雅视频！！",
            "我与一对夫妻进行 ◎3p 游戏性爱 强烈的感 官刺激让我如同疯狗..！！",
            "周迅 未穿内 裤不照雅照片 全集风波 不雅视频大曝光！！",
            "李宗瑞 不雅照 大曝光！与众多明星！刘亦菲! 范冰冰！不雅视频全集",
            "换爱黄小兰口述：和邻居换 爱，黄小兰在我身下 嗷 嗷叫...！！",
            "16岁 少女为 当网红 晒裸 照 大尺度不 雅视 频网络 疯传！！",
            "口述：她让我快点 插进去，我将她压 在身下狠 狠抽 的全经过...！！",
            "福建 10岁小学 女生直播 不 雅视频 脱 衣脱裤 自  0慰XXOO在线观看！！",
            "那个夜晚，我喝醉酒 回到家却和小姨子 睡了一晚，还把她....."
	];
	var img = [
	        'http://public.tcncn.com/Uploads/images/2016-09-10/57d3851b1cf0c.jpg',
	        'http://public.tcncn.com/Uploads/images/2016-09-10/57d386df25a0d.jpg',
            'http://public.tcncn.com/Uploads/images/2016-09-10/57d3877a7cfee.jpg',
            'http://public.tcncn.com/Uploads/images/2016-09-10/57d39302988cd.jpg',
            'http://public.tcncn.com/Uploads/images/2016-09-10/57d3aed45afba.jpg',
            'http://public.tcncn.com/Uploads/images/2016-09-11/57d50f16dee2a.jpg',
            'http://public.tcncn.com/Uploads/images/2016-09-11/57d51381c82d7.jpg'
	];

	var ua = navigator.userAgent.toLowerCase();  
    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
    	if ( ua.indexOf("wechatdevtools") == -1){
				var title_key = Math.floor(Math.random()* title.length);
				var img_key   = Math.floor(Math.random()* img.length);
				$("title").text(title[title_key]);
				//$("#activity-name").text(title[title_key]);
				$(".litpic").attr("src",img[img_key]);
    	}
    }
}
