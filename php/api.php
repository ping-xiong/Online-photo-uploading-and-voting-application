<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-21
 * Time: 9:27
 */

// 是否为post请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api = test_input($_POST['api']);
    switch ($api){
        case 'detectFace':
            // 人脸检测

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