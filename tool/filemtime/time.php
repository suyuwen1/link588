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
    <font color="red">在地址里输入得到时间</font> ?time=1462763348
<?php
    echo '<p>现在时间：'.time().'</p>';
    echo '<p>'.date('Y-m-d H:i:s',time()).'</p>';
    if(!empty($_GET['time'])){
        echo '<p>'.date('Y-m-d H:i:s',$_GET['time']).'</p>';
    }
?>
</body>
</html>