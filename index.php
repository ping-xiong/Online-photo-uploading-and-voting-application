<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-20
 * Time: 11:50
 */

?>


<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.bootcss.com/amazeui/2.7.2/css/amazeui.min.css" rel="stylesheet">
    <title>广科大吧最美军训照</title>
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <header>

    </header>
    <div class="am-input-group">
        <input type="text" class="am-form-field" placeholder="搜索名字">
        <span class="am-input-group-btn">
            <button class="am-btn am-btn-success" type="button"><span class="am-icon-search"></span> </button>
          </span>
    </div>
    <main>
        <div class="card">
            <div class="card-img">
                <p class="card-img-beauty"><i class="am-icon-eye"></i> 颜值：</p>
                <figure data-am-widget="figure" class="am am-figure card-img-tag" data-am-figure="{  pureview: 'true' }">
                    <img src="images/test.jpg" data-rel="images/test.jpg" alt="春天的花开秋天的风以及冬天的落阳"/>
                    <img style="display: none" src="images/test.jpg" data-rel="images/test.jpg" alt="春天的花开秋天的风以及冬天的落阳"/>
                </figure>
                <p class="card-img-hot"><i class="am-icon-fire"></i> 人气：</p>
            </div>
            <div class="tags">
                <span class="am-badge am-badge-warning am-text-sm img-num">2张</span>
            </div>

            <div class="card-desc">
                <p class="card-name">1. 小明</p>
                <p class="card-say">测试测试测试测试测试</p>
            </div>
            <div class="card-btn-group">
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-danger" role="button"><i class="am-icon-check-square-o"></i>投票</a>
                    <a class="am-btn am-btn-primary" role="button"><i class="am-icon-th-list"></i>评论</a>
                    <a class="am-btn am-btn-success" role="button"><i class="am-icon-share-alt"></i>分享</a>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
    <script src="js/lib/template-web.js"></script>
</body>
</html>
