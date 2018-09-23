var current_mode = "default";
var current_page = 1;
var max_pages = 1;
var commentPages = []; // 记录评论的页数

function hide_all() {
    $("#homepage").css("display", "none");
    $("#upload").css("display", "none");
    $("#help").css("display", "none");
}

function switchMenu(target) {
    hide_all();
    $("#"+target).css("display", "block");
    $('html, body').animate({scrollTop: 0}, '500');
    if (target == "homepage"){
        getPosts();
    }
}


// 更改模式
function switchMode(newMode) {
    current_mode = newMode;
    var mode_name = "最新上传(默认)";
    switch (current_mode) {
        case 'default':
            mode_name = "最新上传(默认)";
            break;
        case 'votes':
            mode_name = "最多投票";
            break;

        case 'beauty':
            mode_name = "最高颜值";
            break;

        case 'popular':
            mode_name = "最高人气";
            break;
    }
    $("#current-mode").text(mode_name);
    getPosts();
}

// 获取所有页数
function getPages() {
    var data={
        api:"pages"
    };
    $("#select-list").html("");
    submit_ajax(data, function (result) {
        for (var i= 0; i < result.total_pages; i++){
            $("<option>").attr('value', i+1).text((i+1)+' / '+result.total_pages).appendTo("#select-list");
            // $("#select-list").html('<option value="'+(i+1)+'" class="">'+(i+1)+' / '+result.total_pages+'</option>');
        }
        max_pages = result.total_pages;
    });
}

// 获取帖子
function getPosts() {

    if (getUrlParam('id') != null){
        // 修改URL
        // updateURL();
        window.location.href = "index.php";
        $("#share-hint").css("display","none");
    }

    var data = {
      'api':"homepage",
      'mode':current_mode,
      'page':current_page
    };

    submit_ajax(data, function (result) {
        renderPosts(result);
    });
}

// 渲染
function renderPosts(result) {
    var html = template("post-tpl",result);
    document.getElementById("card-box").innerHTML=html;
    AMUI.figure.init();
    // 懒性加载
    $(".lazy").lazyload({
        effect : "fadeIn"
    });
}


// 下一页
function nextPage() {
    if (current_page < max_pages){
        current_page++;
        getPosts();
        updateSelectPages();
    } else{
        layer.msg("后面没有咯");
    }
}

// 上一页
function previousPage() {
    if (current_page > 1){
        current_page--;
        getPosts();
        updateSelectPages();
    } else{
        layer.msg("前面没有咯");
    }
}

// 更新当前选择
function updateSelectPages() {
    $("#select-list").val(current_page);
}

// 下拉选择页数
function selectPages() {
    current_page = $("#select-list").val();
    getPosts();
}

// 搜索
function search() {
    var keywords = $("#keywords").val();

    keywords = keywords.replace(/\s+/g,"");
    if (keywords == ""){
        layer.msg("请输入关键词");
        return;
    }

    var data = {
        'api':'search',
        'keywords':keywords
    };
    submit_ajax(data, function (result) {
        layer.msg("搜索完成");
        renderPosts(result);
    });
}

// 投票
function vote(id) {
    var data = {
        'api':"votes",
        'post_id':id
    };
    submit_ajax(data, function (result) {
        if (result.ret == 0) {
            layer.msg(result.msg);
            var target_vote_ele = $("#show-votes-text-"+id);
            var currentVotes = parseInt(target_vote_ele.attr("votes"));
            currentVotes++;
            target_vote_ele.text("( "+currentVotes+"票 )");
            $("#vote-btn-"+id).html('<i class="am-icon-check-square-o"></i>已投');
        }else{
            layer.msg(result.msg);
        }
    });
}

// 打开评论窗口
function comment(post_id) {
    // $("#card-comment-"+post_id).toggle(500);
    $("#card-comment-"+post_id).slideDown();
    $("#comment-btn-"+post_id).attr("onclick", "closeComment("+post_id+")");
    $.scrollTo('#comment-box-'+post_id,500);
    getCommentPages(post_id);
    getComments(post_id, 1);
}

function closeComment(post_id) {
    $("#comment-btn-"+post_id).attr("onclick", "comment("+post_id+")");
    $("#card-comment-"+post_id).slideUp();
    $.scrollTo('#figure-'+post_id,500);
}


// 关闭评论窗口
function closeCommentUI(post_id) {
    $("#card-comment-"+post_id).slideUp();
    $("#comment-btn-"+post_id).attr("onclick", "comment("+post_id+")");
    $.scrollTo('#figure-'+post_id,500);
}

// 获取评论页数
function getCommentPages(post_id) {
    var data = {
        'api':"getCommentPage",
        'post_id':post_id
    };
    submit_ajax(data, function (result) {
        // 渲染选项
        var comment_select_page = $("#comment-select-page-"+post_id);
        comment_select_page.html("");
        for (var i=0; i < result.total_pages; i++){
            $("<option>").attr('value', (i+1)).text((i+1)+"/"+result.total_pages).appendTo("#comment-select-page-"+post_id);
        }
        comment_select_page.attr("max-pages", result.total_pages);
    });
}

// 获取评论
function getComments(id, page) {
    var data = {
        'api':"getComments",
        'post_id':id,
        'page':page
    };
    submit_ajax(data, function (result) {
        var html = template("comment-tpl",result);
        if (result.length == 0){

        } else{
            document.getElementById("comment-box-"+id).innerHTML=html;
            // $.scrollTo('#comment-box-'+id,500);
        }
    });
}

// 获取评论当前页数
function getCurrentCommentPage(id) {
    return $("#comment-select-page-"+id).val();
}
// 记录评论当前页数
function setCurrentCommentPage(id, page) {
    $("#comment-select-page-"+id).val(page);
}
// 获取总页数
function getTotalCommentPages(id) {
    return $("#comment-select-page-"+id).attr("max-pages");
}

// 上一页
function CommentPrevPage(id) {
    var cPage = getCurrentCommentPage(id);
    if (cPage > 1){
        cPage--;
        getComments(id, cPage);
        setCurrentCommentPage(id, cPage);
        $.scrollTo('#comment-box-'+id,500);
    } else{
        layer.msg("前面没有咯");
    }
}

// 下一页
function CommentNextPage(id) {
    var cPage = getCurrentCommentPage(id);
    var total_pages = getTotalCommentPages(id);
    if (cPage < total_pages){
        cPage++;
        getComments(id, cPage);
        setCurrentCommentPage(id, cPage);
        $.scrollTo('#comment-box-'+id,500);
    } else{
        layer.msg("后面没有咯");
    }
}

// 评论选择页数
function CommentSelectPage(id) {
    var cPage = getCurrentCommentPage(id);
    getComments(id, cPage);
    setCurrentCommentPage(id, cPage);
}

// 弹出评论框
function startComment(id) {
    $('#comment-modal').modal({
        relatedTarget: this,
        onConfirm: function(e) {
            if (e.data[1] == ""){
                // 为空
                layer.msg("评论内容不能为空哦");
            } else{
                var name = e.data[0];
                var say = e.data[1];
                var data = {
                  'api':'comment',
                    'post_id':id,
                    'name':name,
                    'say':say
                };
                submit_ajax(data, function (result) {
                    if (result.ret == 0){
                        layer.msg(result.msg);
                        getComments(id, 1);
                    } else{
                        layer.msg("评论失败，请重试")
                    }
                });

                // $("#comment-name").val("");
                $("#comment-say").val("");
            }
        },
        onCancel: function(e) {
            // $("#comment-name").val("");
            $("#comment-say").val("");
        }
    });
}


// 获取统计
function getStatistics() {
    var data = {
      'api':"statistics"
    };

    submit_ajax(data, function (result) {
        $("#statistics-photos").text(result.photo);
        $("#statistics-votes").text(result.vote);
        $("#statistics-popular").text(result.popular);
    });
}

// 获取url参数
//获取RUL参数值
function getUrlParam(name) {               /*?videoId=identification  */
    var params = decodeURI(window.location.search);        /* 截取？号后面的部分    index.html?act=doctor,截取后的字符串就是?act=doctor  */
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = params.substr(1).match(reg);
    if (r!=null) return unescape(r[2]); return null;
}

// 获取某个id的数据
function getPostByID(id) {
    var data = {
        'api':'share',
        'post_id':id
    };
    submit_ajax(data, function (result) {
        renderPosts(result);
    });
}

// 获取当前url
function getFullURL() {
    return window.location.protocol+"//"+window.location.host+"/"+window.location.pathname;
}

// 更新url
function updateURL() {
    url = getFullURL();
    console.log(getFullURL());
    var state = {
        title: document.title,
        url: url,
        otherkey: ""
    };
    window.history.pushState(state, document.title, url);
}