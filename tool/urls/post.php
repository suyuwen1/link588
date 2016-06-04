<?php
    function __autoload($className){
	    include $className.'_class.php';
    }
    $dt = array();
    if(empty($_POST['url']) || empty($_POST['email'])){
        dt['i'] = '网址和邮箱不能为空！';
    }else {
        $M = new Mydb();
        $url = $_POST['url'];
        $email = $_POST['email'];
        $ctime = time();
        $sql = "SELECT id FROM `urls` WHERE url = $url";
        $result = mysqli_query($M->mysql,$sql);
        if($result && mysqli_num_rows($result)){
            dt['i'] = '已收录！';
        }else {
            $sql = "insert into `urls` (url,email,ctime) values ('$url','$email','$ctime')";
            $result=mysqli_query($M->mysql,$sql);
            if($result && mysqli_affected_rows($M->mysql)>0){
                dt['i'] = '提交成功！';
            }else {
                dt['i'] = '提交失败，请稍后再试！';
            }
        }
    }
    
    echo json_encode(dt);
?>