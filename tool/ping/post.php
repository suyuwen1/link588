<?php
    set_time_limit(0);
    function __autoload($className){
	    include $className.'_class.php';
    }
    $M = new Mydb();

    if($_POST['id'] == 'all'){
        $sql = "SELECT dede_archives.id, dede_archives.title,  dede_arctype.namerule FROM `dede_archives`,`dede_arctype` WHERE dede_archives.typeid = dede_arctype.id and dede_archives.ismake = 1 ORDER BY  `dede_archives`.`id` ASC";
    }

    if($_POST['id'] == 'add'){
        $sql = "SELECT dede_archives.id, dede_archives.title,  dede_arctype.namerule FROM `dede_archives`,`dede_arctype`,`ping` WHERE dede_archives.typeid = dede_arctype.id and dede_archives.ismake = 1 and dede_archives.id > ping.last_id ORDER BY  `dede_archives`.`id` ASC";
    }

    if($_POST['id'] == 'bt'){
        $sql = "SELECT dede_archives.id, dede_archives.title,  dede_arctype.namerule FROM `dede_archives`,`dede_arctype` WHERE dede_archives.id between $_POST['start'] and $_POST['end'] and dede_archives.typeid = dede_arctype.id and dede_archives.ismake = 1   ORDER BY  `dede_archives`.`id` ASC";
    }

    $urls = array();
    $result = mysqli_query($M->mysql,$sql);
    if($result && mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
            $row['namerule'] = str_replace('{aid}',$row['id'],$row['namerule']);
            $urls[] = 'http://www.link588.com'.$row['namerule'];
        }

        $api = 'http://data.zz.baidu.com/urls?site=www.link588.com&token=cjec0HNMvsZfppqp';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $result = json_decode($result);
        if($result['success']){
            if($_POST['id'] == 'add' || $_POST['id'] == 'all'){
                $sql = "UPDATE `ping` SET `last_id` = (SELECT id FROM `dede_archives` ORDER BY id DESC limit 1)";
                $result2 = mysqli_query($M->mysql,$sql);
                if($result2 && mysqli_affected_rows($M->mysql)>0){
                    $urls['ping'] = '最后更新ID已更新！';
                }else{
                    $urls['ping'] = '最后更新ID更新失败！';                    
                }
            }
        }
        
        $urls['total'] = count($urls);
        echo json_encode(array_merge($urls,$result));
    }
?>