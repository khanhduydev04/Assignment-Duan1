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
                    <form action="" method="POST" class="p-lg-2">
                        <p class="">Vui lòng kiểm tra email để nhận mã xác nhận.</p>
                        <input type="text" name="code" id="" class="form-control p-3" placeholder="Mã xác nhận">
                        <?php
                            if(isset($_POST['check_code'])){
                                $error = array();
                                if(empty($_POST['code'])){
                                    $error['empty'] = 'Vui lòng nhập mã xác nhận.';
                                } elseif($_POST['code'] != $_SESSION['code']){
                                    $error['fail'] = 'Mã xác nhận không hợp lệ.';
                                } else {
                                    header('location: index.php?ctrl=forgetpassword&act=capnhatmatkhau');
                                }
                            }

                            // Hiển thị thông báo lỗi (nếu có)
                            if(isset($error)){
                                foreach($error as $message){
                                    echo '<div class="text-danger mt-3 me-3" role="alert">'.$message.'</div>';
                                }
                            }
                        ?>
                        <hr>
                        <button type="submit" class="btn btn-primary" name="check_code">Kiểm tra</button>
                    </form>
                    
                </div>


                
            <?php break;
            case "capnhatmatkhau": ?>
                <div class="bg-white shadow rounded p-3 pt-3 input-group-lg" style="width: 28rem;">
                    <strong class="p-lg-2">Đổi mới mật khẩu</strong>
                    <hr>
                    <form action="" method="POST" class="p-lg-2">
                        <p class="">Vui lòng nhập mật khẩu mới.</p>
                        <input type="password" name="newpass" class="form-control px-3 py-2 my-2" placeholder="Mật khẩu mới" required>
                        <input type="password" name="repass" class="form-control px-3 py-2 my-2" placeholder="Xác nhận mật khẩu" required>
                        <hr>
                        <button type="submit" class="btn btn-primary" name="changepass">Cập nhật</button>
                    </form>
                    <?php
                        if (isset($_POST['changepass'])) {
                            $newPass = $_POST['newpass'];
                            $rePass = $_POST['repass'];

                            // Kiểm tra xem mật khẩu có ít nhất 8 ký tự và chứa ít nhất 1 ký tự đặc biệt
                            if (strlen($newPass) < 8 || !preg_match("/[!@#$%^&*]/", $newPass)) {
                                echo "<p class='text-danger'>Mật khẩu ít nhất phải có 8 ký tự và chứa ít nhất 1 ký tự đặc biệt!</p>";
                            } else {
                                if ($newPass !== $rePass) {
                                    echo "<p class='text-danger'>Nhập lại mật khẩu không khớp!</p>";
                                } else {
                                    $user = new User();
                                    $email = $_SESSION['mail'];
                                    $user_id = $user->getIdByEmail($email);
                                    $user->updatePassword($user_id, $newPass);
                                    echo "<p class='text-success'>Đổi mật khẩu thành công!</p>";
                                    header('refresh:3s; index.php?ctrl=forgetpassword');
                                }
                            }
                        }
                        ?>

                </div>

                </div>
        <?php break;
        }
    } else { ?>
        <div class="bg-white shadow rounded pt-3 input-group-lg" style="width: 28rem;">
            <strong class="p-lg-3">Tìm tài khoản của bạn</strong>
            <hr>
            <form action="" method="POST" class="p-lg-2 needs-validation" novalidate>
                <p class="">Vui lòng nhập email tài khoản của bạn.</p>
                <input type="email" name="email" class="form-control p-3" placeholder="Email" required>
                <?php
                    $error = []; // Tạo một mảng để lưu các thông báo lỗi

                    if (isset($_POST['check_mail'])) {
                        $email = $_POST['email'];

                        if ($email === '') {
                            $error['email'] = 'Vui lòng nhập email';
                        } else {
                            // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay không
                            $user = new User();
                            if (!$user->checkEmailExists($email)) {
                                $error['email'] = 'Email không tồn tại';
                            }
                        }

                        if (empty($error)) {
                            // Tiến hành gửi email và chuyển hướng
                            $code = substr(rand(0,999999),0,6);
                            $title = "Quên mật khẩu";
                            $content = "Mã xác nhận của bạn là: <span style='color:blue'>" . $code . "</span>";
                            $mail = new Mailer();
                            $mail->sendMail($title, $content, $email);

                            $_SESSION['mail'] = $email;
                            $_SESSION['code'] = $code;
                            header("location: index.php?ctrl=forgetpassword&act=xacnhan");
                        }
                    }
                    ?>


                    <!-- Trường hợp hiển thị lỗi -->
                    <?php if (!empty($error)){
                      
                        foreach($error as $message){
                            echo '<div class="text-danger mt-3 me-3" role="alert">'.$message.'</div>';
                        }
                    
                        } ?>              
                <hr>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-2">
                    <button type="button" class="btn btn-secondary">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="check_mail">Gửi mã</button>
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