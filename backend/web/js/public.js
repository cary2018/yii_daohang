$(document).ready(function(){
    //更新导航列表排序
    $(".ordy").click(function(){
        var ord = $(this);
        var uid = ord.attr('id');
        var oval = ord.text();
        var input = $("<input type=text name=\"order\" size=\"6\" maxlength='5' class=\"foc\" value='"+oval+"' />");
        //添加input
        ord.html(input);
        //选中内容
        input.trigger('select');
        //在input在点击无效
        input.click(function(){return false;});
        //光标离开 input 后进行更新相关操作
        input.blur(function(){
            var tex = $(this).val();
            if(tex != oval)
            {
                ord.html(tex);
                $.post('/navigation/upord',{
                    uid:uid,
                    oval:tex
                },function(data,status){
                    var object = eval('('+data+')');
                    //alert(object.result+'---'+status);
                });
            }
            else
            {
                ord.html(tex);
            }
        });
    });
    //更新导航列表是否有效
    $('.show').click(function(){
        var th = $(this);
        var id = th.attr('id');
        var val = th.text();
        $.post('/navigation/upshow',{
            id:id,
            val:val
        },function(data,status){
            var object = eval('('+data+')');
            //alert(object.result+'--'+status);
            th.html(object.val);
        });
    });
    //导航列表 全选/返选
    $("input[name='b']").click(function(){
        //判断当前点击的复选框处于什么状态$(this).is(":checked") 返回的是布尔类型
        if($(this).is(":checked")){
            $("input[name='navid[]']").prop("checked",true);
        }else{
            $("input[name='navid[]']").prop("checked",false);
        }
    });
    //更新导航分类下导航列表显示数
    $('.number').click(function(){
        var th = $(this);
        var uid = th.attr('id');
        var va = th.text();
        var input = $('<input type=text name=val maxlength=\"3\" size=\"6\" value="'+va+'" >');
        th.html(input);
        input.trigger('select');
        input.click(function(){return false;});
        //光标离开 input 后进行更新相关操作
        input.blur(function(){
            var tex = $(this).val();
            if(tex != va)
            {
                th.html(tex);
                $.post('/navigation/upnumber',{
                    uid:uid,
                    oval:tex
                },function(data,status){
                    var object = eval('('+data+')');
                    //alert(object.result+'---'+status);
                });
            }
            else
            {
                th.html(tex);
            }
        });
    });
    //更新导航分类排序
    $('.sort').click(function(){
        var th = $(this);
        var uid = th.attr('id');
        var va = th.text();
        var input = $('<input type=text name=val maxlength=\"3\" size=\"6\" value="'+va+'" >');
        th.html(input);
        input.trigger('select');
        input.click(function(){return false;});
        //光标离开 input 后进行更新相关操作
        input.blur(function(){
            var tex = $(this).val();
            if(tex != va)
            {
                th.html(tex);
                $.post('/navigation/upsort',{
                    uid:uid,
                    oval:tex
                },function(data,status){
                    var object = eval('('+data+')');
                    //alert(object.result+'---'+status);
                });
            }
            else
            {
                th.html(tex);
            }
        });
    });
    //更新导航分类状态是否有效
    $('.status').click(function(){
        var th = $(this);
        var id = th.attr('id');
        var val = th.text();
        $.post('/navigation/upstatus',{
            id:id,
            val:val
        },function(data,status){
            var object = eval('('+data+')');
            //alert(object.result+'--'+status);
            th.html(object.val);
        });
    });
});

