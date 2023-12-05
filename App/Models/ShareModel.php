<?php
class Share
{
  var $FollowID = null;
  var $UserID1 = null;
  var $UserID2 = null;

  public function getAllShareId()
  {
    $db = new connect();
    $sql = "SELECT post_share_id FROM shares";
    return $db->pdo_query($sql);
  }
  public function countShareByPost($id)
  {
    $db = new connect();
    $sql = "SELECT COUNT(*) FROM shares WHERE post_id = '$id'";
    return $db->pdo_query_value($sql);
  }

  public function getPostShare($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM shares WHERE post_share_id = '$id'";
    return $db->pdo_query_one($sql);
  }

  public function insertShare($user_id, $post_id, $post_share_id)
  {
    $db = new connect();
    $sql = "INSERT INTO shares(user_id,post_id,post_share_id) VALUES ('$user_id', '$post_id','$post_share_id')";
    return $db->pdo_execute($sql);
  }

  public function deleteShare($id)
  {
    $db = new connect();
    $sql = "DELETE FROM shares WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
