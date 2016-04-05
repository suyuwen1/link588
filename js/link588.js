$(function(){
    toplisthover();
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