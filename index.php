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
    <main>
        <section id="homepage" style="display: block">
            <header>

            </header>
            <div class="am-input-group" id="search-div">
                <input type="text" class="am-form-field" placeholder="搜索名字">
                <span class="am-input-group-btn">
            <button class="am-btn am-btn-success" type="button"><span class="am-icon-search"></span> </button>
          </span>
            </div>
            <div class="card">
                <div class="card-img">
                    <figure data-am-widget="figure" class="am am-figure card-img-tag" data-am-figure="{  pureview: 'true' }">
                        <img src="images/test.jpg" data-rel="images/test.jpg" alt="春天的花开秋天的风以及冬天的落阳"/>
                        <img style="display: none" src="images/test.jpg" data-rel="images/test.jpg" alt="春天的花开秋天的风以及冬天的落阳"/>
                    </figure>
                    <div class="am-g card-img-info">
                        <div class="am-u-sm-4">
                            <p class="card-img-beauty"><i class="am-icon-eye"></i> 颜值：</p>
                        </div>
                        <div class="am-u-sm-4">
                            <p class="card-img-hot"><i class="am-icon-smile-o"></i> 笑容：</p>
                        </div>
                        <div class="am-u-sm-4">
                            <p class="card-img-hot"><i class="am-icon-fire"></i> 人气：</p>
                        </div>
                    </div>
                </div>
                <div class="tags">
                    <span class="am-badge am-badge-warning am-text-sm img-num">2图</span>
                </div>
                <div class="card-desc">
                    <p class="card-name">1. 小明 <span class="votes">(100票)</span></p>
                    <p class="card-say">测试测试测试测试测试</p>
                </div>
                <div class="card-btn-group">
                    <div class="am-btn-group am-btn-group-justify">
                        <a class="am-btn am-btn-junxun" role="button"><i class="am-icon-check-square-o"></i>投票</a>
                        <a class="am-btn am-btn-junxun" role="button"><i class="am-icon-th-list"></i>评论</a>
                        <a class="am-btn am-btn-junxun" role="button"><i class="am-icon-share-alt"></i>分享</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="upload" style="display: none">
            <div class="am-form-group">
                <label for="doc-ds-ipt-1">标题/名字</label>
                <input type="text" id="post-title" class="am-form-field am-round" placeholder="最好是姓名哦">
            </div>
            <i class="am-icon-picture-o"></i> 选择主图
            <div id="main-photo-box" class="am-vertical-align">
                <div class="am-vertical-align-middle preview-box">
                    <i class="am-icon-plus-circle add-picture"  style="font-size: 40px;line-height: 120px;"></i>
                    <div class="am-g" id="picture-preview-box" style="display: none">
                        <div class="am-u-sm-6" style="height: 100%;"><img id="picture-preview" src="" alt="图片预览"></div>
                        <div class="am-u-sm-6">
                            <p style="text-align: left"><i class="am-icon-eye"></i> 颜值：<span id="card-img-beauty-value">等待分析</span></p>
                            <p style="text-align: left"><i class="am-icon-smile-o"></i> 笑容：<span id="card-img-smile-value">等待分析</span></p>
                            <p class="hint">注：AI分析结果仅供参考</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="am-btn am-btn-default" id="detectFace" style="display: none">
                <i class="am-icon-search"></i> 开始分析颜值
            </button>
            <div id="main-process-bar" class="am-progress" style="display: none">
                <div class="am-progress-bar" id="main-process-bar-process" style="width: 0%">0%</div>
            </div>
            <br>

            <i class="am-icon-picture-o"></i> 选择副图(选填,可多选,最多三张)
            <div class="am-g" id="second-photo-box">
                <div class="am-u-sm-4">
                    <div id="second-photo-box-1" class="am-vertical-align">
                        <div class="am-vertical-align-middle">
                            <i class="am-icon-plus-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-4">
                    <div id="second-photo-box-2" class="am-vertical-align">
                        <div class="am-vertical-align-middle">
                            <i class="am-icon-plus-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-4">
                    <div id="second-photo-box-3" class="am-vertical-align">
                        <div class="am-vertical-align-middle">
                            <i class="am-icon-plus-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <button class="am-btn am-btn-default" id="clearSecondPicture" style="display: none" onclick="clearSecondPictures()">
                <i class="am-icon-trash"></i> 清空副图
            </button>
            <div id="main-process-bar2" class="am-progress" style="display: none">
                <div class="am-progress-bar" id="main-process-bar-process2" style="width: 0%">0%</div>
            </div>

            <div class="am-form-group" id="say-something">
                <label for="say">说点什么吧</label>
                <textarea class="am-form-field am-radius" onkeydown="count_words()" rows="4" id="say" placeholder="感慨/对教官说的话/对大学的期待..."></textarea>
                <span id="word-count">0/500字</span>
            </div>
            <button type="button" class="am-btn am-btn-primary" id="submit" onclick="submitNewPost()">确认提交</button>
        </section>
        <section id="help" style="display: none">

        </section>

    </main>
    <footer id="toolbar">
        <div class="am-btn-group am-btn-group-justify bottom-btns">
            <a class="am-btn am-btn-danger" role="button" href="javascript:;" onclick="switchMenu('homepage')"><i class="am-icon-home"></i><br>首页</a>
            <a class="am-btn am-btn-primary" role="button" href="javascript:;" onclick="switchMenu('upload')"><i class="am-icon-picture-o"></i><br>我要晒照</a>
            <a class="am-btn am-btn-success" role="button" href="javascript:;" onclick="switchMenu('help')"><i class="am-icon-question-circle-o"></i><br>帮助</a>
        </div>
    </footer>

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
    <script src="https://cdn.bootcss.com/plupload/2.3.6/plupload.full.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
    <script src="https://cdn.bootcss.com/plupload/2.3.6/i18n/zh_CN.js"></script>
    <script src="js/lib/template-web.js"></script>
    <script src="js/index.js"></script>
    <script src="js/photo.js"></script>
</body>
</html>
