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

  public function getAllUser($user_id)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE users.show = 1 AND id != '$user_id'";
    return $db->pdo_query($sql);
  }

  public function getUserById($id)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE id = '$id'";
    return $db->pdo_query_one($sql);
  }

  public function getFullnameByUser($user_id)
  {
    $db = new connect();
    $sql = "SELECT CONCAT_WS(' ', first_name, last_name) FROM users WHERE id = '$user_id'";
    return $db->pdo_query_value($sql);
  }

  public function searchUser($keyword)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE users.show = 1 AND first_name LIKE '%$keyword%' 
    OR last_name LIKE '%$keyword%' OR CONCAT(first_name, ' ', last_name) LIKE '%$keyword%'";
    return $db->pdo_query($sql);
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
    $sql = "SELECT * FROM users WHERE email='$email' AND role='user'";
    $userData = $db->pdo_query_one($sql);
    if ($userData != null) {
      $hashedPassword = $userData['password'];
      if (password_verify($password, $hashedPassword)) {
        return true; // Mật khẩu hợp lệ
      } else {
        return false; // Mật khẩu không hợp lệ
      }
    } else {
      return false; // Người dùng không tồn tại
    }
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
    $sql = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $userData = $db->pdo_query_one($sql);
    if ($userData != null) {
      $hashedPassword = $userData['password'];
      if (password_verify($password, $hashedPassword)) {
        return true; // Mật khẩu hợp lệ
      } else {
        return false; // Mật khẩu không hợp lệ
      }
    } else {
      return false; // Người dùng không tồn tại
    }
  }

  public function getIdUser($email, $password)
  {
    $db = new connect();
    $sql = "SELECT id, role, password FROM users WHERE email='$email'";
    $userData = $db->pdo_query_one($sql);
    if ($userData != null) {
      $hashedPassword = $userData['password'];
      if (password_verify($password, $hashedPassword)) {
        // Mật khẩu hợp lệ, trả về id và vai trò (role) của người dùng
        return array('id' => $userData['id'], 'role' => $userData['role']);
      } else {
        // Mật khẩu không hợp lệ
        return null;
      }
    } else {
      // Người dùng không tồn tại
      return null;
    }
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
