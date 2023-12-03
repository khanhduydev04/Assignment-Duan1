<?php
class Photo
{
  var $PhotoID = null;
  var $Status = null;
  var $Image_Url = null;
  var $PostID = null;

  public function getAllPhotoByUser($id)
  {
    $db = new connect();
    $sql = "SELECT photos.image_url FROM users INNER JOIN posts ON users.id = posts.user_id
    LEFT JOIN photos ON posts.id = photos.post_id WHERE users.id = '$id' AND photos.image_url IS NOT NULL";
    return $db->pdo_query($sql);
  }

  public function getAllAvatarByUser($id)
  {
    $db = new connect();
    $sql = "SELECT photos.image_url FROM users INNER JOIN posts ON users.id = posts.user_id
    LEFT JOIN photos ON posts.id = photos.post_id WHERE users.id = '$id' AND photos.status = 'avatar'";
    return $db->pdo_query($sql);
  }

  public function getAllCoverByUser($id)
  {
    $db = new connect();
    $sql = "SELECT photos.image_url FROM users INNER JOIN posts ON users.id = posts.user_id
    LEFT JOIN photos ON posts.id = photos.post_id WHERE users.id = '$id' AND photos.status = 'cover'";
    return $db->pdo_query($sql);
  }

  public function getNewAvatarByUser($id)
  {
    $db = new connect();
    $sql = "SELECT photos.image_url FROM users JOIN posts ON users.id = posts.user_id JOIN photos ON posts.id = photos.post_id WHERE users.id = '$id' AND photos.status = 'avatar' ORDER BY photos.id DESC LIMIT 1";
    return $db->pdo_query_value($sql);
  }

  public function getNewCoverByUser($id)
  {
    $db = new connect();
    $sql = "SELECT photos.image_url FROM users JOIN posts ON users.id = posts.user_id JOIN photos ON posts.id = photos.post_id WHERE users.id = '$id' AND photos.status = 'cover' ORDER BY photos.id DESC LIMIT 1";
    return $db->pdo_query_value($sql);
  }

  public function countPhotoByPost($id)
  {
    $db = new connect();
    $sql = "SELECT COUNT(*) FROM `photos` INNER JOIN posts ON photos.post_id = posts.id
    WHERE post_id = '$id'";
    return $db->pdo_query_value($sql);
  }

  public function getPhotoByPost($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM photos WHERE post_id = '$id'";
    return $db->pdo_query($sql);
  }

  public function insertPhoto($image_url, $status, $post_id)
  {
    $db = new connect();
    $sql = "INSERT INTO photos(image_url,status,post_id) VALUES ('$image_url', '$status', '$post_id')";
    return $db->pdo_execute($sql);
  }

  public function deletePhoto($id)
  {
    $db = new connect();
    $sql = "DELETE FROM photos WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
