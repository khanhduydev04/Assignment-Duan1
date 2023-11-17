<!--header-->
<header class="p-3 shadow">
    <div class="container-fluid d-flex">
        <div class="col">
            <h1 class="text-primary fw-bold fs-2">
                Facebook
            </h1>
        </div>
    </div>
</header>
<!-- main -->
<div class="container-fluid bg-gray d-flex justify-content-center p-5">
    <?php
    if (isset($_GET['act'])) {
        $act = $_GET['act'];

        switch ($act) {
            case "xacnhan": ?>
                <div class="bg-white shadow rounded pt-3 input-group-lg" style="width: 28rem;">
                    <strong class="p-lg-3">Nhập mã xác nhận</strong>
                    <hr>
                    <form action="" class="p-lg-2">
                        <p class="">Vui lòng kiểm tra email để nhận mã xác nhận.</p>
                        <input type="text" name="code" id="" class="form-control p-3" placeholder="Mã xác nhận">
                        <hr>
                        <button type="submit" class="btn btn-primary">Kiểm tra</button>
                    </form>
                </div>
            <?php break;
            case "capnhatmatkhau": ?>
                <div class="bg-white shadow rounded p-3 pt-3 input-group-lg" style="width: 28rem;">
                    <strong class="p-lg-2">Đổi mới mật khẩu</strong>
                    <hr>
                    <form action="" class="p-lg-2">
                        <p class="">Vui lòng nhập mật khẩu mới.</p>
                        <input type="password" name="" id="" class="form-control px-3 py-2 my-2" placeholder="Mật khẩu mới">
                        <input type="password" name="" id="" class="form-control px-3 py-2 my-2" placeholder="Xác nhận mật khẩu">
                        <hr>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
        <?php break;
        }
    } else { ?>
        <div class="bg-white shadow rounded pt-3 input-group-lg" style="width: 28rem;">
            <strong class="p-lg-3">Tìm tài khoản của bạn</strong>
            <hr>
            <form action="" class="p-lg-2">
                <p class="">Vui lòng nhập email tài khoản của bạn.</p>
                <input type="email" name="email" class="form-control p-3" placeholder="Email">
                <hr>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-2">
                    <button type="button" class="btn btn-secondary">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi mã</button>
                </div>
            </form>
        </div>
    <?php } ?>
</div>
<!-- footer-->
<footer class=" text-muted ">
    <!--language-->
    <div class="d-flex justify-content-center ">
        <p class="mx-2 fs-7 mb-0">VietNamese</p>
        <p class="mx-2 fs-7 mb-0">Englist (US)</p>
        <p class="mx-2 fs-7 mb-0">China</p>
    </div>
    <hr>
    <!--action-->
    <div class="d-flex flex-column flex-lg-row justify-content-center ">
        <p class="mx-2 fs-7 mb-0">Dang nhap</p>
        <p class="mx-2 fs-7 mb-0">Dang ky</p>
        <p class="mx-2 fs-7 mb-0">Tin nhan</p>
    </div>
    <!--copy-->
    <div class="mt-4 mx-2 text-center">
        <p class="fs-7">Facebook & HoDuMaiTran</p>
    </div>
</footer>