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

  public function getRadomUser($user_id, $limit)
  {
    $db = new connect();
    $sql = "SELECT * FROM users u WHERE u.id != '$user_id'
    AND NOT EXISTS (
        SELECT * FROM friends f WHERE 
            (f.user_id1 = u.id AND f.user_id2 = '$user_id' AND f.status IN ('Bạn bè', 'Chờ chấp nhận'))
            OR
            (f.user_id2 = u.id AND f.user_id1 = '$user_id' AND f.status IN ('Bạn bè', 'Chờ chấp nhận'))
    )
    ORDER BY RAND()
    LIMIT $limit";
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
    OR last_name LIKE '%$keyword%' OR CONCAT(first_name, ' ', last_name) LIKE '%$keyword%'
    OR CONCAT(last_name, ' ', first_name) LIKE '%$keyword%'";
    return $db->pdo_query($sql);
  }

  public function checkEmailExists($email, $user_id)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE email = '$email' AND id != '$user_id'";
    return $db->pdo_query_one($sql);
  }

  public function checkPhoneExists($phone, $user_id)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE phone = '$phone' AND id != '$user_id'";
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

  public function checkPass($password, $id)
  {
    $db = new connect();
    $sql = "SELECT * FROM users WHERE id ='$id'";
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
    $sql = "SELECT id, role, user_token, password FROM users WHERE email='$email'";
    $userData = $db->pdo_query_one($sql);
    if ($userData != null) {
      $hashedPassword = $userData['password'];
      if (password_verify($password, $hashedPassword)) {
        // Mật khẩu hợp lệ, trả về id và vai trò (role) của người dùng
        return array(
          'id' => $userData['id'], 'role' => $userData['role'],
          'token' => $userData['user_token']
        );
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

  public function updateUser($id, $first_name, $last_name, $email, $phone, $gender)
  {
    $db = new connect();
    $sql = "UPDATE users SET 
      first_name = '$first_name', last_name = '$last_name', email = '$email',
      phone = '$phone', gender = '$gender'
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

  public function updatetUserConnectionId($user_connection_id, $user_token)
  {
    $db = new connect();
    $sql = "UPDATE users SET connection_id = '$user_connection_id' WHERE user_token = '$user_token'";
    return $db->pdo_execute($sql);
  }

  public function updateUserToken($user_token, $id)
  {
    $db = new connect();
    $sql = "UPDATE users SET user_token = '$user_token' WHERE id = '$id'";
    return $db->pdo_execute($sql);
  }
}
