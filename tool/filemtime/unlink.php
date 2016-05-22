<?php
    set_time_limit(0);
    // if(empty($_GET['path']) || empty($_GET['stime']) || empty($_GET['endtime'])){
    //     echo '<font color="red">path、stime、endtime不能为空！</font>';
    // }
    
    $data = array();
    $data['num'] = '';
    $filepath = $_POST['path'];
            if(is_file($filepath)){
                if(filemtime($filepath) >= $_POST['stime'] && filemtime($filepath) <= $_POST['endtime']){
                    if(unlink($filepath)){
                        $data['info'] = '<font color="green">删除成功！</font>';
                    }else {
                        $data['info'] = '<font color="red">删除失败！</font>';
                    }
                }else {
                    $data['info'] = '<font color="gray">不在时间范围内！</font>';
                }
            }else {
                $data['info'] = '<font color="gray">不是文件！</font>';
            }
    echo json_encode($data);
?>