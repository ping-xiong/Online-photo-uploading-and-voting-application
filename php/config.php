<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-21
 * Time: 8:49
 */

class config
{
    public static $detectFace = [
        "APPID"=>"2108474938",
        "APPKEY"=>"zZOXCR29ET8lEeQd",
        "api"=>"https://api.ai.qq.com/fcgi-bin/face/face_detectface",
        "img_path"=>"../images/upload/"
    ];

    public static $homepage = [
        "max_upload_post"=>5, // session有效期内最多上传次数
        "max_posts_each_page"=>20 // 每页的个数
    ];
}