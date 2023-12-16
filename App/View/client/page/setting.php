<?php
$user = new User();
$photo = new Photo();

$id = $_SESSION['user']['id'];
$user_id = $_SESSION['user']['id'];

$update = $user->getUserById($id);

if (isset($_POST['update']) && ($_POST['update'])) {
  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $gender = $update['gender'];

  $error_email = []; // Khởi tạo thông báo lỗi về email
  $error_phone = []; // Khởi tạo thông báo lỗi về số điện thoại

  if (!empty($email)) {
    // Kiểm tra email đã tồn tại hay chưa
    if ($user->checkEmailExists($email, $user_id)) {
      $error_email['update'] = 'Email đã tồn tại. Vui lòng chọn email khác.';
    }
  }

  if (!empty($phone)) {
    // Kiểm tra số điện thoại đã tồn tại hay chưa
    if ($user->checkPhoneExists($phone, $user_id)) {
      $error_phone['update'] = 'Số điện thoại đã tồn tại. Vui lòng chọn số điện thoại khác.';
    }
  }

  // Kiểm tra xem có thông báo lỗi nào được tạo ra không
  if (!empty($error_email) || !empty($error_phone)) {
    // Nếu có thông báo lỗi, hiển thị chúng
    if (!empty($error_email)) {
      echo $error_email['update'];
    } else {
      $error_email['update'] = '';
    }
    if (!empty($error_phone)) {
      echo $error_phone['update'];
    } else {
      $error_phone['update'] = '';
    }
  } else {
    // Nếu không có lỗi, tiến hành cập nhật thông tin người dùng
    if ($user->updateUser($id, $first_name, $last_name, $email, $phone, $gender)) {
      echo 'Cập nhật thành công';
      header("Location: ./index.php?ctrl=setting&act=change_information");
    } else {
      echo 'Cập nhật thất bại';
    }
  }
}
?>
<!-- main -->
<div class="container-fluid">
  <div class="row justify-content-evenly">
    <!-- sidebar -->
    <div class="col-12 col-lg-3">
      <div class="d-none d-xxl-block h-100 fixed-top overflow-hidden shadow-sm scrollbar" style="max-width: 360px; width: 100%; z-index: 4; padding-top: 57px;">
        <div class="p-3 bg-main">
          <ul class="navbar-nav mt-1 ms-1 d-flex flex-column pb-5 mb-2" style="padding-top: 40px">
            <div class="d-flex align-items-center w-100 gap-3">
              <?php
              if ($photo->getNewAvatarByUser($id) != null) { ?>
                <img src="./Public/upload/<?= $photo->getNewAvatarByUser($id) ?>" class="rounded-circle" alt="" style="width: 50px; height: 50px;" />
              <?php } else { ?>
                <img src="./Public/images/avt_default.png" class="rounded-circle" alt="" style="width: 50px; height: 50px;" />
              <?php } ?>
              <div class="justify-content-center align-content-center pe-4" style="margin-right: 50px;">
                <p class="m-0 mb-1" style="font-size: 17px; font-weight: bold;"><?= $user->getFullnameByUser($user_id) ?></p>
                <p class="m-0">Người dùng BeeSocial</p>
              </div>
            </div>
            <hr>
            <li class="dropdown-item p-1 mt-1 rounded">
              <div class="d-flex">
                <i class="fa-solid fa-house p-2 rounded-circle" style="font-size: 20px; color: #000;"></i>
                <a href="index.php?ctrl=setting" class="d-flex ms-3 align-items-center text-decoration-none text-dark">
                  <p class="m-0 p-2" style="font-weight: 500; font-size: 17px;">Thông tin tài
                    khoản</p>
                </a>
              </div>
            </li>
            <li class="btn-bg dropdown-item p-1 mt-1 rounded" id="myButton">
              <div class="d-flex">
                <i class="fa-solid fa-user p-2 rounded-circle" style="font-size: 20px;color: #000000;"></i>
                <a href="index.php?ctrl=setting&act=change_information" class="d-flex ms-3 align-items-center text-decoration-none text-dark">
                  <p class="m-0 p-2" style="font-weight: 500; font-size: 17px;">Cập nhật tài khoản
                  </p>
                </a>
              </div>
            </li>
            <li class="btn-bg dropdown-item p-1 mt-1 rounded" id="myButton">
              <div class="d-flex">
                <i class="fa-solid fa-lock p-2 rounded-circle" style="font-size: 20px;color: #000000;"></i>
                <a href="index.php?ctrl=setting&act=change_password" class="d-flex ms-3 align-items-center text-decoration-none text-dark">
                  <p class="m-0 p-2" style="font-weight: 500; font-size: 17px;">Cập nhật mật khẩu
                  </p>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <main class="col-12 col-lg-9">
      <?php
      if (isset($_GET['act'])) {
        $act = $_GET['act'];

        switch ($act) {
          case "change_information": ?>
            <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 57px; max-width: 1080px">
              <div class="mt-3 d-flex justify-content-between position-relative">
                <div class="timeline d-flex pb-3 mt-4 justify-content-between align-content-center">
                  <p class="m-0 fw-bold" style="font-size: 18px;">CẬP NHẬT TÀI KHOẢN</p>
                </div>
              </div>
              <div class="justify-content-between align-content-center">
                <form action="" class="mt-3" method="POST" id="form-update" onsubmit="UpdateFormSubmit(event)">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Họ</label>
                      <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $update['last_name'] ?>">
                      <div class="mt-2">
                        <span class="text-danger" id="lastSpan"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Tên</label>
                      <input type="text" id="firstname" name="firstname" class="form-control" width="30px" value="<?= $update['first_name'] ?>">
                      <div class="mt-2">
                        <span class="text-danger" id="firstSpan"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-8">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Email</label>
                      <input type="email" id="email" name="email" class="form-control" width="30px" value="<?= $update['email'] ?>">
                      <span class="text-danger" id="emailText"></span>
                      <div class="mt-2">
                        <span class="text-danger">
                          <?php
                          if (isset($error_email['update'])) {
                            echo $error_email['update'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-8">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Số điện
                        thoại</label>
                      <input type="text" id="phone" name="phone" class="form-control" value="<?= $update['phone'] ?>">
                      <span class="text-danger" id="phoneText"></span>
                      <div class="mt-2">
                        <span class="text-danger">
                          <?php
                          if (isset($error_phone['update'])) {
                            echo $error_phone['update'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-4">
                      <input type="submit" class="btn btn-dark" style="width: 85%;border-radius: 22px;" name="update" value="Cập nhật">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          <?php break;
          case "change_password": ?>
            <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 57px; max-width: 1080px">
              <div class="mt-3 d-flex justify-content-between position-relative">
                <div class="timeline d-flex pb-3 mt-4 justify-content-between align-content-center">
                  <p class="m-0 fw-bold" style="font-size: 18px;">CẬP NHẬT MẬT KHẨU</p>
                </div>
              </div>
              <div class="justify-content-between align-content-center">
                <form action="" method="POST" class="mt-3" onsubmit="return validateForm()">
                  <div class="row">
                    <div class="col-12 col-lg-5">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Mật khẩu hiện
                        tại</label>
                      <input type="password" name="password" id="password" class="form-control">
                      <p id="passwordError" class="text-danger" style="display:none;">Vui lòng nhập mật khẩu hiện tại.</p>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-12 col-lg-5">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Mật khẩu
                        mới</label>
                      <input type="password" name="newpassword" id="newpassword" class="form-control">
                      <p id="newpasswordError" class="text-danger" style="display:none;">Vui lòng nhập mật khẩu mới.</p>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-12 col-lg-5">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Xác nhận lại mật
                        khẩu</label>
                      <input type="password" name="repassword" id="repassword" class="form-control">
                      <p id="repasswordError" class="text-danger" style="display:none;">Vui lòng nhập lại mật khẩu mới.</p>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-dark" name="changePass" style="width: 85%;border-radius: 22px;">Cập
                        nhật
                      </button>
                    </div>
                  </div>
                </form>
                <?php
                if (isset($_POST['changePass'])) {
                  $password = $_POST['password'];
                  $newpass = $_POST['newpassword'];
                  $repass = $_POST['repassword'];

                  if ($password != '' || $newpass != '' || $repass != '') {
                    $checkPass = $user->checkPass($password, $user_id);
                    if ($checkPass) {
                      if (strlen($newpass) < 8 || !preg_match("/[!@#$%^&*]/", $newpass)) {
                        echo "<p class='text-danger mt-3'>Mật khẩu tối thiểu 8 ký tự bao gồm chữ số và ký tự đặc biệt</p>";
                      } else {
                        if ($newpass !== $repass) {
                          echo "<p class='text-danger mt-3'>Nhập lại mật khẩu không khớp!</p>";
                        } else {
                          $newpass = password_hash($newpass, PASSWORD_DEFAULT);
                          $user->updatePassword($user_id, $newpass);
                          echo "<p class='text-success mt-3'>Đổi mật khẩu thành công!</p>";
                          header('refresh:3s; index.php?ctrl=forgetpassword');
                        }
                      }
                    } else {
                      echo "<p class='text-danger mt-3'>Mật khẩu bạn nhập không đúng</p>";
                    }
                  }
                }
                ?>
              </div>
            </div>
        <?php break;
        }
      } else { ?>
        <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 57px; max-width: 1000px">
          <div class="mt-3 d-flex justify-content-between position-relative">
            <div class="timeline d-flex pb-3 mt-4 justify-content-between align-content-center">
              <p class="m-0 fw-bold" style="font-size: 18px;">THÔNG TIN TÀI KHOẢN</p>
            </div>
          </div>
          <div class="justify-content-between align-content-center">
            <form action="" class="mt-3">
              <div class="row">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Họ</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;"><?= $update['last_name'] ?></p>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Tên</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;"><?= $update['first_name'] ?></p>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Số điện thoại</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;"><?= $update['phone'] ?></p>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Email</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;"><?= $update['email'] ?></p>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php } ?>
    </main>
  </div>
</div>

<script>
  function validateForm() {
    let password = document.getElementById('password').value.trim();
    let newPassword = document.getElementById('newpassword').value.trim();
    let rePassword = document.getElementById('repassword').value.trim();

    let passwordError = document.getElementById('passwordError');
    let newPasswordError = document.getElementById('newpasswordError');
    let rePasswordError = document.getElementById('repasswordError');

    let isValid = true;

    // Kiểm tra mật khẩu hiện tại không được để trống
    if (password === '') {
      passwordError.style.display = 'block';
      isValid = false;
    } else {
      passwordError.style.display = 'none';
    }

    // Kiểm tra mật khẩu mới không được để trống
    if (newPassword === '') {
      newPasswordError.style.display = 'block';
      isValid = false;
    } else {
      newPasswordError.style.display = 'none';
    }

    // Kiểm tra mật khẩu nhập lại không được để trống và phải trùng với mật khẩu mới
    if (rePassword === '') {
      rePasswordError.style.display = 'block';
      isValid = false;
    } else if (rePassword !== newPassword) {
      rePasswordError.innerHTML = 'Mật khẩu nhập lại không khớp với mật khẩu mới.';
      rePasswordError.style.display = 'block';
      isValid = false;
    } else {
      rePasswordError.style.display = 'none';
    }

    return isValid;
  }
</script>