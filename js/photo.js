var isAnalysis = 0; // 是否完成分析
var main_picture = null; // 主图
var second_pictures = []; // 副图

var data = {
    "title": "",
    "main_picture": "",
    "say":"",
    "second_pictures":""
};

var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'main-photo-box',
    url : "php/fileUpload.php",
    unique_names : true,
    multi_selection:false,
    resize:{
        width: 600,
        quality: 90,
        preserve_headers:false
    },
    filters : {
        max_file_size: '5mb',
        mime_types: [
            {title: "Image files", extensions: "jpg,bmp,png,jpeg"}
        ]
    },
    // Flash settings
    flash_swf_url : 'https://cdn.bootcss.com/plupload/2.3.6/Moxie.swf',
    // Silverlight settings
    silverlight_xap_url : 'https://rawgithub.com/moxiecode/moxie/master/bin/silverlight/Moxie.cdn.xap',
    init: {
        PostInit: function() {

        },
        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                // console.log(file.id+","+file.name+","+plupload.formatSize(file.size));
                // console.log(files);
                var preloader = new moxie.image.Image();
                preloader.onload = function() {
                    preloader.downsize(300, 300); //先压缩一下要预览的图片,宽300，高300
                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                    $(".add-picture").css("display","none");
                    $("#picture-preview-box").css("display", "block");
                    $("#picture-preview").attr("src", imgsrc);
                    $("#detectFace").css("display", "block");
                    $("#detectFace").html('<i class="am-icon-search"></i> 开始分析颜值');
                    $("#card-img-beauty-value").text("");
                    $("#card-img-smile-value").text("");
                    startAnalysis();
                    preloader.destroy();
                    preloader = null;
                };
                preloader.onerror = function () {
                    console.log("图片预览失败");
                };
                preloader.load(file.getSource());

                isAnalysis = 0;

            });
        },
        UploadProgress: function(up, file) {
            $("#main-process-bar").css("display", "block");
            $("#main-process-bar-process").css("width", file.percent+"%").text(file.percent+"%");
        },
        UploadComplete: function(up, file){
            // 获取上传的文件名字
            // console.log(file);
            // console.log(file[0].target_name);
            layer.msg('上传成功，分析中');
            $("#main-process-bar").hide(500);
            // 开始分析
            main_picture = file[0].target_name;
            var data = {
                api:"detectFace",
                fileName:main_picture
            };

            submit_ajax(data, function (result) {
                $("#detectFace").html('<i class="am-icon-check"></i> 重新分析');
                // console.log(result);
                if (result.ret == 0){
                    layer.msg('分析成功');
                    $("#card-img-beauty-value").text(result.beauty);
                    $("#card-img-smile-value").text(result.smile);
                    isAnalysis = 1;
                } else{
                    layer.msg('分析失败，很有可能没有检测到人脸,请重试');
                }
            });
            up.removeFile(file[0]);
        },
        Error: function(up, err) {
            // document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            console.log("错误码："+ err.code+", "+ err.message);
            layer.msg("错误码："+ err.code+", "+ err.message);
        }
    }
});

uploader.init();

function startAnalysis(){
    $("#detectFace").html('<i class="am-icon-spinner am-icon-spin"></i> 分析中');
    uploader.start();
    return false;
}

document.getElementById('detectFace').onclick = function () {
    $("#detectFace").html('<i class="am-icon-spinner am-icon-spin"></i> 分析中');
    var data = {
        api:"detectFace",
        fileName:main_picture
    };
    submit_ajax(data, function (result) {
        $("#detectFace").html('<i class="am-icon-check"></i> 重新分析');
        // console.log(result);
        if (result.ret == 0){
            layer.msg('分析成功');
            $("#card-img-beauty-value").text(result.beauty);
            $("#card-img-smile-value").text(result.smile);
            isAnalysis = 1;
        } else{
            layer.msg('分析失败，很有可能没有检测到人脸,请重试');
        }
    });
};

function submit_ajax(data, callback) {
    $.ajax({
        url: "php/api.php",
        data:data,
        type:"POST",
        dataType: "JSON",
        success: callback
    });
}


// 多图上传
var old = [];
var mutil_uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'second-photo-box',
    url : "php/fileUpload.php",
    unique_names : true,
    multi_selection:true,
    resize:{
        width: 600,
        quality: 90,
        preserve_headers:false
    },
    filters : {
        max_file_size: '5mb',
        mime_types: [
            {title: "Image files", extensions: "jpg,bmp,png,jpeg"}
        ]
    },
    // Flash settings
    flash_swf_url : 'https://cdn.bootcss.com/plupload/2.3.6/Moxie.swf',
    // Silverlight settings
    silverlight_xap_url : 'https://rawgithub.com/moxiecode/moxie/master/bin/silverlight/Moxie.cdn.xap',
    init: {
        PostInit: function() {

        },
        Browse: function(up, files){
            // console.log(up); up.splice();
            old = up.files;
        },
        FilesAdded: function(up, files) {

            second_pictures = [];

            // 移除旧文件
            $.each(old, function (single) {
                up.removeFile(single);
            });

            $("#clearSecondPicture").css("display", "block");

            // console.log(up);
            var count = 0;
            resetMutilPicture();
            plupload.each(files, function(file) {
                // console.log(file.id+","+file.name+","+plupload.formatSize(file.size));
                // console.log(files);
                var preloader = new moxie.image.Image();
                preloader.onload = function() {
                    preloader.downsize(300, 300); //先压缩一下要预览的图片,宽300，高300
                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                    if (count == 0){
                        // 图一
                        $("#second-photo-box-1 div").html('<img id="picture-preview1" src="'+imgsrc+'" alt="图片预览">');
                        $("#second-photo-box-2 div").html('<i class="am-icon-plus-circle"></i>');
                    } else if (count == 1){
                        // 图二
                        $("#second-photo-box-2 div").html('<img id="picture-preview2" src="'+imgsrc+'" alt="图片预览">');
                        $("#second-photo-box-3 div").html('<i class="am-icon-plus-circle"></i>');
                    } else if (count == 2){
                        // 图三
                        $("#second-photo-box-3 div").html('<img id="picture-preview3" src="'+imgsrc+'" alt="图片预览">');
                    } else{
                        // 多余的图片删除掉
                        up.removeFile(files[count]);
                        layer.msg("最多能选择三张图片哦！");
                    }
                    count++;
                    preloader.destroy();
                    preloader = null;
                };
                preloader.onerror = function () {
                    console.log("图片预览失败");
                };
                preloader.load(file.getSource());

                isAnalysis = 0;

            });
        },
        UploadProgress: function(up, file) {
            $("#main-process-bar2").css("display", "block");
            $("#main-process-bar-process2").css("width", file.percent+"%").text(file.percent+"%");
        },
        UploadComplete: function(up, file){
            // 获取上传的文件名字
            for (var i = 0; i < file.length; i++){
                second_pictures.push(file[i].target_name);
            }
            $("#main-process-bar2").hide(500);
            data.second_pictures = window.second_pictures;
            up.splice();

            // 提交
            submitNewPost();
        },
        Error: function(up, err) {
            // document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            console.log("错误码："+ err.code+", "+ err.message);
            layer.msg("错误码："+ err.code+", "+ err.message);
        }
    }
});

function clearSecondPictures(){
    // mutil_uploader.each(mutil_uploader.files, function(file){
    //     mutil_uploader.removeFile(single);
    // });
    $("#clearSecondPicture").hide(500);
    mutil_uploader.splice();
    resetMutilPicture();
    second_pictures = [];
}

mutil_uploader.init();

// 提交成功后，重置所有设置
function resetAll() {
    isAnalysis = 0; // 是否完成分析
    main_picture = null; // 主图
    second_pictures = []; // 副图

    $("#card-img-beauty-value").text("等待分析");
    $("#card-img-smile-value").text("等待分析");

    $("#picture-preview-box").css("display","none");
    $(".add-picture").css("display","inline");

    data = {
        "title": "",
        "main_picture": "",
        "say":"",
        "second_pictures":""
    };

    // 重置多选的div
    resetMutilPicture();
}

function resetMutilPicture() {
    // 重置多选的div
    $("#second-photo-box-1 div").html('<i class="am-icon-plus-circle"></i>');
    $("#second-photo-box-2 div").html('<i class="am-icon-plus-circle"></i>');
    $("#second-photo-box-3 div").html('<i class="am-icon-plus-circle"></i>');
}

// 提交
function submitNewPost() {

    var title = $("#post-title").val();
    var say = $("#say").val();

    title = title.replace(/\s+/g,"");
    if (title == "" || title == " "){
        layer.msg("名字不能为空");
        return false;
    }

    if (title.length > 50){
        layer.msg("名字不能超过50个字");
        return false;
    }

    if (main_picture == null || main_picture == "") {
        layer.msg("请上传主图");
        return false;
    }

    if (say.length > 500){
        layer.msg("想说的太多了哦，不能超过500字");
        return false;
    }
    data.title = title;
    data.main_picture = main_picture;
    data.say = say;
    data.second_pictures = second_pictures;

    if (mutil_uploader.files.length > 0) {
        second_pictures = [];
        mutil_uploader.start();
    } else {
        // 直接提交
        console.log(data);
    }
}


// 统计字数
function count_words() {
    $("#word-count").text($("#say").val().length+"/500字");
}