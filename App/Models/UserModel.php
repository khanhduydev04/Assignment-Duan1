<?php
class User
{
  var $UserID = null;
  var $Password = null;
  var $firstName = null;
  var $lastName = null;
  var $Gender = null;
  var $Phone = null;
  var $Role = null;

  public function getAllUser()
  {
    $db = new connect();
    $sql = "SELECT * FROM users";
    return $db->pdo_query($sql);
  }

  public function getUserById($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE id = '$id'";
    return $db->pdo_query_one($sql);
  }

  public function checkEmailExists($email)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE email = '$email'";
    return $db->pdo_query_one($sql);
  }

  public function checkPhoneExists($phone)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE phone = '$phone'";
    return $db->pdo_query_one($sql);
  }

  public function checkUser($email, $password)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='user'";
    $result = $db->pdo_query_one($sql);
    if ($result != null)
      return true;
    else
      return false;
  }

  public function checkUserByEmail($email)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $db->pdo_query_one($sql);
    if ($result != null)
      return true;
    else
      return false;
  }

  public function checkUserByPhone($phone)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE phone='$phone'";
    $result = $db->pdo_query_one($sql);
    if ($result != null)
      return true;
    else
      return false;
  }

  public function checkAdmin($email, $password)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='admin'";
    $result = $db->pdo_query_one($sql);
    if ($result != null)
      return true;
    else
      return false;
  }

  public function getIdUser($email, $password)
  {
    $db = new connect();
    $sql = "SELECT id,role FROM  users WHERE email='$email' AND password='$password'";
    $result = $db->pdo_query_one($sql);
    return $result;
  }

  public function getIdByEmail($email)
  {
    $db = new connect();
    $sql = "SELECT id,role FROM users WHERE email='$email'";
    $result = $db->pdo_query_one($sql);
    return $result;
  }

  public function addUser($first_name, $last_name, $email, $phone, $password, $gender)
  {
    $db = new connect();
    $sql = "INSERT INTO users(first_name, last_name, email, phone, password, gender) VALUES 
      ('$first_name', '$last_name', '$email', '$phone', '$password', '$gender')";
    return $db->pdo_execute($sql);
  }

  public function updateUser($id, $first_name, $last_name, $email, $phone, $password, $gender)
  {
    $db = new connect();
    $sql = "UPDATE users SET 
      first_name = '$first_name', last_name = '$last_name', email = '$email',
      phone = '$phone', password = '$password', gender = '$gender'
      WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }

  public function updatePassword($id, $password)
  {
    $db = new connect();
    $sql = "UPDATE users SET password = '$password' WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }

  public function deleteUser($id)
  {
    $db = new connect();
    $sql = "DELETE FROM users WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
