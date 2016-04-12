<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>jb51</title>
</head>
<body>
<?php
    $regex = '<p[^>]*><img[^>]*jb51.net[^>]*><\/p>';

    function __autoload($className){
	    include $className.'_class.php';
    }
    
    $M = new Mydb();
    
    $sql = "SELECT aid,body FROM `dede_addonarticle` WHERE body REGEXP '$regex'";
    //var_dump($sql);
	$result = mysqli_query($M->mysql,$sql);
    //mysqli_error($M->mysql);
    //var_dump($result,$M->mysql);
	if($result && mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
            //var_dump($row);
            $body = preg_replace('/'.$regex.'/', '', $row['body']);
            //echo '--------------------------------------------------------'.$body.'-------------------------------------------------------';
            $sql = "UPDATE `dede_addonarticle` SET `body` = '$body' WHERE aid = {$row['aid']}";
            $result2=mysqli_query($M->mysql,$sql);
			if($result2 && mysqli_affected_rows($M->mysql)>0){
                echo '替换成功！';
            }else{
                echo '替换失败！';
                echo mysqli_error($M->mysql);
            }
        }
    }else{
        echo '没有要替换的数据！';
    }
?>
</body>
</html>