<?php
class Likes
{
    var $ID = null;
    var $User_id = null;
    var $Post_id = null;

    // Hàm like
    public function like($user_id, $post_id)
    {
        $db = new connect();
        $sql = "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)";
        return $db->pdo_execute($sql);
    }

    // Hàm unlike
    public function unlike($user_id, $post_id)
    {
        $db = new connect();
        $sql = "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id";
        return $db->pdo_execute($sql);
    }

    // Hàm Check Like
    public function checklike($user_id, $post_id)
    {
        $db = new connect();
        $sql = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
        return $db->pdo_query_one($sql);
    }

    // Hàm đếm số lượt like của 1 bài viết
    public function countPhotoByLike($post_id)
    {
        $db = new connect();
        $sql = "SELECT COUNT(post_id) AS number_like FROM likes
        WHERE post_id = '$post_id'";
        return $db->pdo_query_value($sql);
    }

    public function getIdUserByIdLike($post_id)
    {
        $db = new connect();
        $sql = "SELECT user_id FROM likes WHERE post_id = '$post_id'";
        return $db->pdo_query($sql);
    }
}
?>
