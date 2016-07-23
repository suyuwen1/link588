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
        $sql = "SELECT dede_archives.id, dede_archives.title,  dede_arctype.namerule FROM `dede_archives`,`dede_arctype` WHERE dede_archives.id between {$_POST['start']} and {$_POST['end']} and dede_archives.typeid = dede_arctype.id and dede_archives.ismake = 1  ORDER BY  `dede_archives`.`id` ASC";
    }

    $urls = array();
    $urls2 = array();
    $num = 0;
    $back = array();
    $back['success'] = 0;
    $result2 = '';
    $result = mysqli_query($M->mysql,$sql);
    $back['total'] = mysqli_num_rows($result);
    if($result && mysqli_num_rows($result)){
        
        while($row = mysqli_fetch_assoc($result)){
            $row['namerule'] = str_replace('{aid}',$row['id'],$row['namerule']);
            $urls[] = 'http://www.link588.com'.$row['namerule'];
            // $num++;

            // if ($back['total']<2000) {
            //     baidu_ping($urls);
            // }

            // if ($num == 2000) {//百度一次最多推2000条
            //     baidu_ping($urls);
            //     $num = 0;
            //     $urls = array();
            // }
        }        
        
        $page = ceil($back['total']/2000);
        //echo $page.'</br>';
        for ($i=0; $i < $page; $i++) {
            $a = ($i == $page-1)?$back['total']:$i*2000+2000;
            //echo $a.'</br>';
            for ($ii=$i*2000; $ii <$a ; $ii++) {
                $urls2[] = $urls[$ii];
            }
            //var_dump($urls2);
            //echo '-------------------------';
            //var_dump($i);
            baidu_ping($urls2);
            $urls2 = array();
            sleep(3);
        }
        
        
    }else{
        echo mysqli_error($M->mysql);
        //echo mysqli_num_rows($result);
    }
echo json_encode($back);

function baidu_ping($urls='')
{
    global $back, $result2;
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
        curl_close($ch);
        $result = json_decode($result,true);
        if($result['success']){

            $back['success'] += $result['success'];
            $back['remain'] = $result['remain'];

            if(($_POST['id'] == 'add' || $_POST['id'] == 'all') && empty($result2)){
                $sql = "UPDATE `ping` SET `last_id` = (SELECT id FROM `dede_archives` ORDER BY id DESC limit 1)";
                $result2 = mysqli_query($M->mysql,$sql);
                if($result2 && mysqli_affected_rows($M->mysql)>0){
                    $back['ping'] = '最后更新ID已更新！';
                }else{
                    $back['ping'] = '最后更新ID更新失败！';                    
                }
            }

        }else{
            $back['error'] = $result['error'].':'.$result['message'];
            $back['error']['url'][] = $urls;
        }
}
?>