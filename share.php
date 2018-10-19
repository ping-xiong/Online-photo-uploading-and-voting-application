<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-23
 * Time: 20:33
 */


if (isset($_GET['id']) && isset($_GET['id']) != 0){

    header("Location: index.php?id=".$_GET['id']);

}else{
    // 假装分享成功
    echo "分享成功";
}
