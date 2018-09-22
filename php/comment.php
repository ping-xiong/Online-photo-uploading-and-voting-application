<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-22
 * Time: 17:21
 */

// 评论

class comment
{
    /**
     * @var mysqli $link
     */
    private $link;

    public function __construct($newLink)
    {
        $this->link = $newLink;
    }

    public function getComments($post_id, $page){
        $max_posts_each_page = config::$homepage['max_comment_each_post'];
        $start = ($page-1)*$max_posts_each_page;
        $sql = "SELECT * FROM `junxun_comment` WHERE `topic_id` = {$post_id} ORDER BY time DESC LIMIT {$start},{$max_posts_each_page}";
        $result = mysqli_query($this->link, $sql);
        $this->output($result);
    }

    private function output($result){
        $comments_arr = [];
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)){
            $comments_arr[$count]['name'] = $result['name'];
            $comments_arr[$count]['say'] = $result['say'];
            $comments_arr[$count]['time'] = $result['time'];
        }

        echo json_encode($comments_arr);

    }


    public function getCommentPages($post_id){
        // 获取页数
        $sql = "SELECT COUNT(*) as total FROM `junxun_comment` WHERE `topic_id` = {$post_id}";
        $result = mysqli_query($this->link, $sql);
        $row = mysqli_fetch_assoc($result);
        // 总个数
        $total = $row['total'];
        // 总页数
        $total_pages = ceil($total/config::$homepage['max_comment_each_post']);
        $data = [
            "total"=>$total,
            "total_pages"=>$total_pages
        ];
        echo json_encode($data);
    }

    // 提交评论
    public function submitComment($post_id, $name, $say, $ip){
        $sql = "INSERT INTO `junxun_comment`(`topic_id`, `name`, `say`, `ip`) VALUES ({$post_id}, '{$name}', '{$say}', '{$ip}')";
        mysqli_query($this->link, $sql);
        $ret = [
            "ret"=>0,
            "msg"=>"评论成功"
        ];
        echo json_encode($ret);
    }
}