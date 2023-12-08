<?php
class Stories
{
    var $id = null;
    var $image = null;
    var $created_at = null;
    var $user_id = null;
    var $show = null;

    // Hiện danh sách stories với thông tin người dùng
    public function getStoriesWithUsers($user_id)
    {
        $db = new connect(); // Kết nối cơ sở dữ liệu
        $query = "SELECT stories.*, users.first_name, users.last_name 
                    FROM stories 
                    LEFT JOIN users ON stories.user_id = users.id 
                    WHERE stories.user_id = $user_id AND stories.show = 1";
        $result = $db->pdo_query($query);
        return $result;
    }

    // Hiện danh sách stories với thông tin người dùng
    public function getStoriesNotWithUsers($user_id)
    {
        $db = new connect(); // Kết nối cơ sở dữ liệu
        $query = "SELECT stories.*, users.first_name, users.last_name 
                    FROM stories 
                    LEFT JOIN users ON stories.user_id = users.id 
                    WHERE stories.user_id != $user_id AND stories.show = 1";
        $result = $db->pdo_query($query);
        return $result;
    }

    public function getStoriesByUserIdWithUserInfo($user_id)
    {
        $db = new connect();
        $query = "SELECT s.*, u.first_name, u.last_name 
                    FROM stories s
                    INNER JOIN users u ON s.user_id = u.id
                    WHERE s.`show` = 1";

        $result = $db->pdo_query($query);
        return $result;
    }

    public function getUserIdByStory($id)
    {
        $db = new connect();
        $query = "SELECT user_id FROM stories WHERE id ='$id'";
        $result = $db->pdo_query_value($query);
        return $result;
    }

    // Ẩn story dựa trên ID
    public function hideStory($story_id)
    {
        $db = new connect();
        $query = "UPDATE stories SET `show` = 0 WHERE `id` = $story_id";
        // Thực hiện cập nhật trạng thái ẩn của story trong cơ sở dữ liệu
        $result = $db->pdo_execute($query);
        return $result;
    }

    // kiểm tra user_id và story có cùng 1 người đăng
    public function checUser($story_id, $user_id)
    {
        $db = new connect();
        $query = "SELECT * FROM stories WHERE `id` = $story_id AND `user_id` = $user_id";
        $result = $db->pdo_query_one($query);
        return $result;
    }

    //Thêm bài post
    public function createStory($user_id, $image)
    {
        $db = new connect();
        $query = "INSERT INTO stories (`user_id`, `image_url`) VALUES ('$user_id','$image')";
        // Thực hiện chèn bài viết mới vào cơ sở dữ liệu
        $result = $db->pdo_execute($query);
        return $result;
    }
}
