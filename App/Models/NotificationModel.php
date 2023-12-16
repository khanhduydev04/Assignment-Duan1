<?php
class Notification
{
  var $ID = null;
  var $User_id = null;
  var $Content = null;
  var $Href = null;
  var $CreatedAt = null;

  public function getNotifications($user_id)
  {
    $db = new connect();
    $sql = "SELECT * FROM notifications WHERE user_id = '$user_id'  ORDER BY id DESC";
    return $db->pdo_query($sql);
  }

  public function insertNotification($content, $href, $user_id)
  {
    $db = new connect();
    $sql = "INSERT INTO notifications(content, href, user_id) VALUES ('$content', '$href', '$user_id')";
    return $db->pdo_execute($sql);
  }
}
