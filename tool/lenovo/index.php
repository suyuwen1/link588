<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!--<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>-->
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            padding: 20px;
            font-size: 14px;
        }
        .list{
            width: 300px;
            text-align: right;
            padding: 5px 0;
        }
        .list input{
            padding: 5px;
            border: solid 1px #999;
        }
    </style>
</head>
<body>
    <!--<div class="list">category_id：<input type="text" id="category_id"></div>
    <div class="list">type：<input type="text" id="type" value="2"></div>
    <div class="list">p：<input type="text" id="p"></div>-->
    <div id="main">
<?php
    set_time_limit(0);
    if(empty($_GET['category_id']) || empty($_GET['p'])){
        echo '<span style="color:red;">?category_id=12&p=1</span>&type=2&total=10';
        exit;
    }else {
        $type = empty($_GET['type'])? 2 : $_GET['type'];
    }
    
    if(!empty($_GET['total'])){
        for ($i=1; $i <= $_GET['total']; $i++) {
            $d = file_get_contents('http://iknow.lenovo.com/doc/docList?category_id='.$_GET['category_id'].'&type='.$type.'&p='.$i);
            $d = json_decode($d);
            if($d->docList != ''){
                foreach ($d->docList as $key => $value) {
                    echo '<p><a target="_blank" href="http://iknow.lenovo.com/detail/dc_'.$d->docList[$key]->doc_code.'.html">http://iknow.lenovo.com/detail/dc_'.$d->docList[$key]->doc_code.'.html</a></p>';
                }
            }
        }
    }else {
        $d = file_get_contents('http://iknow.lenovo.com/doc/docList?category_id='.$_GET['category_id'].'&type='.$type.'&p='.$_GET['p']);
        $d = json_decode($d);
        if($d->docList != ''){
            foreach ($d->docList as $key => $value) {
                echo '<p><a target="_blank" href="http://iknow.lenovo.com/detail/dc_'.$d->docList[$key]->doc_code.'.html">http://iknow.lenovo.com/detail/dc_'.$d->docList[$key]->doc_code.'.html</a></p>';
            }
        }
    }
?>
</div>
</body>
</html>