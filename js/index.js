var current_mode = "default";
var current_page = 1;
var max_pages = 1;

function hide_all() {
    $("#homepage").css("display", "none");
    $("#upload").css("display", "none");
    $("#help").css("display", "none");
}

function switchMenu(target) {
    hide_all();
    $("#"+target).css("display", "block");
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
    $(".lazy").lazyload();
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

        }else{
            layer.msg(result.msg);
        }
    });
}