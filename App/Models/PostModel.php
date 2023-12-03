<?php
class Post
{
  var $PostID = null;
  var $Content = null;
  var $Created_at = null;
  var $UserID = null;
  var $Show = null;

  public function getAllPost($id)
  {
    $db = new connect();
    $sql = "SELECT posts.* FROM posts
    LEFT JOIN follows ON posts.user_id = follows.user_id2 AND follows.user_id1 = '$id'
    WHERE posts.user_id = '$id' OR (follows.user_id1 = '$id' AND posts.show = 1)
    ORDER BY RAND();";
    return $db->pdo_query($sql);
  }

  public function getAllPostByUser($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM posts WHERE user_id = '$id' AND posts.show = 1 ORDER BY id DESC";
    return $db->pdo_query($sql);
  }

  public function getPostById($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM posts WHERE id = '$id' AND show = 1";
    return $db->pdo_query_one($sql);
  }

  public function insertPost($content, $user_id)
  {
    $db = new connect();
    $sql = "INSERT INTO posts(content,user_id) VALUES ('$content', '$user_id')";
    return $db->pdo_execute($sql);
  }

  public function updatePost($post_id, $content)
  {
    $db = new connect();
    $sql = "UPDATE posts SET posts.content = '$content' WHERE id = '$post_id'";
    return $db->pdo_execute($sql);
  }

  public function deletePost($id)
  {
    $db = new connect();
    $sql = "UPDATE posts SET posts.show = 0 WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
