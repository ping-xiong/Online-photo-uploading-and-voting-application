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
        "open" => true, // 是否开启人脸识别功能，true 为开启， false 为关闭
        // 接口申请地址：https://ai.qq.com/ ，免费使用
        "APPID"=>"2108474938", // 【修改为你申请的】人脸识别接口APPID
        "APPKEY"=>"zZOXCR29ET8lEeQd", // 【修改为你申请的】人脸识别接口APPKEY
        "api"=>"https://api.ai.qq.com/fcgi-bin/face/face_detectface", // 接口请求地址，保持默认即可
        "img_path"=>"../images/upload/" // 图片上传路径，保持默认即可
    ];

    public static $homepage = [
        "max_upload_post"=>10, // session有效期内最多上传次数
        "max_posts_each_page"=>10, // 每页显示帖子的个数
        "max_comment_each_post"=>5 // 每个帖子的评论列表每页显示最多的评论数量
    ];

    public static $mysql = [
        "host"=>"127.0.0.1", // 数据库地址
        "user"=>"root", // 数据库用户名
        "pass"=>"", // 数据库密码
        "db_name"=>"junxun" // 数据库名字
    ];


    public static $admin = [
      "username"=>"admin", // 后台登录账号
        "password"=>"admin" // 后台登录密码
    ];
}
