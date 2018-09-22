var current_mode = "default";
var current_page = 1;

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
            $("#select-list").html('<option value="'+(i+1)+'" class="">'+(i+1)+' / '+result.total_pages+'</option>');
        }
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

    // 渲染组件
    var Amaze_template = Handlebars.compile('{{>figure}}');
    var data = {
            accordionData: {
                "className": "figure-item",
                "options": {
                    "figcaptionPosition": "bottom", // 图标标题位置 top - 图片上方， bottom - 图片下方
                    "zoomble": 'auto' // 是否启用图片缩放功能 ['auto'|true|false]
                    // 'auto' - 根据图片宽度自动判断，图大宽度大于窗口宽度时开启，否则不开启
                    // false 不开启；其他转型后非 false 的值，开启
                    // 此选项会作为 pureview 选项值 data-am-figure="{pureview: {{zoomable}} }"
                },
                "content": [
                    {
                        "img": "", // 图片（缩略图）路径
                        "rel": "", // 大图路径
                        "imgAlt": "", // 图片alt描述，如果为空则读取 figcaption
                        "figcaption": "" // 图片标题
                    }
                ]
            }
        };

    for (var i = 0; i < result.length; i++){
        var post_id = result[i].id;
        data.accordionData.content = [];
        var sub_content = {
            "img": "images/upload/"+result[i].main_photo, // 图片（缩略图）路径
            "rel": "images/upload/"+result[i].main_photo, // 大图路径
            "imgAlt": result[i].title, // 图片alt描述，如果为空则读取 figcaption
            "figcaption": result[i].title // 图片标题
        };
        data.accordionData.content.push(sub_content);

        if (result[i].second_photo.length > 0){
            for (var y = 0; y < result[i].second_photo.length; y++) {
                sub_content = {
                    "img": "images/upload/"+result[i].second_photo[y].name, // 图片（缩略图）路径
                    "rel": "images/upload/"+result[i].second_photo[y].name, // 大图路径
                    "imgAlt": result[i].title, // 图片alt描述，如果为空则读取 figcaption
                    "figcaption": result[i].title // 图片标题
                };
                data.accordionData.content.push(sub_content);
            }
        }
        console.log(data);
        var widget_html = Amaze_template(data.accordionData);
        $("#figure-"+post_id).html(widget_html);
        console.log(widget_html);
    }

    // 懒性加载
    $(".lazy").lazyload();
}


