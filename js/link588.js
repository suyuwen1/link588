$(function(){
    toplisthover();
    highlighter();
    up();
    sendurl();
    click_up();
});

function toplisthover(){
    $(".navMenu ul li").hover(
        function(){
            //console.log($(this).index(),$(".navMenu ul li").length);
            if($(this).index() == $(".navMenu ul li").length-2){
                $(this).children(".toplistm").css({right:'-1px',left:'auto'});
            }
            $(this).children(".toplistm").show();
        },
        function(){
            $(".toplistm").hide();
        }
    );
}
function path() {
    var args = arguments,
    result = [];
    for (var i = 0; i < args.length; i++)
        result.push(args[i].replace('$', templetspath+'/style/syntaxhighlighter/scripts/'));
    return result;
}
function highlighter(){
    if (isarticle) {
        SyntaxHighlighter.autoloader.apply(null, path(
        'applescript            $shBrushAppleScript.js',
        'actionscript3 as3      $shBrushAS3.js',
        'bash shell             $shBrushBash.js',
        'coldfusion cf          $shBrushColdFusion.js',
        'cpp c                  $shBrushCpp.js',
        'c# c-sharp csharp      $shBrushCSharp.js',
        'css                    $shBrushCss.js',
        'delphi pascal          $shBrushDelphi.js',
        'diff patch pas         $shBrushDiff.js',
        'erl erlang             $shBrushErlang.js',
        'groovy                 $shBrushGroovy.js',
        'java                   $shBrushJava.js',
        'jfx javafx             $shBrushJavaFX.js',
        'js jscript javascript  $shBrushJScript.js',
        'perl pl                $shBrushPerl.js',
        'php                    $shBrushPhp.js',
        'text plain             $shBrushPlain.js',
        'py python              $shBrushPython.js',
        'ruby rails ror rb      $shBrushRuby.js',
        'sass scss              $shBrushSass.js',
        'scala                  $shBrushScala.js',
        'sql                    $shBrushSql.js',
        'vb vbnet               $shBrushVb.js',
        'ps powershell          $shBrushPowerShell.js',
        'xml xhtml xslt html    $shBrushXml.js'
        ));
        SyntaxHighlighter.all();
    }
}
//运行文本域代码
function runEx(id) {
    $val = $("#".id).val();
    var TestWin=window.open('','',''); //打开一个窗口并赋给变量TestWin。
    TestWin.opener = null // 防止代码对论谈页面修改
    TestWin.document.write($val);//向这个打开的窗口中写入代码code，这样就实现了运行代码功能。
    TestWin.document.close();
}
//向上滚动代码
var w_w;
function www(){
    w_w = $(window).width();
    if(w_w < 1000){
        var u = 600;
        var e = 280;
        $(".sendurl_con1").css({"width":(u/1000)*w_w});
        $(".sendurl_con2").css({"width":(e/1000)*w_w});
    }else{
        $(".sendurl_con1").css({"width":600});
        $(".sendurl_con2").css({"width":280});
    }
}
$(window).resize(function(){
    up();
});
function up(){
    
    www();
    var up_r = (w_w - 1000)/2 - 100;
    up_r = (up_r>0)?up_r:10;
    
    $(".tool_up,.tool_sendurl").css({"right":up_r});
    
}
var s_h;
$(window).scroll(function(){
    s_h = $(this).scrollTop();
    if(s_h > 200){
        $(".tool_up").show();
    }else{
        $(".tool_up").hide();
    }
});
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