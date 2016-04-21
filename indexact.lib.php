<?php
if(!defined('DEDEINC'))
{
    exit("Request Error!");
}
require_once(DEDEINC.'/common.inc.php');
function lib_indexact(&$ctag,&$refObj)
{
    global $dsql,$envs;
    
    //属性处理
    $attlist="typeid|0,reid|0,row|12,titlelen|24";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $revalue = '';
    
    //你需编写的代码，不能用echo之类语法，把最终返回值传给$revalue
    //------------------------------------------------------
    
    //var_dump($refObj->TypeLink->TypeInfos['id'],$refObj->TypeLink->TypeInfos['reid'],$refObj->TypeLink->TypeInfos['topid']);
    $reid = $refObj->TypeLink->TypeInfos['id'];
    $sql = "SELECT id,typename,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl,sitepath
            FROM `#@__arctype` WHERE reid='$reid' And ishidden<>1 order by sortrank asc";
    $dsql->SetQuery($sql);
    $dsql->Execute();
    $typeids = array();
    while($row = $dsql->GetArray()) {
        $typeids[] = $row;
    }
    //var_dump($typeids);
    
    foreach($typeids as $key => $val){
        //var_dump($val['id']);
        $sqltext = "SELECT title,id,pubdate FROM dede_archives where typeid = ".$val['id']." ORDER BY pubdate desc , senddate desc , id desc limit 15";
        //var_dump($sqltext);
        $dsql->SetQuery($sqltext);
        $dsql->Execute();
        $typeids2 = array();
        while($row2 = $dsql->GetArray()) {
             $typeids2[] = $row2;
        }
        if (!empty($typeids2)) {
            $revalue .= '<div class="onebox"><div class="oneboxt"><span class="oneboxtl"><a href="'.GetOneTypeUrlA($val).'">'.$val['typename'].'</a></span><span class="oneboxtr"><a href="'.GetOneTypeUrlA($val).'">更多</a></span></div><div class="oneboxl"><ul>';
            foreach ($typeids2 as $key2 => $val2) {
                $oneurl = GetOneArchive($val2['id']);
                $revalue .= '<li><span>'.MyDate('m-d',$val2['pubdate']).'</span><a target="_blank" href="'.$oneurl['arcurl'].'">'.cn_substr($val2['title'],100).'</a></li>';
            }
            $revalue .= '</ul></div></div>';
        }
    }
    
    //------------------------------------------------------
    return $revalue;
}
?>