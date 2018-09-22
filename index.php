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
                <input type="text" id="keywords" class="am-form-field" placeholder="搜索名字">
                <span class="am-input-group-btn" onclick="search()">
            <button class="am-btn am-btn-success" type="button"><span class="am-icon-search"></span> </button>
          </span>
            </div>
            <div id="card-box">

            </div>
            <ul data-am-widget="pagination" class="am-pagination am-pagination-select">
                <li class="am-pagination-prev ">
                    <a href="javascript:;" class="" onclick="previousPage()">上一页</a>
                </li>
                <li class="am-pagination-select">
                    <select id="select-list" onchange="selectPages()">
                        <option value="" class="">1
                            /
                        </option>
                        <option value="" class="">2
                            /
                        </option>
                        <option value="" class="">3
                            /
                        </option>
                    </select>
                </li>
                <li class="am-pagination-next ">
                    <a href="javascript:;" class="" onclick="nextPage()">下一页</a>
                </li>
            </ul>
            <p style="text-align: center; font-size: 14px; color: #777">
                当前排序模式：最新上传(默认) <a href="javascript:;" data-am-modal="{target: '#select-mode'}">>>>选择其他模式</a>
            </p>
        </section>
        <section id="upload" style="display: none">
            <div class="am-form-group">
                <label for="doc-ds-ipt-1">标题/名字</label>
                <input type="text" id="post-title" class="am-form-field am-round" placeholder="最好是姓名哦">
            </div>
            <div style="margin-bottom: 10px">
                <i class="am-icon-picture-o"></i> 选择主图
            </div>
            <div id="main-photo-box" class="am-vertical-align">
                <div class="am-vertical-align-middle preview-box">
                    <i class="am-icon-plus-circle add-picture"  style="font-size: 40px;line-height: 120px;color: #17bcd4;"></i>
                    <div class="am-g" id="picture-preview-box" style="display: none">
                        <div class="am-u-sm-6" style="height: 100%;"><img id="picture-preview" src="" alt="图片预览"></div>
                        <div class="am-u-sm-6" id="analysis-div">
                            <p style="text-align: left"><i class="am-icon-eye"></i> 颜值：<span id="card-img-beauty-value">等待分析</span></p>
                            <p style="text-align: left"><i class="am-icon-smile-o"></i> 笑容：<span id="card-img-smile-value">等待分析</span></p>
                            <p style="text-align: left"><i class="am-icon-hashtag"></i> 人数：<span id="card-img-people-value">等待分析</span></p>
                            <p class="hint">注：AI分析结果仅供参考；无需分析结果也可提交；多人分析结果为平均颜值</p>
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

            <div style="margin-bottom: 10px">
                <i class="am-icon-picture-o"></i> 选择副图(选填,可多选,最多三张)
            </div>
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
            <button type="button" class="am-btn am-btn-primary  am-round" id="submit" onclick="submitNewPost()">确认提交</button>
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


    <div class="am-modal-actions" id="select-mode" style="display: none;">
        <div class="am-modal-actions-group">
            <ul class="am-list">
                <li><a href="#" onclick="switchMode('default')"><i class="am-icon-cloud-upload"></i> 最新上传(默认)</a></li>
                <li><a href="#" onclick="switchMode('votes')"><i class="am-icon-line-chart"></i> 最多投票</a></li>
                <li><a href="#" onclick="switchMode('beauty')"><i class="am-icon-eye"></i> 最高颜值</a></li>
                <li><a href="#" onclick="switchMode('popular')"><i class="am-icon-fire"></i> 最高人气</a></li>
            </ul>
        </div>
        <div class="am-modal-actions-group">
            <button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close>取消</button>
        </div>
    </div>



    <script id="post-tpl" type="text/html">
        {{each}}
        <div class="card">
            <div class="card-img">
                <div id="figure-{{$value.id}}" class="figure-div-box">
                    <figure data-am-widget="figure" class="am am-figure card-img-tag" data-am-figure="{  pureview: 'true' }">
                        <img class="lazy" data-original="images/upload/{{$value.main_photo}}" data-rel="images/upload/{{$value.main_photo}}" alt="{{$value.title}}"/>
                        {{each $value.second_photo val key}}
                            <img class="lazy" style="display: none" data-original="images/upload/{{val.name}}" data-rel="images/upload/{{val.name}}" alt="{{$value.title}}"/>
                        {{/each}}
                    </figure>
                </div>
                <div class="am-g card-img-info">
                    <div class="am-u-sm-4">
                        <p class="card-img-beauty"><i class="am-icon-eye"></i>颜值：{{$value.beauty}}</p>
                    </div>
                    <div class="am-u-sm-4">
                        <p class="card-img-hot"><i class="am-icon-smile-o"></i>笑容：{{$value.smile}}</p>
                    </div>
                    <div class="am-u-sm-4">
                        <p class="card-img-hot"><i class="am-icon-fire"></i>人气：{{$value.popular}}</p>
                    </div>
                </div>
            </div>
            <div class="tags">
                <span class="am-badge am-badge-warning am-text-sm img-num">{{$value.total_second_photo}}图</span>
            </div>
            <div class="card-desc">
                <p class="card-name">{{$value.id}}. {{$value.title}} <span class="votes">( {{$value.votes}}票 )</span></p>
                <p class="card-say">{{$value.say}}</p>
            </div>
            <div class="card-btn-group">
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-junxun" href="javascript:;" onclick="vote({{$value.id}})" role="button"><i class="am-icon-check-square-o"></i>{{$value.votes_text}}</a>
                    <a class="am-btn am-btn-junxun" href="javascript:;" onclick="comment({{$value.id}})" role="button"><i class="am-icon-th-list"></i>评论</a>
                    <a class="am-btn am-btn-junxun" href="share.php?id={{$value.id}}" role="button"><i class="am-icon-share-alt"></i>分享</a>
                </div>
            </div>
        </div>
        {{/each}}
    </script>

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
    <script src="https://cdn.bootcss.com/plupload/2.3.6/plupload.full.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
    <script src="https://cdn.bootcss.com/plupload/2.3.6/i18n/zh_CN.js"></script>
    <script src="js/lib/template-web.js"></script>
    <script src="js/lib/lazyload.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/photo.js"></script>
    <script>
        getPosts();
        getPages();
    </script>
</body>
</html>
