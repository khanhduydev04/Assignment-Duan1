<?php
class Comment
{
  var $Content = null;
  var $Parent_id = null;
  var $UserID = null;
  var $PostID = null;

  public function getCommentByPost($id, $parent_id)
  {
    $db = new connect();
    $sql = "SELECT * FROM comments WHERE post_id = '$id' AND parent_id = '$parent_id' ORDER BY id DESC";
    return $db->pdo_query($sql);
  }

  public function countCommentByPost($id)
  {
    $db = new connect();
    $sql = "SELECT COUNT(*) FROM comments WHERE post_id = '$id'";
    return $db->pdo_query_value($sql);
  }

  public function getUserCommentId($id)
  {
    $db = new connect();
    $sql = "SELECT comments.user_id FROM comments WHERE id = '$id'";
    return $db->pdo_query_value($sql);
  }

  public function insertComment($content, $parent_id, $user_id, $post_id)
  {
    $db = new connect();
    $sql = "INSERT INTO comments(content,parent_id,user_id,post_id) VALUES 
    ('$content','$parent_id','$user_id','$post_id')";
    return $db->pdo_execute($sql);
  }

  public function deleteComment($id)
  {
    $db = new connect();
    $sql = "DELETE FROM comments WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
