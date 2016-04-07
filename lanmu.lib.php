<?php
if(!defined('DEDEINC'))
{
    exit("Request Error!");
}
// require_once(DEDEINC.'/arc.partview.class.php');
require_once(DEDEINC.'/taglib/mytag.lib.php');
// require_once(DEDEINC.'/taglib/arclist.lib.php');
require_once(DEDEINC.'/common.inc.php');
function lib_lanmu(&$ctag,&$refObj)
{
    global $dsql,$envs;
    
    //属性处理
    $attlist="row|12,titlelen|24,typeid|0";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $revalue = '';
    
    //你需编写的代码，不能用echo之类语法，把最终返回值传给$revalue
    //------------------------------------------------------
    $tpsql = " reid=0 AND ispart<>2 AND ishidden<>1 AND channeltype>0 ";
    $dsql->SetQuery("SELECT id,typename,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl,sitepath 
                                            FROM dede_arctype WHERE $tpsql ORDER BY sortrank ASC");
    $dsql->Execute();
    $typeids = array();
    $typeids[0] = 0;
    while($row = $dsql->GetArray()) {
        $typeids[] = $row;
    }
    //$revalue =  var_dump($typeids);
    $n = 0;
    foreach($typeids as $key => $val){
        // if($val['id'] == 12 || $val['id'] == 20){
        //     continue;
        // }
        // if(($key+1) % 3 == 0){
        //     $revalue .= '<div class="con">';
        // }
        if ($key == 0) {
            $revalue .= '<div class="conleft"><div class="contitle">最近更新</div><div class="conlist">';
            $sqltext = " SELECT * FROM dede_archives ORDER BY pubdate desc , senddate desc , id desc limit 16";
        }else {
            $revalue .= '<div class="conleft"><div class="contitle">'.$val['typename'].'<a class="more" href="'.GetOneTypeUrlA($val).'">更多</a></div><div class="conlist">';
            $sqltext = "select title,id,pubdate from dede_archives where typeid in(select id from dede_arctype where topid = ".$val['id'].") order by pubdate desc , senddate desc , id desc limit 16";
        }
        //var_dump($val['id']);
        $dsql->SetQuery($sqltext);
        $dsql->Execute();
        $typeids2 = array();
        while($row2 = $dsql->GetArray()) {
             $typeids2[] = $row2;
        }
        //var_dump($typeids2);
        if (!empty($typeids2)) {
            foreach ($typeids2 as $key2 => $val2) {
                $oneurl = GetOneArchive($val2['id']);
                $revalue .= '<span class="conlisttime">'.MyDate('m-d',$val2['pubdate']).'</span><a target="_blank" href="'.$oneurl['arcurl'].'">'.cn_substr($val2['title'],50).'</a>';
                //var_dump(GetOneArchive($val2['id']));
            }
        }
        
        $revalue .= '</div></div>';
        
        if(($key+1) % 3 == 0){
            //$revalue .= '</div>';
            $n++;
            $tagname = 'indexLeftBanner'.$n;
            //select * from dede_archives where typeid in(select id from dede_arctype where topid = 12) order by pubdate desc , senddate desc , id desc
            // $row = $dsql->GetOne(" SELECT * FROM dede_myad WHERE tagname LIKE '$tagname' ORDER BY typeid DESC ");
            // $revalue .= var_dump($row,$tagname);
            // if($row != '')(
            //     $revalue .= '<div style="margin-bottom:10px auto">'.$row['normbody'].'</div>';
            // )
            
            //$tpsql = " reid=0 AND ispart<>2 AND ishidden<>1 AND channeltype>0 ";
            
            
            $body = lib_GetMyTagT($refObj, $typeid, $tagname, '#@__myad');
            if(!empty($body)){
                $revalue .= '<div class="index_myad">'.$body.'</div>';
            }
        }
    }
    $dsql->Close();
    //------------------------------------------------------
    return $revalue;
}
?>