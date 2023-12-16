<?php
class Follow
{
  var $FollowID = null;
  var $UserID1 = null;
  var $UserID2 = null;

  public function getAllFollow($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM follows WHERE user_id1 = '$id'";
    return $db->pdo_query($sql);
  }

  public function getFollowID($user_id, $user_id2)
  {
    $db = new connect();
    $sql = "SELECT id FROM follows WHERE (user_id1 = '$user_id' AND user_id2 = '$user_id2')";
    return $db->pdo_query_value($sql);
  }

  public function insertFollow($user_id, $user_id2)
  {
    $db = new connect();
    $sql = "INSERT INTO follows(user_id1,user_id2) VALUES ('$user_id', '$user_id2')";
    return $db->pdo_execute($sql);
  }

  public function deleteFollow($id)
  {
    $db = new connect();
    $sql = "DELETE FROM follows WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
