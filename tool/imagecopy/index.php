<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加水印</title>
</head>
<body>
    <?php
        $dir = 'img';
        $xdir = 'ximg';
        $w_img = 'mark.png';
        $file = scandir($dir);
        //print_r($file);
        list($ww, $wh) = getimagesize($w_img);
        $w_img = img_obj($w_img);
        
        foreach ($file as $key => $value) {
            if($value != '.' && $value != '..' && !is_dir($value)){
                $r_img_n = $dir.'/'.$value;
                list($rw, $rh) = getimagesize($r_img_n);
                $r_img = img_obj($r_img_n);
                $r_img_x = $rw - $ww;
                $r_img_y = $rh - $wh;
                imagecopy($r_img, $w_img, $r_img_x, $r_img_y, 0, 0, $ww, $wh);
                img_push($r_img_n, $r_img, $xdir.'/'.$value);
            }
            
            
        }
        
        function img_obj($f){
            $f2 = getimagesize($f);
            switch ($f2[2]) {
                case 1:
                    $f = imagecreatefromgif($f);
                    break;
                case 2:
                    $f = imagecreatefromjpeg($f);
                    break;
                case 3:
                    $f = imagecreatefrompng($f);
                    break;
            }
            return $f;
        }
        
        function img_push($f, $img, $xdir){
            $f = getimagesize($f);
            switch ($f[2]) {
                case 1:
                    $f = imagegif($img, $xdir);
                    break;
                case 2:
                    $f = imagejpeg($img, $xdir);
                    break;
                case 3:
                    $f = imagepng($img, $xdir);
                    break;
            }
            if($f){
                echo '<p><span style="color:green;">'.$xdir.'成功！</p>';
            }else{
                echo '<p><span style="color:red;">'.$xdir.'失败！</span></p>';
            }
        }
    ?>
</body>
</html>