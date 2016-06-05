<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script language="javascript" type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <style>
        .tool{
            padding: 30px;
        }
        .con{
            padding: 0 30px;
        }
        ul{
            padding:0;
            margin:0;
            list-style: none;
        }
        li{
            padding:10px;
        }
        li span{
            display:block;
            float:left;
        }
        .xz{
            width: 80px;
        }
        .url{
            width:600px;
        }
        .email{
            width:200px;
        }
        .ctime{
            width:200px;
        }
    </style>
</head>
<body>
<?php
    function __autoload($className){
	    include $className.'_class.php';
    }
    $M = new Mydb();
    var_dump($_POST);
    echo '</br>';
    if(!empty($_POST['xz'])){
        if ($_POST['tj'] == '批准') {
            foreach ($_POST['xz'] as $key => $value) {
                $sql = "update `urls` set `hf` = '已收录！' where `id` = $value";
                $result=mysqli_query($M->mysql,$sql);
                echo mysqli_error($M->mysql);
			    if($result&&mysqli_affected_rows($M->mysql)>0){
                    echo $value.'批准成功！ ';
                }else{
                    echo $value.'批准失败！ ';                    
                }
            }
        }
        
        if ($_POST['tj'] == '拒绝') {
            if ($_POST['jjc'] >1) {
                $jjc=$_POST['jjc'];
            }else{
                $jjc=$_POST['jjc2'];
            }
            foreach ($_POST['xz'] as $key => $value) {
                $sql = "update `urls` set `hf` = '$jjc' where `id` = $value";
                $result=mysqli_query($M->mysql,$sql);
			    if($result&&mysqli_affected_rows($M->mysql)>0){
                    echo $value.'批准成功！ ';
                }else{
                    echo $value.'批准失败！ ';
                }
            }
        }
    }
    
    $a=array();
    $sql = "SELECT id,url,email,ctime FROM `urls` WHERE `hf` = '0'";
    $result = mysqli_query($M->mysql,$sql);
    if($result && mysqli_num_rows($result)){
	    while($row=mysqli_fetch_assoc($result)){
			$a[]=$row;
		}
    }
?>
    <form name="myform" action="" method="post">
    <div class="tool">
        <input type="submit" name="tj" value="批准">
        <input type="submit" name="tj" value="拒绝">
        <select name="jjc" class="jjc">
            <option value="已收录！">已收录！</option>
            <option value="资源不符合要求！">资源不符合要求！</option>
            <option value="资源网址无法打开！">资源网址无法打开！</option>
            <option value="资源重复！">资源重复！</option>
        </select>
    </div>
    <div class="con">
        <ul>
        <?php
            if (empty($a)) {
                echo '没有内容！';
            }else {
                foreach ($a as $key => $value) {
                    echo '<li><span class="xz"><input name="xz[]" type="checkbox" value="'.$value['id'].'">'.$value['id'].'</span><span class="url"><a target="_blank" href="'.urldecode($value['url']).'">'.urldecode($value['url']).'</a></span><span class="email">'.$value['email'].'</span><span class="ctime">'.date('Y-m-d H:i:s',$value['ctime']).'</span></li>';
                }
            }
        ?>
        </ul>
    </div>
    <div class="tool">
        <input type="submit" name="tj" value="批准">
        <input type="submit" name="tj" value="拒绝">
        <select name="jjc2" class="jjc">
            <option value="已收录！">已收录！</option>
            <option value="资源不符合要求！">资源不符合要求！</option>
            <option value="资源网址无法打开！">资源网址无法打开！</option>
            <option value="资源重复！">资源重复！</option>
        </select>
    </div>
    </form>
</body>
</html>