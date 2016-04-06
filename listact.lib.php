<?php
if(!defined('DEDEINC'))
{
    exit("Request Error!");
}
function lib_listact(&$ctag,&$refObj)
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
    $reid = $refObj->TypeLink->TypeInfos['reid'];
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
        $revalue .= '<div></div>';
    }
    
    //------------------------------------------------------
    return $revalue;
}
?>