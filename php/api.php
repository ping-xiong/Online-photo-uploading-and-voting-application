<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-21
 * Time: 9:27
 */
ini_set('session.gc_maxlifetime', 43200); //设置时间，12小时过期

session_start();

if (!isset($_SESSION['max_upload_posts'])){
    $_SESSION['max_upload_posts'] = 0;
}

// 投票记录
if (!isset($_SESSION['votes'])){
    $_SESSION['votes'] = [];
}

include_once 'connect.php';
include_once "DetectFace.php";
include_once "config.php";

// 是否为post请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new connectDataBase();
    if (!isset($_POST['api'])){
        echo "提交成功";
        die();
    }
    $api = $db->test_input($_POST['api']);
    switch ($api){
        case 'detectFace':
            // 人脸检测
            $fileName = $db->test_input($_POST['fileName']);
            if(config::$detectFace['open']){
                $result = detectFace::detect(config::$detectFace['img_path'].$fileName);
                // 提取需要的属性
                $data = json_decode($result);
                if ($data->ret == 0){
                    $beauty = 0;
                    $smile = 0;
                    $people = 0;
                    for ($i = 0; $i < count($data->data->face_list); $i++){
                        $beauty += $data->data->face_list[$i]->beauty;
                        $smile += $data->data->face_list[$i]->expression;
                        $people++;
                    }
                    $avg_beauty = number_format($beauty/$people, 2);
                    $avg_smile = number_format($smile/$people, 2);
                    $final = [
                        "ret"=>$data->ret,
                        "beauty"=>$avg_beauty,
                        "smile"=>$avg_smile,
                        "people"=>$people
                    ];
                    $_SESSION['beauty'] = $avg_beauty;
                    $_SESSION['smile'] = $avg_smile;
                }else{
                    $_SESSION['beauty'] = 0;
                    $_SESSION['smile'] = 0;
                    $final = [
                        "ret"=>$data->ret
                    ];
                }
                echo json_encode($final);
            }else{
                $_SESSION['beauty'] = 0;
                $_SESSION['smile'] = 0;
                $final = [
                    "ret"=>""
                ];
                 echo json_encode($final);
            }
            
            break;
        case 'submit':

            if (isset($_SESSION['max_upload_posts']) && $_SESSION['max_upload_posts'] > config::$homepage['max_upload_post']){
                $ret = [
                    "ret"=>1,
                    "msg"=>"您在今天发布已超过限制，请明天再来"
                ];
                echo json_encode($ret);
                die();
            }

            $title = $db->test_input($_POST['title']);
            $say = $db->test_input($_POST['say']);
            $contact = $db->test_input($_POST['contact']);
            $main_picture = $db->test_input($_POST['main_picture']);
            if (isset($_SESSION['beauty'])){
                $beauty = $_SESSION['beauty'];
            }else{
                $beauty = 0;
            }
            if (isset($_SESSION['smile'])){
                $smile = $_SESSION['smile'];
            }else{
                $smile =0;
            }

            $ip = $db->getIP();

            $sql = "INSERT INTO `junxun_photo`(`title`, `main_photo`, `say`, `beauty`, `smile`, `contact`,`ip`) VALUES ('{$title}', '{$main_picture}', '{$say}', {$beauty}, {$smile}, '{$contact}','{$ip}')";
            mysqli_query($db->link, $sql);
            $new_post_id = mysqli_insert_id($db->link);

            $insert_id = mysqli_insert_id($db->link);
            if (isset($_POST['second_pictures'])){
                $second_pictures = $_POST['second_pictures'];
                if (count($second_pictures) > 0){
                    for ($i = 0; $i < count($second_pictures); $i++){
                        $name = $second_pictures[$i];
                        $sql = "INSERT INTO `junxun_second_photo`( `topic_id`, `name`) VALUES ({$insert_id}, '{$name}')";
                        mysqli_query($db->link, $sql);
                    }
                }
            }

            // 重置 状态
            $_SESSION['beauty'] = 0;
            $_SESSION['smile'] = 0;

            // 加1
            $_SESSION['max_upload_posts'] += 1;

            $ret = [
                "ret"=>0,
                "msg"=>"提交成功",
                "post_id"=>$new_post_id
            ];
            echo json_encode($ret);
            break;
        case 'homepage':
            // 浏览数据
            include_once "homepage.php";
            $homepage = new homepage($db->link);
            $mode = $db->test_input($_POST['mode']);
            $page = $db->test_input($_POST['page']);
            $max_posts_each_page = config::$homepage['max_posts_each_page'];

            $homepage->getPosts($mode, $page, $max_posts_each_page);

            break;
        case 'pages':
            // 获取页数
            $sql = "SELECT COUNT(*) as total FROM `junxun_photo` WHERE `is_check` = 1";
            $result = mysqli_query($db->link, $sql);
            $row = mysqli_fetch_assoc($result);
            // 总个数
            $total = $row['total'];
            // 总页数
            $total_pages = ceil($total/config::$homepage['max_posts_each_page']);
            $data = [
                "total"=>$total,
                "total_pages"=>$total_pages
            ];
            echo json_encode($data);
            break;
        case 'search':
            // 搜索
            include_once "homepage.php";
            $homepage = new homepage($db->link);
            $keywords = $db->test_input($_POST['keywords']);
            $homepage->search($keywords);
            break;
        case 'votes':
            // 投票
            $post_id = $db->test_input($_POST['post_id']);
            $ip = $db->getIP();

            addPopular($db->link, $post_id);

            if (in_array($post_id, $_SESSION['votes'])){
                $ret = [
                    "ret"=>1,
                    "msg"=>"您已投票，请过一段时间试试"
                ];
                echo json_encode($ret);
            }else{
                $sql = "INSERT INTO `junxun_votes`(`ip`, `post_id`) VALUES ('{$ip}', {$post_id})";
                mysqli_query($db->link, $sql);
                $sql = "UPDATE `junxun_photo` SET `votes`=`votes`+1 WHERE `id` = {$post_id}";
                mysqli_query($db->link, $sql);

                $_SESSION['votes'][] = $post_id;

                $ret = [
                    "ret"=>0,
                    "msg"=>"投票成功"
                ];
                echo json_encode($ret);
            }
            break;
        case 'getComments':
            // 获取评论
            include_once 'comment.php';
            $comment = new comment($db->link);
            $post_id = $db->test_input($_POST['post_id']);
            $page = $db->test_input($_POST['page']);
            $comment->getComments($post_id, $page);

            addPopular($db->link, $post_id);
            break;
        case 'comment':
            // 评论
            include_once 'comment.php';
            $comment = new comment($db->link);
            $post_id = $db->test_input($_POST['post_id']);
            $name = $db->test_input($_POST['name']);
            $say = $db->test_input($_POST['say']);
            $ip = $db->getIP();
            $comment->submitComment($post_id, $name, $say, $ip);

            addPopular($db->link, $post_id);
            break;
        case 'getCommentPage':
            // 获取评论页数
            include_once 'comment.php';
            $comment = new comment($db->link);
            $post_id = $db->test_input($_POST['post_id']);
            $comment->getCommentPages($post_id);

            addPopular($db->link, $post_id);
            break;
        case 'statistics':
            // 基本统计
            include_once "statistics.php";
            $arr['photo'] = statistics::getTotalPosts($db->link);
            $arr['popular'] = statistics::getTotalPopular($db->link);
            $arr['vote'] = statistics::getTotalVotes($db->link);

            echo json_encode($arr);
            break;
        case 'share':
            // 分享
            $post_id = $db->test_input($_POST['post_id']);
            include_once  'homepage.php';
            $homepage = new homepage($db->link);
            addPopular($db->link, $post_id);
            $homepage->getPostById($post_id);
            break;
        default:
            echo "提交成功";
    }

}else{
    echo "提交成功";
}


// 加人气
function addPopular($link, $post_id){
    $sql = "UPDATE `junxun_photo` SET `popular`=`popular`+1 WHERE `id` = {$post_id}";
    mysqli_query($link, $sql);
}
