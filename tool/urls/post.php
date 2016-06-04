<?php
    function __autoload($className){
	    include $className.'_class.php';
    }
    $dt = array();
    $dt['n'] = 1;
    if(empty($_POST['url']) || empty($_POST['email'])){
        $dt['i'] = '<font color="red">网址和邮箱不能为空！</font>';
    }else {
        if(!preg_match('/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/i', trim($_POST['url']))){
            $dt['i'] = '<font color="red">你输入的不是网址！</font>';
        }else {
            if (!preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', trim($_POST['email']))) {
                $dt['i'] = '<font color="red">你输入的不是邮箱！</font>';
                $dt['n'] = 2;
            }else {
                $M = new Mydb();
                $url = urlencode(trim($_POST['url']));
                $email = trim($_POST['email']);
                $ctime = time();
                $sql = "SELECT id FROM `urls` WHERE `url` = '$url'";
                $result = mysqli_query($M->mysql,$sql);
                if($result && mysqli_num_rows($result)){
                    $dt['i'] = '<font color="red">已收录！</font>';
                }else {
                    $sql = "insert into `urls` (url,email,ctime) values ('$url','$email','$ctime')";
                    $result=mysqli_query($M->mysql,$sql);
                    if($result && mysqli_affected_rows($M->mysql)>0){
                        $dt['i'] = '<font color="green">提交成功！</font>';
                    }else {
                        $dt['i'] = '<font color="red">提交失败，请稍后再试！</font>';
                    }
                }
            }
        }
        // $M = new Mydb();
        // $url = urlencode(trim($_POST['url']));
        // $email = trim($_POST['email']);
        // $ctime = time();
        // $sql = "SELECT id FROM `urls` WHERE `url` = '$url'";
        // $result = mysqli_query($M->mysql,$sql);
        // if($result && mysqli_num_rows($result)){
        //     $dt['i'] = '<font color="red">已收录！</font>';
        // }else {
        //     $sql = "insert into `urls` (url,email,ctime) values ('$url','$email','$ctime')";
        //     $result=mysqli_query($M->mysql,$sql);
        //     if($result && mysqli_affected_rows($M->mysql)>0){
        //         $dt['i'] = '<font color="green">提交成功！</font>';
        //     }else {
        //         $dt['i'] = '<font color="red">提交失败，请稍后再试！</font>';
        //     }
        // }
    }
    
    echo json_encode($dt);
?>