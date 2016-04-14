<?php
    if(empty($_POST['s'])){
        exit;
    }
    $regex = array(); //最后一个必须是替换链接。
    //$regex[0] = '<p[^>]*>(.*)?运行效果(截图|图)(.*)?<\/p>';
    $regex[1] = '<p>在线演示地址如下：<\/p>';
    $regex[2] = '<img[^>]*jb51\.net[^>]*>';
    $regex[3] = '<p[^>]*>(\r\n)*(.*)?demo\.jb51\.net(.*)?<\/p>';
    $regex[4] = '<span(.*)?><u>复制代码<\/u><\/span>';
    $regex[5] = '<p><p><span(.*)?><U>复制代码<\/U><\/span> ';
    $regex[5] = '<br \/>复制代码';
    $regex[6] = '<input[^>]*复制代码[^>]*>';
    $regex[7] = '<input[^>]*另存代码[^>]*>';
    $regex[8] = '<input[^>]*运行代码[^>]*>';
    $regex[9] = '\s*title\s*=\s*\"[^\"]*\"';
    $regex[10] = '\s*alt\s*=\s*\"[^\"]*\"';
    $regex[11] = 'jb51\.net';
    
    $rep = array();
    $where = "body REGEXP '";
    foreach($regex as $key => $val){
        if (count($regex) == ($key+1)) {//如果是最后一个就替换为link588.com
            $where .= "$val'";
            $rep[$key] = 'link588.com';
        }else{
            $where .= "$val|";
            if ($key == 9 || $key == 10) {
                $rep[$key] = 'link588.com';
            }else{
                $rep[$key] = '';
            }            
        }
        $regex[$key] = '/'.$val.'/i';
    }
    
    $where = "aid = {$_POST['s']}";
    
    //var_dump($regex,$rep,$where);
    //echo $_POST['s'].'</br>';
    //exit;

    function __autoload($className){
	    include $className.'_class.php';
    }
    
    $M = new Mydb();
    
    $sql = "SELECT aid,body FROM `dede_addonarticle` WHERE $where";
	$result = mysqli_query($M->mysql,$sql);
	if($result && mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
            $body = preg_replace($regex, $rep, $row['body']);
            //echo $body.'</br>';
            if ($body != $row['body']) {
                $body = mysqli_real_escape_string($M->mysql,$body);
                $sql = "UPDATE `dede_addonarticle` SET `body` = '$body' WHERE aid = {$row['aid']}";
                $result2=mysqli_query($M->mysql,$sql);
			    if($result2 && mysqli_affected_rows($M->mysql)>0){
                    echo '<span class="num">'.$row['aid'].'</span><span style="color:green;">替换成功！</span></br>';
                }else{
                    echo '<span class="num">'.$row['aid'].'</span><span style="color:red;">替换失败！</span></br>';
                }
            }else{
                echo '<span class="num">'.$_POST['s'].'</span><span style="color:#777708;">不需要替换！</span></br>';
            }
            
            
            
            // $result2=mysqli_query($M->mysql,$sql);
			// if($result2 && mysqli_affected_rows($M->mysql)>0){
            //     echo '替换成功！</br>';
            // }else{
            //     echo $row['aid'].'------------------------------------替换失败！----------------------------------------<br>';
            //     echo mysqli_error($M->mysql);
            //     echo '<br>';
            //     echo '<pre>'.$row['body'].'</pre><br>';
            // }
        }
    }else{
        echo '<span class="num">'.$_POST['s'].'</span><span style="color:#666;">没有要替换的数据！</span></br>';        
    }
?>