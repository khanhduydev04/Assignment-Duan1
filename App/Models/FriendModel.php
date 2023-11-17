<?php
class User
{
  var $FriendID = null;
  var $Status = null;
  var $UserID1 = null;
  var $UserID2 = null;

  public function getAllRequestByUser($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM friends WHERE user_id2 = '$id' AND status = 'Chờ chấp nhận'";
    return $db->pdo_query($sql);
  }

  public function getAllFriendByUser($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM friends WHERE (user_id1 = '$id' OR user_id2 = '$id') AND status = 'Bạn bè'";
    return $db->pdo_query($sql);
  }

  public function addFriend($user_id1, $user_id2)
  {
    $db = new connect();
    $sql = "INSERT INTO friends(user_id1, user_id2) VALUES ('$user_id1', '$user_id2')";
    return $db->pdo_execute($sql);
  }

  public function acceptRequest($id)
  {
    $db = new connect();
    $sql = "UPDATE friends SET status = 'Bạn bè' WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }

  public function deleteFriend($id)
  {
    $db = new connect();
    $sql = "DELETE FROM friends WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
