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
                <form action="" class="mt-3">
                  <div class="row">
                    <div class="col-12 col-lg-5">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Mật khẩu hiện
                        tại</label>
                      <input type="password" name="" id="" class="form-control">
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-12 col-lg-5">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Mật khẩu
                        mới</label>
                      <input type="password" name="" id="" class="form-control">
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-12 col-lg-5">
                      <label class="form-label" style="font-size: 16px;font-weight: 500;">Xác nhận lại mật
                        khẩu</label>
                      <input type="password" name="" id="" class="form-control">
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