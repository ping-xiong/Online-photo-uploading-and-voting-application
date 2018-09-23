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
        "max_upload_post"=>10, // session有效期内最多上传次数
        "max_posts_each_page"=>10, // 每页的个数
        "max_comment_each_post"=>5 // 每个帖子显示最多的评论数量
    ];

    public static $mysql = [
        "host"=>"127.0.0.1", // 数据库地址
        "user"=>"root", // 数据库用户名
        "pass"=>"", // 数据库密码
        "db_name"=>"junxun" // 数据库名字
    ];
}