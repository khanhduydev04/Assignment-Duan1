<?php
$user =  new User();
$friend = new Friend();
$photo = new Photo();
$follow = new Follow();
$notification = new Notification();

$user_id = $_SESSION['user']['id'];
$user_id2 = $_POST['user_id2'];

// add friend
if (isset($_POST["send_request"])) {
    if ($friend->addFriend($user_id, $user_id2)) {
        if ($follow->insertFollow($user_id, $user_id2)) {
            $noti_content = 'Bạn có 1 lời mời kết bạn mới';
            $noti_href = 'index.php?ctrl=friends&act=requests';
            if ($notification->insertNotification($noti_content, $noti_href, $user_id2)) {
                header("Location: index.php?ctrl=friends");
            }
        }
    }
}
//accept request
if (isset($_POST["accept_request"])) {
    $friend_id = $friend->getFriendID($user_id, $user_id2);
    $follow_id = $follow->getFollowID($user_id, $user_id2);
    if ($friend->acceptRequest($friend_id)) {
        if ($follow->insertFollow($user_id, $user_id2)) {
            $noti_name = $user->getFullnameByUser($user_id);
            $noti_content = "$noti_name đã chấp nhận lời mời kết bạn";
            $noti_href = 'index.php?ctrl=friends&act=list';
            if ($notification->insertNotification($noti_content, $noti_href, $user_id2)) {
                header("Location: index.php?ctrl=friends");
            }
        }
    }
}
//cancel request && delete friend
if (isset($_POST["cancel_request"]) || isset($_POST["delete_friend"])) {
    $friend_id = $friend->getFriendID($user_id, $user_id2);
    $follow_id = $follow->getFollowID($user_id, $user_id2);
    if ($friend->deleteFriend($friend_id)) {
        if ($follow->deleteFollow($follow_id)) {
            header("Location: index.php?ctrl=friends");
        }
    }
}
//cancel_follow
if (isset($_POST["cancel_follow"])) {
    $follow_id = $follow->getFollowID($user_id, $user_id2);
    if ($follow->deleteFollow($follow_id)) {
        header("Location: index.php?ctrl=friends");
    }
}
//add_follow
if (isset($_POST["add_follow"])) {
    if ($follow->insertFollow($user_id, $user_id2)) {
        header("Location: index.php?ctrl=friends");
    }
}
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
                                <p class="m-0" style="font-weight: 500; color: rgb(65, 113, 194);"><?= $friend->countRequestByUser($user_id) ?> lời mời kết bạn</p>
                            </div>
                            <div class="pb-3 mt-3 align-content-center justify-content-between">
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    <?php
                                    $friend_request = $friend->getAllRequestByUser($user_id, 'all');
                                    if (!empty($friend_request) && $friend_request !== null) {
                                        foreach ($friend_request as $row) {
                                            $row = $user->getUserById($row['user_id1']); ?>
                                            <div class="px-1" style="width: calc(100% / 5)">
                                                <form action="" method="post">
                                                    <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                                                        <?php
                                                        if (($photo->getNewAvatarByUser($row['id']) != null)) { ?>
                                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="" class="img" style="width: 100%;" />
                                                        <?php } else { ?>
                                                            <img src="./Public/images/avt_default.png" alt="" class="img" style="width: 100%;" />
                                                        <?php }
                                                        ?>
                                                    </a>
                                                    <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                                        <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>" class="text-black">
                                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;"><?= $user->getFullnameByUser($row['id']) ?></p>
                                                        </a>
                                                        <div class="d-grid gap-2 mx-auto mt-3">
                                                            <input type="hidden" value="<?= $row['id'] ?>" name="user_id2">
                                                            <input type="submit" class="btn btn-primary" value="Xác nhận" name="accept_request" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                            <input type="submit" class="btn btn-delete" value="Xoá bỏ" name="cancel_request" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    <?php }
                                    } else {
                                        echo '<p class="w-100 fw-semibold text-center">Không có lời mời để hiển thị</p>';
                                    }
                                    ?>
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
                                    <?php
                                    $getFriends = $friend->getAllFriendByUser($user_id);
                                    if ($getFriends !== null && $getFriends) {
                                        foreach ($getFriends as $row) {
                                            if ($user_id != $row['user_id1']) {
                                                $row = $user->getUserById($row['user_id1']);
                                            } elseif ($user_id != $row['user_id2']) {
                                                $row = $user->getUserById($row['user_id2']);
                                            } ?>
                                            <div class="px-1" style="width: calc(100% / 5)">
                                                <form action="" method="post">
                                                    <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                                                        <?php
                                                        if (($photo->getNewAvatarByUser($row['id']) != null)) { ?>
                                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="" class="img" style="width: 100%;" />
                                                        <?php } else { ?>
                                                            <img src="./Public/images/avt_default.png" alt="" class="img" style="width: 100%;" />
                                                        <?php }
                                                        ?>
                                                    </a>
                                                    <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                                        <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>" class="text-black">
                                                            <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;"><?= $user->getFullnameByUser($row['id']) ?></p>
                                                        </a>
                                                        <div class="d-grid gap-2 mx-auto mt-3">
                                                            <input type="hidden" value="<?= $row['id'] ?>" name="user_id2">
                                                            <button type="submit" class="btn btn-primary" name="delete_friend" style="width: 90%; margin-left: 11px; font-weight: 500;">Hủy bạn</button>
                                                            <?php
                                                            if (!$follow->getFollowID($user_id, $row['id'])) {
                                                                echo '<button type="submit" class="btn btn-delete" name="add_follow" style="width: 90%; margin-left: 11px; font-weight: 500;">Theo dõi</button>';
                                                            } else {
                                                                echo '<button type="submit" class="btn btn-delete" name="cancel_follow" style="width: 90%; margin-left: 11px; font-weight: 500;">Bỏ theo dõi</button>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    <?php  }
                                    } else {
                                        echo '<p class="fw-semibold text-center w-100">Không có bạn bè để hiển thị</p>';
                                    }
                                    ?>
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
                            <?php
                            $friend_request = $friend->getAllRequestByUser($user_id, 8);
                            if (!empty($friend_request) && $friend_request !== null) {
                                foreach ($friend_request as $row) {
                                    $row = $user->getUserById($row['user_id1']); ?>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <form action="" method="post">
                                            <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                                                <?php
                                                if (($photo->getNewAvatarByUser($row['id']) != null)) { ?>
                                                    <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="" class="img" style="width: 100%;" />
                                                <?php } else { ?>
                                                    <img src="./Public/images/avt_default.png" alt="" class="img" style="width: 100%;" />
                                                <?php }
                                                ?>
                                            </a>
                                            <div class="shadow-sm fb-1" style="padding-top: 1px;">
                                                <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>" class="text-black">
                                                    <p class="m-0 mt-2 ms-2" style="font-size: 16px; font-weight: 600;"><?= $user->getFullnameByUser($row['id']) ?></p>
                                                </a>
                                                <div class="d-grid gap-2 mx-auto mt-3">
                                                    <input type="submit" name="accept_request" class="btn btn-primary" value="Xác nhận" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="user_id2">
                                                    <input type="submit" name="cancel_request" class="btn btn-delete" value="Xoá bỏ" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            <?php }
                            } else {
                                echo '<p class="w-100 fw-semibold text-center">Không có lời mời để hiển thị</p>';
                            }
                            ?>
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
                            $otherUser =  $user->getRadomUser($user_id, 12);
                            if (!empty($otherUser) && $otherUser !== null) {
                                foreach ($otherUser as $row) { ?>
                                    <div class="px-1" style="width: calc(100% / 5)">
                                        <form action="" method="post">
                                            <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                                                <?php
                                                if (($photo->getNewAvatarByUser($row['id']) != null)) { ?>
                                                    <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="" class="img" style="width: 100%;" />
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
                                                    <input type="submit" name="send_request" class="btn btn-greenest" value="Thêm bạn bè" style="width: 90%; margin-left: 11px; font-weight: 500;">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="user_id2">
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