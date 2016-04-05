<?php
if(!defined('DEDEINC'))
{
    exit("Request Error!");
}
require_once(DEDEINC.'/common.inc.php');
function lib_toplist(&$ctag,&$refObj)
{
    global $dsql,$envs;
    
    //属性处理
    $attlist="row|100,titlelen|24";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $line = empty($row) ? 100 : $row;
    $revalue = '';
    
    //你需编写的代码，不能用echo之类语法，把最终返回值传给$revalue
    //------------------------------------------------------
    
    //$tpsql = " reid=0 AND ispart<>2 AND ishidden<>1 AND channeltype>0 ";
    $dsql->SetQuery("SELECT id,typename,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl,sitepath
          From `#@__arctype` WHERE reid=0 And ishidden<>1 order by sortrank asc limit 0, $line ");
    $dsql->Execute();
    $typeids = array();
    //$typeids[0] = 0;
    while($row = $dsql->GetArray()) {
        $typeids[] = $row;
    }
    //var_dump($typeids);
    //$revalue .= '<ul>';
    foreach($typeids as $key => $val){
        $revalue .= '<li><a href="'.GetOneTypeUrlA($val).'">'.$val['typename'].'</a>';
        $dsql->SetQuery("SELECT id,typename,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl,sitepath
          From `#@__arctype` WHERE reid='".$val['id']."' And ishidden<>1 order by sortrank asc");
        $dsql->Execute();
        $typeids2 = array();
        while($row2 = $dsql->GetArray()) {
             $typeids2[] = $row2;
        }
        if (!empty($typeids2)) {
            $revalue .= '<div class="toplistm">';
            foreach ($typeids2 as $key2 => $val2) {
                $revalue .= '<a href="'.GetOneTypeUrlA($val2).'">'.$val2['typename'].'</a>';
            }
            $revalue .= '</div>';
        }
        
        $revalue .= '</li>';
    }
    //$revalue .= '</ul>';
    $dsql->Close();
    //------------------------------------------------------
    return $revalue;
}
?>