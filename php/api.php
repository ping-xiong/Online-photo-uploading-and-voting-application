<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-21
 * Time: 9:27
 */

include_once "DetectFace.php";
include_once "config.php";

// 是否为post请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api = test_input($_POST['api']);
    switch ($api){
        case 'detectFace':
            // 人脸检测
            $fileName = test_input($_POST['fileName']);
            $result = detectFace::detect(config::$detectFace['img_path'].$fileName);
            echo $result;
            break;
        case 'submit':

            break;
    }

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}