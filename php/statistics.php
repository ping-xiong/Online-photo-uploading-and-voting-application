<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-23
 * Time: 10:56
 */

class statistics
{
    // 图片数量，包括主图和副图
    public static function getTotalPosts($link){
        $sql = "SELECT COUNT(*) as total FROM `junxun_photo` WHERE `is_check` = 1";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_main_picture = $row['total'];

        // 副图数量
        $sql = "SELECT COUNT(*) as total FROM `junxun_second_photo`";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_second_picture = $row['total'];

        $total = (int)$total_main_picture + (int)$total_second_picture;
        return $total;
    }

    // 总投票数量
    public static function getTotalVotes($link){
        $sql = "SELECT COUNT(*) as total FROM `junxun_votes`";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];
        return (int)$total;
    }

    // 总人气
    public static function getTotalPopular($link){
        $sql = "SELECT SUM(`popular`) AS total FROM `junxun_photo` WHERE `is_check` = 1";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];
        return (int)$total;
    }
}