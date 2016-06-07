$(function(){
    up();
    sendurl();
});
//向上滚动代码
function up(){
    click_up();
    var s_h;
    $(window).scroll(function(){
        s_h = $(this).scrollTop();
        if(s_h > 150){
            $(".tool_up").show('fast');
        }else{
            $(".tool_up").hide();
        }
    });
}
//点击up
function click_up(){
    $(".tool_up").click(function(){
        $('html,body').animate({scrollTop:0}, 'fast');
        // $(window).scrollTop(0);
    });
}

//url提交
function sendurl(){
    var ajax;
    var infohide = false;
    $(".sendurl_con_tj").click(function(){
        var url = $.trim($(".sendurl_con_url").val());
        var email = $.trim($(".sendurl_con_email").val());
        //if(url == '' || email =='') return false;
        if(ajax) ajax.abort();
        ajax = $.ajax({
            type: "post",
            url: "http://www.link588.com/templets/link588/tool/urls/post.php",
            data: {"url":url,"email":email},
            dataType: "json",
            beforeSend: function(){
                infohide = false;
                $(".info1").html('<img height="31" src="http://www.link588.com/templets/link588/tool/urls/win10.gif">').show();
            },
            success: function (dt) {
                $(".info1").html('');
                $(".info"+dt.n).html(dt.i).show();
                infohide = true;
            }
        });
    });
    
    $(".sendurl_gb").click(function(){
        $(".sendurl").hide();
        $(".tool_sendurl").show();
    });
    
    $(".tool_sendurl").click(function(){
        $(".sendurl").show();
        $(".tool_sendurl").hide();
    });
    
    $(".info1,.info2").click(function(){
        $(this).hide();
    });
    
    $(".sendurl_con_url,.sendurl_con_email").click(function(){
        if(infohide){
            var c = $(this).attr('d');
            $('.'+c).hide();
        }
    });
}