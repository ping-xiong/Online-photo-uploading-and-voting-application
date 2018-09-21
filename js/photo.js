var isAnalysis = 0; // 是否完成分析

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
            console.log(file);
            console.log(file[0].target_name);
            layer.msg('上传成功，分析中');
            $("#main-process-bar").hide(500);
            // 开始分析
            var data = {
                api:"detectFace",
                fileName:file[0].target_name
            };
            submit_ajax(data, function (result) {
                $("#detectFace").html('<i class="am-icon-check"></i> 分析完成');
                console.log(result);
                if (result.ret == 0){
                    layer.msg('分析成功');
                    var beauty = "";
                    var smile = "";
                    for (var i = 0; i < result.data.face_list.length; i++) {

                        if (i == 0){
                            beauty = result.data.face_list[i].beauty+"分";
                            smile = result.data.face_list[i].expression+"分";
                        } else{
                            beauty += ", "+result.data.face_list[i].beauty+"分";
                            smile += ", "+result.data.face_list[i].expression+"分";
                        }
                    }
                    $("#card-img-beauty-value").text(beauty);
                    $("#card-img-smile-value").text(smile);
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

document.getElementById('detectFace').onclick = function() {
    $("#detectFace").html('<i class="am-icon-spinner am-icon-spin"></i> 分析中');
    uploader.start();
    return false;
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