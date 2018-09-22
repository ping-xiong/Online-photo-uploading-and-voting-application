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
    var data = {
        'api':'search',
        'keywords':keywords
    };
    submit_ajax(data, function (result) {
        layer.msg("搜索完成");
        renderPosts(result);
    });
}