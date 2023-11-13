<div class="container-fluid bg-gray">
        <!-- login -->
        <div class="container d-flex flex-column flex-lg-row justify-content-evenly mt-5 p-5 ">
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
                    <form class="bg-while shadow rounded p-3 input-group-lg">
                        <input type="email" name="" id="" class="form-control my-3" placeholder="Email hoặc số điện thoại">
                        <input type="password" name="" id="" class="form-control my-3" placeholder="Mật khẩu">
                        <button class="btn btn-primary w-100 my-3">Đăng nhập</button>
                        <a href="./forget.html" class="text-decoration-none text-center">
                            <p class="">Quên mật khẩu?</p>
                        </a>
                        <hr>
                        <!--register-->
                        <div class="text-center my-4">
                            <button  type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#creatModal">
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
                                            <form action="" class="">
                                                <!--name-->
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" name="" id="" class="form-control" placeholder="Họ">
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" name="" id="" class="form-control" placeholder="Tên">
                                                    </div>
                                                </div>
                                                <!--email and password-->
                                                <input type="text" name="" id="" class="form-control my-3" placeholder="Email hoặc số điện thoại">
                                                <input type="password" name="" id="" class="form-control my-3" placeholder="Mật khẩu">
                                                <!--gender-->
                                                <div class="row my-3">
                                                    <span class="text-muted fs-7">
                                                        Giới tính 
                                                        <i 
                                                        type="button"
                                                        class="fa-solid fa-circle-question" 
                                                        data-bs-container="body" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-placement="right" 
                                                        data-bs-content="Bạn có thể thay đổi người nhìn thấy giới tính của mình trên trang cá nhân vào lúc khác. 
                                                        Chọn Tùy chỉnh nếu bạn thuộc giới tính khác hoặc không muốn tiết lộ."
                                                        ></i>

                                                    </span>
                                                    <div class="col">
                                                        <div class="border rounded p-2">
                                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" >
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                            Nam 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="border rounded p-2">
                                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                            Nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="border rounded p-2">
                                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" >
                                                            <label class="form-check-label" for="flexRadioDefault3">
                                                            Tùy chỉnh
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--gender seclect-->
                                                <div class="d-none" id="genderSelect">
                                                    <select name="" id="" class="form-select">
                                                        <option value="1" class="">Cô ấy:"chúc cô ấy sinh nhật vui vẻ!"</option>
                                                        <option value="2" class="">Anh ấy:"chúc anh ấy sinh nhật vui vẻ!"</option>
                                                        <option value="3" class="">Họ:"chúc họ sinh nhật vui vẻ!"</option>
                                                    </select>
                                                    <div class="mt-3">
                                                        <span class="text-muted fs-7">Danh xưng của bạn hiển thị với tất cả mọi người.</span>
                                                        <input type="text" class="form-control" value="" placeholder="Giới tính (lựa chọn)">
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
                                                    <button  type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#creatModal">
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
    <footer class="bg-while p-4 text-muted ">
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
                <p class="fs-7">Facebook & HoDuMaiTran</p>
            </div>

    </footer>