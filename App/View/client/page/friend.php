<?php
$user =  new User();
$friend = new Friend();
$photo = new Photo();
?>
<div class="container-fluid bg-gray">
    <div class="row justify-content-evenly">
        <!-- sidebar -->
        <div class="col-12 col-lg-3">
            <div class="d-none d-xxl-block h-100 fixed-top shadow-sm overflow-hidden scrollbar" style="max-width: 360px; width: 100%; z-index: 4; padding-top: 57px;">
                <div class="p-3 bg-main">
                    <ul class="navbar-nav mt-1 ms-1 d-flex flex-column pb-5 mb-2" style="padding-top: 1px">
                        <div class="d-flex justify-content-between align-items-center w-100 ">
                            <p class="m-0 ms-2 fw-bold" style="font-size: 25px;">Bạn bè</p>
                        </div>
                        <li class="btn-bg dropdown-item p-1 mt-3 rounded" id="myButton">
                            <div class="d-flex">
                                <i class="fa-solid fa-user-group bg-gay p-2 rounded-circle" style="font-size: 20px; color: #000;"></i>
                                <a href="index.php?ctrl=friends" class="d-flex ms-3 align-items-center text-decoration-none text-dark">
                                    <p class="m-0 p-2" style="font-weight: 500; font-size: 17px;">Trang chủ</p>
                                </a>
                            </div>
                        </li>
                        <li class="btn-bg dropdown-item p-1 mt-3 rounded" id="myButton">
                            <div class="d-flex">
                                <i class="fa-solid fa-user-plus bg-gay p-2 rounded-circle" style="font-size: 20px; color: #000;"></i>
                                <a href="index.php?ctrl=friends&act=requests" class="d-flex ms-3 align-items-center text-decoration-none text-dark">
                                    <p class="m-0 p-2" style="font-weight: 500; font-size: 17px;">Lời mời kết bạn</p>
                                </a>
                            </div>
                        </li>
                        <li class="btn-bg dropdown-item p-1 mt-3 rounded" id="myButton">
                            <div class="d-flex">
                                <i class="fa-solid fa-user-group bg-gay p-2 rounded-circle" style="font-size: 20px; color: #000;"></i>
                                <a href="index.php?ctrl=friends&act=list" class="d-flex ms-3 align-items-center text-decoration-none text-dark">
                                    <p class="m-0 p-2" style="font-weight: 500; font-size: 17px;">Tất cả bạn bè</p>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- main -->
        <main class="col-12 col-lg-9">
            <?php
            if (isset($_GET['act'])) {
                $act = $_GET['act'];

                switch ($act) {
                    case "requests": ?>
                        <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 57px; max-width: 1080px">
                            <div class="mt-3 d-flex justify-content-between position-relative">
                                <div class="timeline d-flex pb-3 mt-4 justify-content-between align-content-center">
                                    <p class="m-0 fw-bold text-p">Lời mời kết bạn</p>
                                </div>
                            </div>
                            <div class="d-flex pb-2 mt-0 justify-content-between align-content-center">
                                <p class="m-0" style="font-weight: 500; color: rgb(65, 113, 194);">5 lời mời kết bạn</p>
                            </div>
                            <div class="pb-3 mt-3 align-content-center justify-content-between">
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php break;
                    case "list": ?>
                        <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 57px; max-width: 1080px">
                            <div class="mt-3 d-flex justify-content-between position-relative">
                                <div class="timeline d-flex pb-3 mt-4 justify-content-between align-content-center">
                                    <p class="m-0 fw-bold text-p">Tất cả bạn bè</p>
                                </div>
                            </div>
                            <div class="pb-3 mt-3 align-content-center justify-content-between">
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                        <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                            <form action="">
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php break;
                }
            } else { ?>
                <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 57px; max-width: 1080px">
                    <div class="mt-3 d-flex justify-content-between position-relative">
                        <div class="timeline d-flex pb-3 mt-4 justify-content-between align-content-center">
                            <p class="m-0 fw-bold text-p">Lời mời kết bạn</p>
                            <p class="m-0 mt-2 text-blue">Xem tất cả</p>
                        </div>
                    </div>
                    <div class="pb-3 mt-3 align-content-center justify-content-between">
                        <div class="d-flex align-items-center flex-wrap row-gap-2">
                            <div class="px-1" style="width: calc(100% / 5)">
                                <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                    <form action="">
                                        <div class="d-grid gap-2 mx-auto mt-3">
                                            <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                            <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="px-1" style="width: calc(100% / 5)">
                                <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                    <form action="">
                                        <div class="d-grid gap-2 mx-auto mt-3">
                                            <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                            <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="px-1" style="width: calc(100% / 5)">
                                <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                    <form action="">
                                        <div class="d-grid gap-2 mx-auto mt-3">
                                            <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                            <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="px-1" style="width: calc(100% / 5)">
                                <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                    <form action="">
                                        <div class="d-grid gap-2 mx-auto mt-3">
                                            <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                            <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="px-1" style="width: calc(100% / 5)">
                                <img src="./Public/images/banner-men.png" alt="" class="img" style="width: 100%;">
                                <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;">Kiệt Nhỏ</p>
                                    <form action="">
                                        <div class="d-grid gap-2 mx-auto mt-3">
                                            <input type="button" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                            <input type="button" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 15px; max-width: 1080px">
                    <div class="mt-2 d-flex justify-content-between position-relative">
                        <div class="timeline d-flex pb-3 justify-content-between align-content-center">
                            <p class="m-0 fw-bold text-p">Những người bạn có thể biết</p>
                        </div>
                    </div>
                    <div class="pb-3 mt-3 align-content-center justify-content-between">
                        <div class="d-flex align-items-center flex-wrap row-gap-2">
                            <?php
                            $otherUser =  $user->getAllUser($_SESSION['user']['id']);
                            if (!empty($otherUser) && $otherUser !== null) {
                                foreach ($otherUser as $row) { ?>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <form action="" method="post">
                                            <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                                                <?php
                                                if (($photo->getNewAvatarByUser($row['id']) != null)) { ?>
                                                    <img src="./Upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="" class="img" style="width: 100%;" />
                                                <?php } else { ?>
                                                    <img src="./Public/images/avt_default.png" alt="" class="img" style="width: 100%;" />
                                                <?php }
                                                ?>
                                            </a>
                                            <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                                <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>" class="text-black">
                                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;"><?= $row['first_name'] . ' ' . $row['last_name'] ?></p>
                                                </a>
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="submit" class="btn btn-greenest" value="Thêm bạn bè" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="submit" class="btn btn-delete" value="Xoá,gỡ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </main>
    </div>
</div>