
//plupload中为我们提供了mOxie对象
//有关mOxie的介绍和说明请看：https://github.com/moxiecode/moxie/wiki/API
//如果你不想了解那么多的话，那就照抄本示例的代码来得到预览的图片吧
function previewImage(file, callback) { //file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
    //if(!file || !/image\//.test(file.type)) return; //确保文件是图片
    console.log("图片处理");
    var preloader = new moxie.image.Image();
    preloader.onload = function() {
        console.log("载入完成");
        preloader.downsize(300, 300); //先压缩一下要预览的图片,宽300，高300
        var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
        console.log(imgsrc);
        callback && callback(imgsrc); //callback传入的参数为预览图片的url
        preloader.destroy();
        preloader = null;
    };
    preloader.onerror = function () {
        console.log("图片预览失败");
    };
    preloader.load(file.getSource());
}

var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',

    browse_button : 'main-photo-box', // you can pass in id...
   // container: document.getElementById('main-photo-box'), // ... or DOM Element itself

    url : "php/fileUpload.php",
    multi_selection:false,
    unique_names:true,
    resize:{
        width: 600,
        quality: 80,
        preserve_headers:false
    },
    filters : {
        max_file_size : '5mb',
        mime_types: [
            {title : "图片文件", extensions : "jpg,bmp,png,jpeg"}
        ]
    },

    // Flash settings
    flash_swf_url : 'https://cdn.bootcss.com/plupload/3.1.2/Moxie.swf',

    // Silverlight settings
    silverlight_xap_url : 'https://rawgithub.com/moxiecode/moxie/master/bin/silverlight/Moxie.cdn.xap',

    init: {
        PostInit: function() {

        },

        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                // document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                // console.log(file.id+","+file.name+","+plupload.formatSize(file.size));
                // console.log(files);
                // $("#picture-preview").html("");
                var preloader = new moxie.image.Image();
                preloader.onload = function() {
                    preloader.downsize(300, 300); //先压缩一下要预览的图片,宽300，高300
                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                    $(".add-picture").css("display","none");
                    $("#picture-preview").attr("src", imgsrc).css("display", "block");

                    preloader.destroy();
                    preloader = null;
                };
                preloader.onerror = function () {
                    console.log("图片预览失败");
                };
                preloader.load(file.getSource());

            });
        },

        UploadProgress: function(up, file) {
            // document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            $("#main-process-bar").css("display", "block");
            $("#main-process-bar-process").css("width", file.percent+"%").text(file.percent+"%");
        },

        UploadComplete: function(up, file){
            layer.msg('上传成功');
            $("#main-process-bar").hide(500);
        },

        Error: function(up, err) {
            // document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            console.log("错误码："+ err.code+", "+ err.message);
        }
    }
});

uploader.init();

document.getElementById('detectFace').onclick = function() {
    uploader.start();
    return false;
};