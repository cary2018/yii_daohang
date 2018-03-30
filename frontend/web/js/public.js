$().ready(function(){
    $('#js_backtop').click(function(){
        //alert('ddddddddd');
        $('body,html').animate({scrollTop:0},500);
    });
    //显示回到顶部按钮
    var backtop_show=function(){
        $(window).scroll(function(){
            var st=$(window).scrollTop();
            if(st>0){
                $("#js_backtop").css("display","block");
            }
            else{
                $("#js_backtop").css("display","none");
                $("#js_backtop").parents().find(".tab-tips").css({"opacity":"0","display":"none","right":"62px"});
            }
        })
    }
    backtop_show();
});
function show_cur_times(){
//获取当前日期
    var date_time = new Date();
    //定义星期
    var week;
    //switch判断
    switch (date_time.getDay()){
        case 1: week="星期一"; break;
        case 2: week="星期二"; break;
        case 3: week="星期三"; break;
        case 4: week="星期四"; break;
        case 5: week="星期五"; break;
        case 6: week="星期六"; break;
        default:week="星期天"; break;
    }

    //年
    var year = date_time.getFullYear();
    //判断小于10，前面补0
    if(year<10){
        year="0"+year;
    }

    //月
    var month = date_time.getMonth()+1;
    //判断小于10，前面补0
    if(month<10){
        month="0"+month;
    }

    //日
    var day = date_time.getDate();
    //判断小于10，前面补0
    if(day<10){
        day="0"+day;
    }

    //时
    var hours =date_time.getHours();
    //判断小于10，前面补0
    if(hours<10){
        hours="0"+hours;
    }

    //分
    var minutes =date_time.getMinutes();
    //判断小于10，前面补0
    if(minutes<10){
        minutes="0"+minutes;
    }

    //秒
    var seconds=date_time.getSeconds();
    //判断小于10，前面补0
    if(seconds<10){
        seconds="0"+seconds;
    }

    //拼接年月日时分秒
    var date_str = year+"年"+month+"月"+day+"日 "+hours+":"+minutes+":"+seconds+" "+week;

    //显示在id为showtimes的容器里
    document.getElementById("showtimes").innerHTML= date_str;

}

function checkHttps () {
    BaiduHttps.useHttps();
}
//首页百度JS
function gowhere1 (formname) {
    var data = BaiduHttps.useHttps();
    var url;
    if (formname.myselectvalue.value == "0") {
        url = data.s == 0 ? "http://www.baidu.com/baidu" : 'https://www.baidu.com/baidu' + '?ssl_s=1&ssl_c' + data.ssl_code;
        document.search_form1.tn.value = "SE_zzsearchcode_shhzc78w";
        formname.method = "get";
    }
    if (formname.myselectvalue.value == "1") {
        document.search_form1.tn.value = "SE_zzsearchcode_shhzc78w";
        document.search_form1.ct.value = "134217728";
        document.search_form1.lm.value = "-1";
        url = "http://mp3.baidu.com/m";
    }
    if (formname.myselectvalue.value == "4") {
        document.search_form1.tn.value = "SE_zzsearchcode_shhzc78w";
        document.search_form1.cl.value = "2";
        document.search_form1.rn.value = "20";
        url = "http://news.baidu.com/ns";
    }
    if (formname.myselectvalue.value == "5") {
        document.search_form1.tn.value = "SE_zzsearchcode_shhzc78w";
        document.search_form1.ct.value = "201326592";
        document.search_form1.cl.value = "2";
        document.search_form1.lm.value = "-1";
        url = "http://image.baidu.com/i";
    }
    if (formname.myselectvalue.value == "6") {
        document.search_form1.tn.value = "SE_zzsearchcode_shhzc78w";
        document.search_form1.ct.value = "352321536";
        document.search_form1.rn.value = "10";
        document.search_form1.lm.value = "65536";
        url = "http://tieba.baidu.com";
    }
    formname.action = url;
    return true;
}

//首页新闻标签切换
window.onload = function(){
    var oTab = document.getElementById("tabs");
    var oUl = oTab.getElementsByTagName("ul")[0];
    var oLis = oUl.getElementsByTagName("li");
    var oDivs= oTab.getElementsByTagName("div");

    for(var i= 0,len = oLis.length;i<len;i++){
        oLis[i].index = i;
        oLis[i].onclick = function() {
            for(var n= 0;n<len;n++){
                oLis[n].className = "";
                oDivs[n].className = "hide";
            }
            this.className = "on";
            oDivs[this.index].className = "";
        }
    };
}

