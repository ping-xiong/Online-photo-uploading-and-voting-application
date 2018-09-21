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
            // 提取需要的属性
            $data = json_decode($result);
            $beauty = "";
            $smile = "";
            for ($i = 0; $i < count($data->data->face_list); $i++){
                if ($i == 0){
                    $beauty = $data->data->face_list[$i]->beauty."分";
                    $smile = $data->data->face_list[$i]->expression."分";
                } else{
                    $beauty .= ", ".$data->data->face_list[$i]->beauty."分";
                    $smile .= ", ".$data->data->face_list[$i]->expression."分";
                }
            }
            $final = [
                "ret"=>$data->ret,
                "beauty"=>$beauty,
                "smile"=>$smile
            ];
            echo json_encode($final);
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