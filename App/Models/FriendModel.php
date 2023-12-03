<?php
class Friend
{
  var $FriendID = null;
  var $Status = null;
  var $UserID1 = null;
  var $UserID2 = null;

  public function getAllRequestByUser($id, $limit)
  {
    // Nếu bạn muốn lấy tất cả người dùng, hãy sử dụng giá trị lớn hoặc không giới hạn
    $limitValue = ($limit === 'all') ? PHP_INT_MAX : $limit;

    $db = new connect();
    $sql = "SELECT * FROM friends WHERE user_id2 = '$id' AND status = 'Chờ chấp nhận' LIMIT $limitValue";
    return $db->pdo_query($sql);
  }

  public function countRequestByUser($id)
  {
    $db = new connect();
    $sql = "SELECT COUNT(*) FROM friends WHERE user_id2 = '$id' AND status = 'Chờ chấp nhận'";
    return $db->pdo_query_value($sql);
  }

  public function getAllFriendByUser($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM friends WHERE (user_id1 = '$id' OR user_id2 = '$id') AND status = 'Bạn bè'";
    return $db->pdo_query($sql);
  }

  public function getFriendID($user_id, $user_id2)
  {
    $db = new connect();
    $sql = "SELECT id FROM friends WHERE (user_id1 = '$user_id' AND user_id2 = '$user_id2') OR 
    (user_id1 = '$user_id2' AND user_id2 = '$user_id')";
    return $db->pdo_query_value($sql);
  }

  public function countAllFriend($id)
  {
    $db = new connect();
    $sql = "SELECT COUNT(id) FROM friends WHERE (user_id1 = '$id' OR user_id2 = '$id') AND status = 'Bạn bè'";
    return $db->pdo_query_value($sql);
  }

  public function countMatualFriend($user_id, $user_id2)
  {
    $db = new connect();
    $sql = "SELECT COUNT(*)  FROM
    (((SELECT user_id2
    FROM friends
    WHERE user_id1 = '$user_id' and status = 'Bạn bè')
    UNION
    (SELECT user_id1
    FROM friends
    WHERE user_id2 = '$user_id' and status = 'Bạn bè'))
    
    INTERSECT

    ((select user_id2 
    from friends
    where user_id1 = '$user_id2' and status = 'Bạn bè')
    UNION
    (select user_id1
    from friends
    where user_id2 ='$user_id2' ))) as aals";
    return $db->pdo_query_value($sql);
  }

  public function checkIsFriend($user_id, $user_id2)
  {
    $db = new connect();
    $sql = "SELECT 
    CASE
        WHEN status = 'Bạn bè' THEN 'Bạn bè'
        WHEN user_id1 = '$user_id' AND status = 'Chờ chấp nhận' THEN 'Đã gửi lời mời'
        WHEN user_id2 = '$user_id' AND status = 'Chờ chấp nhận' THEN 'Lời mời đến bạn'
        ELSE 'Chưa là bạn bè'
    END AS friendship_status FROM friends WHERE 
    ('$user_id' = user_id1 AND '$user_id2' = user_id2) OR
    ('$user_id' = user_id2 AND '$user_id2' = user_id1)";
    return $db->pdo_query_value($sql);
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
