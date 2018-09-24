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
    <link rel="icon" type="image/png" href="tieba.png">
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
            <header id="header-background">

            </header>
            <div class="am-input-group" id="search-div">
                <input type="text" id="keywords" class="am-form-field" placeholder="搜索名字">
                <span class="am-input-group-btn" onclick="search()">
                    <button class="am-btn am-btn-success" type="button"><span class="am-icon-search"></span> </button>
                </span>
            </div>
            <div class="am-g" id="statistics">
                <div class="am-u-sm-4">
                    <span id="statistics-photos">0</span>
                    <span>照片总数</span>
                </div>
                <div class="am-u-sm-4">
                    <span id="statistics-popular">0</span>
                    <span>人气总数</span>
                </div>
                <div class="am-u-sm-4">
                    <span id="statistics-votes">0</span>
                    <span>投票总数</span>
                </div>
            </div>
            <div id="card-box">

            </div>
            <div id="share-hint" style="display: none;">
                <div style="text-align: center; color: #777">
                    <p>分享该页面链接给小伙伴们帮忙拉票加油吧！</p>
                    <p>页面链接： <span class="red-text"><script>document.write(window.location.href)</script></span> </p>
                    <a href="index.php">查看更多照片</a>
                </div>
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
            <p style="text-align: center; font-size: 14px; color: #777">提示：点击图片可查看大图<br>多图可左右滑动切换下一张图</p>
            <p style="text-align: center; font-size: 14px; color: #777">
                当前排序模式：<span id="current-mode">最新上传(默认)</span> <a href="javascript:;" data-am-modal="{target: '#select-mode'}">>>>选择其他模式</a>
            </p>
            <a style=" text-align: center; display: block; " href="http://dq.tieba.com/f?kw=%E5%B9%BF%E8%A5%BF%E7%A7%91%E6%8A%80%E5%A4%A7%E5%AD%A6&ie=utf-8">
                <img data-original="images/tieba2.png" height="76" class="lazy" alt="广西科技大学吧" style=" width: auto; ">
                <p style="margin: 0">百度贴吧·广西科技大学吧出品</p>
            </a>
        </section>
        <section id="upload" style="display: none">
            <div class="am-form-group">
                <label for="doc-ds-ipt-1">标题/名字 <span class="red-text">*</span> </label>
                <input type="text" id="post-title" class="am-form-field am-round" placeholder="最好是姓名哦">
            </div>
            <div style="margin-bottom: 10px">
                <i class="am-icon-picture-o"></i> 选择主图 <span class="red-text">*</span>
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
                        </div>
                    </div>
                    <p class="hint">注：AI分析结果仅供参考；<br>无需分析结果也可提交；点击图片重新选择；</p>
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

            <div class="am-form-group">
                <label for="post-contact">联系方式</label>
                <input type="text" id="post-contact" class="am-form-field am-round" placeholder="手机号码或者QQ号，仅在获奖联系用">
            </div>

            <button type="button" class="am-btn am-btn-primary  am-round" id="submit" onclick="submitNewPost()">确认提交</button>
        </section>
        <section id="help" style="display: none">
            <section class="am-panel am-panel-primary">
                <header class="am-panel-hd">
                    <h3 class="am-panel-title">百度贴吧·广西科技大学吧出品</h3>
                </header>
                <div class="am-panel-bd">
                    <a style=" text-align: center; display: block; " href="http://dq.tieba.com/f?kw=%E5%B9%BF%E8%A5%BF%E7%A7%91%E6%8A%80%E5%A4%A7%E5%AD%A6&ie=utf-8">
                        <img data-original="images/tieba2.png" class="lazy" height="76" alt="广西科技大学吧" style=" width: auto; ">
                    </a>
                </div>
            </section>
            <section class="am-panel am-panel-secondary">
                <header class="am-panel-hd">
                    <h3 class="am-panel-title">活动详情</h3>
                </header>
                <div class="am-panel-bd" style=" text-align: center; ">
                    <p>这可能是你们人生中最后一次军训</p>
                    <p>也可能是印象最深刻的一次</p>
                    <p>大家可以</p>
                    <p>晒自己</p>
                    <p>晒闺蜜</p>
                    <p>晒基友</p>
                    <p>晒教官</p>
                    <p>怎么也得为这一次军训留下最美好的句号吧！</p>
                </div>
            </section>
            <section class="am-panel am-panel-success">
                <header class="am-panel-hd">
                    <h3 class="am-panel-title">活动规则</h3>
                </header>
                <div class="am-panel-bd">
                    <p>1. 活动期间，每天最多可给同一选手投 <span class="red-text">1</span> 票；</p>

                    <p>2. 报名提交的照片必须为本人照片，并且与军训主题有关，对因照片产生的纠纷由参赛者本人承担；</p>

                    <p>3. 活动截止至<span class="red-text">10月30日晚9：00</span>，活动结束前均可报名参加；</p>

                    <p>4. 违反规则的投票，主办方有权封ip，剔除非正常数据，取消选手资格等；</p>

                    <p>5. 活动对象：广西科技大学全校学生；</p>
                </div>
            </section>
            <section class="am-panel am-panel-success">
                <header class="am-panel-hd">
                    <h3 class="am-panel-title">使用帮助</h3>
                </header>
                <div class="am-panel-bd">
                    <p>仅支持照片格式JPG和PNG，不支持动图GIF。</p>
                    <p>点击分享按钮后，会跳转到新页面，把该页面链接分享到朋友圈，空间，群等，别人均可通过该链接直接看到被分享的照片，并且可以进行点赞，评论等操作，叫上亲戚朋友帮忙拉票吧！</p>
                    <p>上传照片界面，可点击图片重选新的照片。</p>
                    <p>该应用使用AI人工智能分析主图的数据，仅供参考。</p>
                    <p>如果AI分析照片失败，可以无视，填写姓名后，也可以提交照片。</p>
                    <p>AI能够识别同一张图片中最多人数是未知的，分析失败也可提交照片。</p>
                    <p>AI评分满分为 <span class="red-text">100</span> 分。</p>
                    <p>每张图片的大小不能超过 <span class="red-text">5Mb</span>。</p>
                    <p>如有不友善言论，可联系管理员QQ：<span class="red-text">597914752</span>，进行删除。</p>
                </div>
            </section>
            <section class="am-panel am-panel-danger">
                <header class="am-panel-hd">
                    <h3 class="am-panel-title">免责声明</h3>
                </header>
                <div class="am-panel-bd">
                    <p>1. 因照片产生的纠纷由参赛者本人承担</p>
                    <p>2. 如果发现自己的照片出现在网站上并且非本人上传，可联系管理员QQ：<span class="red-text">597914752</span>，进行删除。</p>
                    <p>3. 照片版权归照片本人所有。</p>
                </div>
            </section>
            <a href="https://pingxonline.com/"><p style=" text-align: center; font-size: 14px; color: #777; ">开发者博客：https://pingxonline.com/</p></a>
        </section>

    </main>
    <footer id="toolbar">
        <div class="am-btn-group am-btn-group-justify bottom-btns" style="box-shadow: 0px -1px 5px #989898;">
            <a class="am-btn am-btn-danger" role="button" href="javascript:;" onclick="switchMenu('homepage')"><i class="am-icon-home"></i><br>首页</a>
            <a class="am-btn am-btn-primary" role="button" href="javascript:;" onclick="switchMenu('upload')"><i class="am-icon-picture-o"></i><br>我要晒照</a>
            <a class="am-btn am-btn-success" role="button" href="javascript:;" onclick="switchMenu('help')"><i class="am-icon-question-circle-o"></i><br>活动介绍</a>
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
                        <p class="card-img-beauty"><i class="am-icon-eye"></i>颜值：{{$value.beauty}}分</p>
                    </div>
                    <div class="am-u-sm-4">
                        <p class="card-img-hot"><i class="am-icon-smile-o"></i>笑容：{{$value.smile}}分</p>
                    </div>
                    <div class="am-u-sm-4">
                        <p class="card-img-hot"><i class="am-icon-fire"></i>人气：{{$value.popular}}°C</p>
                    </div>
                </div>
            </div>
            <div class="tags">
                <span class="am-badge am-badge-warning am-text-sm img-num">{{$value.total_second_photo}}图</span>
            </div>
            <div class="card-desc">
                <p class="card-name">{{$value.id}}. {{$value.title}} <span class="votes" votes="{{$value.votes}}" id="show-votes-text-{{$value.id}}">( {{$value.votes}}票 )</span></p>
                <p class="card-say">{{$value.say}}</p>
            </div>
            <div class="card-btn-group">
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-junxun" href="javascript:;" onclick="vote({{$value.id}})" id="vote-btn-{{$value.id}}" role="button"><i class="am-icon-check-square-o"></i>{{$value.votes_text}}</a>
                    <a class="am-btn am-btn-junxun" href="javascript:;" id="comment-btn-{{$value.id}}" onclick="comment({{$value.id}})" role="button"><i class="am-icon-th-list"></i>{{$value.total_comment}} 评论</a>
                    <a class="am-btn am-btn-junxun" href="share.php?id={{$value.id}}" role="button"><i class="am-icon-share-alt"></i>分享</a>
                </div>
            </div>
            <div id="card-comment-{{$value.id}}" style="display: none">
                    <div class="comment-box" id="comment-box-{{$value.id}}" >
                        <p class="comment-hint">目前没有评论！快来抢沙发吧！</p>
                    </div>
                    <div class="am-g" style="text-align: center">
                        <div class="am-u-sm-6">
                            <button type="button" class="am-btn am-btn-primary" onclick="startComment({{$value.id}})"><i class="am-icon-commenting"></i> 我要评论</button>
                        </div>
                        <div class="am-u-sm-6">
                            <button type="button" class="am-btn am-btn-danger" onclick="closeCommentUI({{$value.id}})"><i class="am-icon-arrow-up"></i> 收起面板</button>
                        </div>
                    </div>
                    <ul data-am-widget="pagination" class="am-pagination am-pagination-select">
                        <li class="am-pagination-prev " onclick="CommentPrevPage({{$value.id}})">
                            <a href="javascript:;" class="">上一页</a>
                        </li>
                        <li class="am-pagination-select">
                            <select id="comment-select-page-{{$value.id}}" max-pages="0" onchange="CommentSelectPage({{$value.id}})">
                                <option value="1" class="">1
                                    /
                                </option>
                            </select>
                        </li>
                        <li class="am-pagination-next " onclick="CommentNextPage({{$value.id}})">
                            <a href="javascript:;" class="">下一页</a>
                        </li>
                    </ul>
            </div>

        </div>
        {{/each}}
    </script>


    <script id="comment-tpl" type="text/html">
        {{each}}
        <article class="am-comment">
            <a href="#link-to-user-home">
                <img src="tieba.png" alt="" class="am-comment-avatar" width="48" height="48"/>
            </a>

            <div class="am-comment-main"> <!-- 评论内容容器 -->
                <header class="am-comment-hd">
                    <div class="am-comment-meta"> <!-- 评论元数据 -->
                        <a href="#link-to-user" class="am-comment-author">{{$value.name}}</a> <!-- 评论者 -->
                        评论于 <time datetime="">{{$value.time}}</time>
                    </div>
                </header>

                <div class="am-comment-bd">{{$value.say}}</div> <!-- 评论内容 -->
            </div>
        </article>
        {{/each}}
    </script>


    <div class="am-modal am-modal-prompt" tabindex="-1" id="comment-modal">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">评论</div>
            <div class="am-modal-bd">
                <label for="comment-name">留个名字</label>
                <input type="text" class="am-modal-prompt-input" id="comment-name">
                <br>
                <label for="comment-say">说点什么</label>
                <input type="text" class="am-modal-prompt-input" id="comment-say">
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                <span class="am-modal-btn" data-am-modal-confirm>提交</span>
            </div>
        </div>
    </div>


    <div class="am-modal am-modal-confirm" tabindex="-1" id="submit-success-modal">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">提交成功！</div>
            <div class="am-modal-bd">
                提交成功啦！分享给小伙伴帮忙拉票加油吧
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                <span class="am-modal-btn" data-am-modal-confirm>分享一下</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
    <script src="https://cdn.bootcss.com/plupload/2.3.6/plupload.full.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
    <script src="https://cdn.bootcss.com/plupload/2.3.6/i18n/zh_CN.js"></script>
    <script src="https://cdn.bootcss.com/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
    <script src="js/lib/template-web.js"></script>
    <script src="js/lib/lazyload.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/photo.js"></script>
    <script>
        if (getUrlParam('id') != null){

            getPostByID(getUrlParam('id'));
            $("#share-hint").css("display","block");

        }else {
            getPosts();
            getPages();
            $("#share-hint").css("display","none");
        }

        getStatistics();
    </script>
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1274880510'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/stat.php%3Fid%3D1274880510' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>
