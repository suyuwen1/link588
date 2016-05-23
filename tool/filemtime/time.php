<?php
    date_default_timezone_set('PRC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <font color="red">在地址里输入得到时间</font> ?time=1462763348&str=2016-4-28
<?php
    echo '<p>现在时间：'.time().'</p>';
    echo '<p>现在时间：'.date('Y-m-d H:i:s',time()).'</p>';
    if(!empty($_GET['time'])){
        echo '<p>time得到时间：'.date('Y-m-d H:i:s',$_GET['time']).'</p>';
    }
    if(!empty($_GET['str'])){
        echo '<p>str得到时间：'.strtotime($_GET['str']).'</p>';
    }
?>
</body>
</html>