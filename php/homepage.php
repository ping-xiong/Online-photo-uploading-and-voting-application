<?php
/**
 * Created by PhpStorm.
 * User: l5979
 * Date: 2018-09-22
 * Time: 11:39
 */

class homepage
{
    private $link;
    public function __construct($newLink)
    {
        $this->link = $newLink;
    }

    /**
     * @param $mode
     * @param $page
     * @param $max_posts_each_page
     */
    public function getPosts($mode, $page, $max_posts_each_page){
        $start = ($page-1)*$max_posts_each_page;
        $sql = "SELECT * FROM `junxun_photo` WHERE `is_check` = 1 ORDER BY time DESC LIMIT {$start},{$max_posts_each_page}";
        switch ($mode){
            case 'default':
                $sql = "SELECT * FROM `junxun_photo` WHERE `is_check` = 1 ORDER BY time DESC LIMIT {$start},{$max_posts_each_page}";
                break;

            case 'votes':
                $sql = "SELECT * FROM `junxun_photo` WHERE `is_check` = 1 ORDER BY votes DESC LIMIT 0,20";
                break;

            case 'beauty':
                $sql = "SELECT * FROM `junxun_photo` WHERE `is_check` = 1 ORDER BY beauty DESC LIMIT 0,20";
                break;

            case 'popular':
                $sql = "SELECT * FROM `junxun_photo` WHERE `is_check` = 1 ORDER BY popular DESC LIMIT 0,20";
                break;
        }

        $result = mysqli_query($this->link, $sql);
        $this->output($result);
    }


    // 搜索
    public function search($keywords){
        $sql = "SELECT * FROM `junxun_photo` WHERE `is_check` = 1 AND `title` LIKE '%{$keywords}%' ORDER BY time DESC";
        $result = mysqli_query($this->link, $sql);
        $this->output($result);
    }

    // 获取副图

    /**
     * @param $id int
     * @return array
     */
    private function getSecondPictures($id){
        $sql = "SELECT * FROM `junxun_second_photo` WHERE `topic_id` = $id";
        $result = mysqli_query($this->link, $sql);
        $second = [];
        while ($row = mysqli_fetch_assoc($result)){
            $second[]['name'] = $row['name'];
        }
        return $second;
    }

    // 直接输出
    private function output($result){
        $data = [];
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)){
            $data[$count]['id'] = $row['id'];
            $data[$count]['title'] = $row['title'];
            $data[$count]['main_photo'] = $row['main_photo'];
            $data[$count]['second_photo'] = $this->getSecondPictures($row['id']);
            $data[$count]['total_second_photo'] = count($data[$count]['second_photo'])+1;
            $data[$count]['say'] = $row['say'];
            $data[$count]['beauty'] = $row['beauty'];
            $data[$count]['smile'] = $row['smile'];
            $data[$count]['popular'] = $row['popular'];
            $data[$count]['votes'] = $row['votes'];
            $data[$count]['time'] = $row['time'];
            $count++;
        }
        echo json_encode($data);
    }

}