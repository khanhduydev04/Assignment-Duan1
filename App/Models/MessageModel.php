<?php
class Message
{
  var $MessageID = null;
  var $Content = null;
  var $UserID1 = null;
  var $UserID2 = null;
  var $CreatedAt = null;

  public function getChat($user_id1, $user_id2)
  {
    $db = new connect();
    $sql = "SELECT * FROM messages WHERE (user_id1 = '$user_id1' AND user_id2 = '$user_id2') 
    OR (user_id1 = '$user_id2' AND user_id2 = '$user_id1') ORDER BY id ASC";
    return $db->pdo_query($sql);
  }

  public function saveChat($content, $user_id1, $user_id2)
  {
    $db = new connect();
    $sql = "INSERT INTO messages(content, user_id1, user_id2) VALUES ('$content', '$user_id1', '$user_id2')";
    return $db->pdo_execute($sql);
  }
}
