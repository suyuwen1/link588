$(function(){
    toplisthover();
    highlighter();
});

function toplisthover(){
    $(".navMenu ul li").hover(
        function(){
            //console.log($(this).index(),$(".navMenu ul li").length);
            if($(this).index() == $(".navMenu ul li").length-1){
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