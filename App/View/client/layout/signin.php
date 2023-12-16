<?php
$register = new User();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['register']) && ($_POST['register'])) {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $error_email = []; // Khởi tạo thông báo lỗi về email
    $error_phone = []; // Khởi tạo thông báo lỗi về số điện thoại

    if (!empty($email)) {
        // Kiểm tra email đã tồn tại hay chưa
        if ($register->checkEmailExists($email, $user_id)) {
            $error_email['register'] = 'Email đã tồn tại. Vui lòng chọn email khác.';
        }
    }

    if (!empty($phone)) {
        // Kiểm tra số điện thoại đã tồn tại hay chưa
        if ($register->checkPhoneExists($phone, $user_id)) {
            $error_phone['register'] = 'Số điện thoại đã tồn tại. Vui lòng chọn số điện thoại khác.';
        }
    }

    // Kiểm tra xem có thông báo lỗi nào được tạo ra không
    if (!empty($error_email) || !empty($error_phone)) {
        // Nếu có thông báo lỗi, hiển thị chúng
        if (!empty($error_email)) {
            $error_email['register'];
        } else {
            $error_email['register'] = '';
        }
        if (!empty($error_phone)) {
            $error_phone['register'];
        } else {
            $error_phone['register'] = '';
        }
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ($register->addUser($first_name, $last_name, $email, $phone, $password, $gender)) {
            echo ("Thành công");
            header("Location: index.php");
        } else {
            echo ("Thất bại");
        }
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        if ($check = $register->checkUser($email, $password)) {
            $user_token = md5(uniqid());
            $id = $register->getIdByEmail($email);
            if ($update = $register->updateUserToken($user_token, $id['id'])) {
                $user_data = $register->getIdUser($email, $password);
                $_SESSION['user'] = $user_data;
                header('Location: index.php');
            }
        } elseif ($check = $register->checkAdmin($email, $password)) {
            $user_data = $register->getIdUser($email, $password);
            $_SESSION['user'] = $user_data;
            header('Location: index.php');
        } else {
            $error['login'] = 'Email hoặc mật khẩu không chính xác !';
        }
    }
}
?>
<div class="d-flex flex-column justify-content-between min-vh-100">
    <div class="container-fluid bg-gray">
        <!-- login -->
        <div class="container d-flex flex-column flex-lg-row justify-content-evenly p-5 ">
            <!--heading-->
            <div class="text-center text-lg-start mt-lg-5 pt-lg-5">
                <h1 class="text-primary fw-bold fs-0">
                    BeeSocial
                </h1>
                <p class="w-75 mx-auto mx-lg-0 fs-4">
                    BeeSocial nơi kết nối những chú ong nhà FPT Polytechnic
                </p>
            </div>
            <!--form-->
            <div style="max-width: 28rem; width: 100%">
                <form class="bg-white shadow rounded p-3 input-group-lg" method="POST" id="form-login" onsubmit="LoginFormSubmit(event)">
                    <input type="email" name="email" id="email1" class="form-control my-3" placeholder="Email">
                    <span class="text-danger" id="email_Span"></span>
                    <input type="password" name="password" id="password1" class="form-control my-3" placeholder="Mật khẩu">
                    <span class="text-danger mt-2" id="password_Span"></span><br>
                    <span class="text-danger">
                        <?php
                        if (!empty($error['login'])) {
                            echo $error['login'];
                        } else {
                            echo '';
                        }
                        ?>
                    </span>
                    <input class="btn btn-primary w-100 my-3 fw-bold" type="submit" name="login" value="Đăng nhập">
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
                </form>
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
                                <form action="" method="post" id="form-register" onsubmit="handleFormSubmit(event)">
                                    <!--name-->
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Họ">
                                            <div class="mt-2">
                                                <span class="text-danger" id="lastSpan"></span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Tên">
                                            <div class="mt-2">
                                                <span class="text-danger" id="firstSpan"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--email and password-->
                                    <input type="email" name="email" id="email" class="form-control my-3" placeholder="Email" />
                                    <span class="text-danger" id="emailText"></span>
                                    <div class="mt-2">
                                        <span class="text-danger">
                                            <?php
                                            if (isset($error_email['register'])) {
                                                echo $error_email['register'];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <input type="text" name="phone" id="phone" class="form-control my-3" placeholder="Số điện thoại" />
                                    <span class="text-danger" id="phoneText"></span>
                                    <div class="mt-2">
                                        <span class="text-danger">
                                            <?php
                                            if (isset($error_phone['register'])) {
                                                echo $error_phone['register'];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control my-3" placeholder="Mật khẩu" />
                                    <span class="text-danger" id="passText"></span>
                                    <!--gender-->
                                    <div class="row my-3">
                                        <span class="text-muted fs-7 mb-1">
                                            Giới tính
                                            <i type="button" class="fa-solid fa-circle-question" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Bạn có thể thay đổi người nhìn thấy giới tính của mình trên trang cá nhân vào lúc khác. 
                                                        Chọn Tùy chỉnh nếu bạn thuộc giới tính khác hoặc không muốn tiết lộ."></i>

                                        </span>
                                        <div class="col">
                                            <div class="border rounded p-2">
                                                <input class="form-check-input" type="radio" name="gender" id="men" value="Nam">
                                                <label class="form-check-label" for="men">
                                                    Nam
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="border rounded p-2">
                                                <input class="form-check-input" type="radio" name="gender" id="women" value="Nữ">
                                                <label class="form-check-label" for="women">
                                                    Nữ
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-danger" id="genderSpan"></span>
                                        </div>
                                    </div>
                                    <!--btn-->
                                    <div class="text-center my-4">
                                        <input type="submit" class="btn btn-success btn-lg" name="register" value="Đăng ký">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--creat modal ends-->
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
            <p class="fs-7">BeeSocial</p>
        </div>
    </footer>
</div>