<?php
if(!defined('DEDEINC'))
{
    exit("Request Error!");
}
require_once(DEDEINC.'/arc.partview.class.php');
require_once(DEDEINC.'/taglib/mytag.lib.php');
require_once(DEDEINC.'/taglib/arclist.lib.php');
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
    while($row = $dsql->GetArray()) {
        $typeids[] = $row;
    }
    //$revalue =  var_dump($typeids);
    $n = 0;
    foreach($typeids as $key => $val){
        if($typeids[$key]['id'] == 12 || $typeids[$key]['id'] == 20){
            continue;
        }
        if(($key+1) % 3 == 0){
            $revalue .= '<div class="con">';
        }
        
        $revalue .= '<div class="conleft"><div class="contitle">'.$typeids[$key]['typename'].'<a class="more" href="'.GetOneTypeUrlA($typeids[$key]).'">更多</a></div><div class="conlist">';
        
        
        $revalue .= '</div></div>';
        
        if(($key+2) % 3 == 0){
            $revalue .= '</div>';
            $n++;
            $tagname = 'indexLeftBanner'.$n;
            // $row = $dsql->GetOne(" SELECT * FROM dede_myad WHERE tagname LIKE '$tagname' ORDER BY typeid DESC ");
            // $revalue .= var_dump($row,$tagname);
            // if($row != '')(
            //     $revalue .= '<div style="margin-bottom:10px auto">'.$row['normbody'].'</div>';
            // )
            $body = lib_GetMyTagT($refObj, $typeid, $tagname, '#@__myad');
            $revalue .= '<div style="margin-bottom:10px auto">'.$body.'</div>';
        }
    }
    //------------------------------------------------------
    return $revalue;
}
?>