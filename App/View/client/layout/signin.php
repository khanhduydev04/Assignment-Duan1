<div class="d-flex flex-column justify-content-between min-vh-100">
    <div class="container-fluid bg-gray">
        <!-- login -->
        <div class="container d-flex flex-column flex-lg-row justify-content-evenly p-5 ">
            <!--heading-->
            <div class="text-center text-lg-start mt-lg-5 pt-lg-5">
                <h1 class="text-primary fw-bold fs-0">
                    Beebook
                </h1>
                <p class="w-75 mx-auto mx-lg-0 fs-4">
                    Beebook giúp bạn kết nối và chia sẻ với mọi người trong cuộc sống của bạn
                </p>
            </div>
            <!--form-->
            <div style="max-width: 28rem; width: 100%">
                <form class="bg-white shadow rounded p-3 input-group-lg">
                    <input type="email" name="email" id="email1" class="form-control my-3" placeholder="Email">
                    <input type="password" name="password" id="password1" class="form-control my-3" placeholder="Mật khẩu">
                    <button class="btn btn-primary w-100 my-3 fw-bold" type="submit" name="login">Đăng nhập</button>
                    <a href="index.php?ctrl=forgetpassword" class="text-decoration-none text-center">
                        <p class="">Quên mật khẩu?</p>
                    </a>
                    <hr>
                    <!--register-->
                    <div class="text-center my-4">
                        <button type="button" class="btn btn-success btn-lg fw-semibold" data-bs-toggle="modal" data-bs-target="#creatModal">
                            Tạo tài khoản mới
                        </button>
                    </div>
                    <!--creat modal start-->
                    <div class="modal fade" id="creatModal" tabindex="-1" aria-labelledby="creatModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!--head-->
                                <div class="modal-header">
                                    <div class="">
                                        <h1 class="modal-title fs-3" id="creatModalLabel">Đăng ký</h1>
                                        <p class="text-muted fs-7">Nhanh chóng và dễ dàng.</p>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!--body register-->
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <!--name-->
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Họ">
                                            </div>
                                            <div class="col">
                                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Tên">
                                            </div>
                                        </div>
                                        <!--email and password-->
                                        <input type="email" name="email" id="email" class="form-control my-3" placeholder="Email">
                                        <input type="text" name="phone" id="phone" class="form-control my-3" placeholder="Số điện thoại">
                                        <input type="password" name="password" id="password" class="form-control my-3" placeholder="Mật khẩu">
                                        <!--gender-->
                                        <div class="row my-3">
                                            <span class="text-muted fs-7 mb-1">
                                                Giới tính
                                                <i type="button" class="fa-solid fa-circle-question" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Bạn có thể thay đổi người nhìn thấy giới tính của mình trên trang cá nhân vào lúc khác. 
                                                        Chọn Tùy chỉnh nếu bạn thuộc giới tính khác hoặc không muốn tiết lộ."></i>

                                            </span>
                                            <div class="col">
                                                <div class="border rounded p-2">
                                                    <input class="form-check-input" type="radio" name="gender" id="men">
                                                    <label class="form-check-label" for="men">
                                                        Nam
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded p-2">
                                                    <input class="form-check-input" type="radio" name="gender" id="women">
                                                    <label class="form-check-label" for="women">
                                                        Nữ
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded p-2">
                                                    <input class="form-check-input" type="radio" name="gender" id="custom">
                                                    <label class="form-check-label" for="custom">
                                                        Tùy chỉnh
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--disclaimer-->
                                        <div class="">
                                            <span class="text-muted fs-7 mt-3">
                                                Những người dùng dịch vụ của chúng tôi có thể đã tải thông tin liên hệ của bạn lên Facebook. Tìm hiểu thêm.
                                            </span>
                                        </div>
                                        <!--btn-->
                                        <div class="text-center my-4">
                                            <button type="submit" class="btn btn-success btn-lg" name="register">
                                                Đăng ký
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--creat modal ends-->
                </form>
            </div>
        </div>
    </div>

    <!-- footer-->
    <footer class="bg-white p-4 text-muted position-relative">
        <!--language-->
        <div class="d-flex flex-column flex-lg-row justify-content-center ">
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
            <p class="fs-7">Beebook</p>
        </div>
    </footer>
</div>