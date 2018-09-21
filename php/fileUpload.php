<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-21
 * Time: 9:57
 */


if ((($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/bmp"))
    && ($_FILES["file"]["size"] < 50000000))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
    else
    {
        move_uploaded_file($_FILES["file"]["tmp_name"],
            "../images/upload/" .$_POST["name"]);
//        echo $_FILES["file"]["name"];
        echo "上传成功";
    }
}
else
{
    echo "文件无效";
}