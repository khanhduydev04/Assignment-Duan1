<!-- main -->
<div class="container-fluid">
  <div class="row justify-content-evenly">
    <!-- sidebar -->
    <div class="col-12 col-lg-3">
      <div class="d-none d-xxl-block h-100 fixed-top overflow-hidden shadow-sm scrollbar" style="max-width: 360px; width: 100%; z-index: 4; padding-top: 57px;">
        <div class="p-3 bg-main">
          <ul class="navbar-nav mt-1 ms-1 d-flex flex-column pb-5 mb-2" style="padding-top: 40px">
            <div class="d-flex align-items-center w-100 gap-3">
              <img src="./Public/images/avt.jpg" class="rounded-circle" alt="" style="width: 50px; height: 50px;">
              <div class="justify-content-center align-content-center pe-4" style="margin-right: 50px;">
                <p class="m-0 mb-1" style="font-size: 17px; font-weight: bold;">Nguyễn Thái Toàn</p>
                <p class="m-0">Người dùng Beebook</p>
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
                <form action="" class="mt-3">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Họ</label>
                      <input type="text" id="" class="form-control">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Tên</label>
                      <input type="text" id="" class="form-control" width="30px">
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-8">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Email</label>
                      <input type="email" id="" class="form-control" width="30px">
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-8">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Số điện
                        thoại</label>
                      <input type="text" id="" class="form-control">
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-4">
                      <button class="btn btn-dark" style="width: 85%;border-radius: 22px;">Cập
                        nhật</button>
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
                if(isset($_POST['changePass'])){
                  $password = $_POST['password'];
                  $newpass = $_POST['newpassword'];
                  $repass = $_POST['repassword'];

                  if($password != '' || $newpass != '' || $repass != ''){
                    $user = new User();
                    $checkPass = $user->checkPass($password);
                    if($checkPass){
                      if (strlen($newpass) < 8 || !preg_match("/[!@#$%^&*]/", $newpass)) {
                        echo "<p class='text-danger mt-3'>Mật khẩu ít nhất phải có 8 ký tự và chứa ít nhất 1 ký tự đặc biệt!</p>";
                      } else {
                          if ($newpass !== $repass) {
                              echo "<p class='text-danger mt-3'>Nhập lại mật khẩu không khớp!</p>";
                          } else {
                              $user = new User();
                              $email = $_SESSION['mail'];
                              $user_id = $user->getIdByEmail($email);
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
                  <p class="m-0" style="font-size: 16px;">Nguyễn</p>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Tên</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;">Toàn</p>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Số điện thoại</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;">0123456789</p>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <p class="m-0" style="font-size: 16px;font-weight: 500;">Email</p>
                </div>
                <div class="col-12 col-lg-8">
                  <p class="m-0" style="font-size: 16px;">Toannt123@gmail.com</p>
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