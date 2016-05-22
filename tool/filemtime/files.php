<?php
    set_time_limit(0);
    // if(empty($_GET['path']) || empty($_GET['stime']) || empty($_GET['endtime'])){
    //     echo '<font color="red">path、stime、endtime不能为空！</font>';
    // }
    $data = array();
    if(is_dir($_POST['path'])){
        $dir = opendir($_POST['path']);
        if($dir){
            while (($file = readdir($dir)) !== false) {
                $filepath = $_POST['path'].'/'.$file;
                if(is_file($filepath)){
                    $data['dt'][] = $file;
                }
            }
        
            $data['num'] = 2;
            $data['total'] = count($data['dt']);
            $data['info'] = '一共 '.count($data['dt']).' 个文件';
            echo json_encode($data);
        }else {
            echo '打开目录失败！';
        }
        // while (($file = readdir($dir)) !== false) {
        //     $filepath = $_POST['path'].'/'.$file;
        //     if(is_file($filepath)){
        //         if(filemtime($filepath) >= $_POST['stime'] && filemtime($filepath) <= $_POST['endtime']){
        //             if(unlink($filepath)){
        //                 echo '<font color="green">删除成功！</font>';
        //             }else {
        //                 echo '<font color="red">删除失败！</font>';
        //             }
        //         }else {
        //             echo '<font color="gray">不在时间范围内！</font>';
        //         }
        //     }else {
        //         echo '<font color="gray">不是文件！</font>';
        //     }
        // }
    }else {
        echo '不是目录';
    }
?>