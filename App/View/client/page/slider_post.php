<?php
$post = new Post();
$photo = new Photo();
$user = new User();

$user_id = $_SESSION['user']['id']; //id của user hiện tại
$id = $_GET['id_post'];
$post_data = $post->getPostById($id);

//Hàm xử lý thời gian 
function calculateTimeAgo($time)
{
  $now = time();
  $timestamp = strtotime($time);
  $timeDifference = $now - $timestamp;

  if ($timeDifference < 3600) {
    return floor($timeDifference / 60) . " phút trước";
  } elseif ($timeDifference < 86400) {
    return floor($timeDifference / 3600) . " giờ trước";
  } elseif ($timeDifference < 604800) {
    return floor($timeDifference / 86400) . " ngày trước";
  } else {
    return date("d/m/Y H:i:s", $timestamp);
  }
}
?>
<main class="container-slider-post" style="width: 100%;">
    <div class="d-flex justify-content-center align-items-center" style="width: 100%;">
        <!-- picture -->
        <div class="bg-dark" style="width: 80%; height: 100vh;">
            <div class="d-flex flex-row mb-3" style="width: 80%;">
                <!-- close -->
                <a href="index.php" class="p-2 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-xmark fs-3" style="color: #fff;"></i>
                </a>
                <!-- logo -->
                <div class="p-2">
                    <a href="index.php" class="d-block overflow-hidden rounded-circle" style="width: 2.5rem">
                        <img src="./Public/images/beebook-logo.png" alt="Logo Beebook" class="object-fit-cover w-100">
                    </a>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 90vh;">
                <div class="d-flex justify-content-center align-items-center" style="width: 60%%; height: 100%;">
                    <!-- Slider main container -->
                    <div class="slider-container">
                        <?php
                        $id = $_GET['id_post'];
                        $images = $photo->getPhotoByPost($id);
                        $imageUrls = [];
                        foreach ($images as $img) {
                            $imageUrls[] = $img['image_url'];
                            echo 
                            '<img src="./Public/upload/' . $img['image_url'] . '" alt="" class="slider-image">';
                        }
                        ?>
                    </div>
                    <button class="prev-btn">
                        <i class="fa-solid fa-chevron-left" style="color: #fafafa;"></i>
                    </button>
                    <button class="next-btn">
                        <i class="fa-solid fa-chevron-right" style="color: #fafafa;"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- name user post -->
        <div class="container-slider-name bg-white" style="width: 20%; height: 100vh; ">
            <div class="d-flex flex-row-reverse p-1 border-bottom">
                <div class="col d-flex align-items-center justify-content-end">
                    <!-- chat -->
                    <div class="rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center mx-2" style="width: 38px; height: 38px" type="button" id="chatMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <i class="fas fa-comment"></i>
                    </div>
                    <!-- chat  dd -->
                    <ul class="dropdown-menu border-0 shadow p-3 overflow-auto" aria-labelledby="chatMenu" style="width: 21em; max-height: 600px">
                    <!-- header -->
                    <li class="p-1">
                        <div class="d-flex justify-content-between">
                        <h2 class="fs-4">Tin nhắn</h2>
                        </div>
                    </li>
                    <!-- search -->
                    <li class="p-1">
                        <div class="input-group-text bg-gray border-0 rounded-pill" style="min-height: 40px; min-width: 230px">
                        <i class="fas fa-search me-2 text-muted"></i>
                        <input type="text" class="form-control rounded-pill border-0 bg-gray" placeholder="Tìm tin nhắn">
                        </div>
                    </li>
                    <!-- message 1 -->
                    <li class="my-2 p-1" type="button" data-bs-toggle="modal" data-bs-target="#singleChat1">
                        <div class="d-flex align-items-center justify-content-between">
                        <!-- big avatar -->
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">Mike</p>
                            <span class="fs-7 text-muted">Lorem ipsum • 7d</span>
                            </div>
                        </div>
                        </div>
                    </li>
                    <!-- message 2 -->
                    <li class="my-2 p-1" type="button" data-bs-toggle="modal" data-bs-target="#singleChat2">
                        <div class="d-flex align-items-center justify-content-between">
                        <!-- big avatar -->
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">
                                Tuan
                                <span class="fs-7 text-muted">Lorem ipsum • 7d</span>
                            </p>
                            </div>
                        </div>
                        </div>
                    </li>
                    <!-- message 3 -->
                    <li class="my-2 p-1" type="button" data-bs-toggle="modal" data-bs-target="#singleChat3">
                        <div class="d-flex align-items-center justify-content-between">
                        <!-- big avatar -->
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">Jerry</p>
                            <span class="fs-7 text-muted">Lorem ipsum • 7d</span>
                            </div>
                        </div>
                        </div>
                    </li>
                    <!-- message 4 -->
                    <li class="my-2 p-1" type="button" data-bs-toggle="modal" data-bs-target="#singleChat4">
                        <div class="d-flex align-items-center justify-content-between">
                        <!-- big avatar -->
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">Tony</p>
                            <span class="fs-7 text-muted">Lorem ipsum • 7d</span>
                            </div>
                        </div>
                        </div>
                    </li>
                    <!-- message 5 -->
                    <li class="my-2 p-1" type="button" data-bs-toggle="modal" data-bs-target="#singleChat5">
                        <div class="d-flex align-items-center justify-content-between">
                        <!-- big avatar -->
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">Phu</p>
                            <span class="fs-7 text-muted">Lorem ipsum • 7d</span>
                            </div>
                        </div>
                        </div>
                    </li>
                    <hr class="m-0">
                    <a href="#" class="text-decoration-none">
                        <p class="fw-bold text-center pt-3 m-0">See All in Messenger</p>
                    </a>
                    </ul>
                    <!-- notifications -->
                    <div class=" rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center mx-2" style="width: 38px; height: 38px" type="button" id="notMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <i class="fas fa-bell"></i>
                    </div>
                    <!-- notifications dd -->
                    <ul class="dropdown-menu border-0 shadow p-3" aria-labelledby="notMenu" style="width: 21em; max-height: 600px; overflow-y: auto">
                    <!-- header -->
                    <li class="p-1">
                        <div class="d-flex justify-content-between">
                        <h2 class="fs-4">Thông báo</h2>
                        </div>
                    </li>
                    <!-- news 1 -->
                    <li class="my-2 p-1">
                        <a href="#" class="d-flex align-items-center justify-content-evenly text-decoration-none text-dark">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Harum unde amet at nulla quae porro.
                            </p>
                            <span class="fs-7 text-primary">about an hour ago</span>
                            </div>
                        </div>
                        </a>
                    </li>
                    <!-- news 2 -->
                    <li class="my-2 p-1">
                        <a href="#" class="d-flex align-items-center justify-content-evenly text-decoration-none text-dark">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Harum unde amet at nulla quae porro.
                            </p>
                            <span class="fs-7 text-primary">about an hour ago</span>
                            </div>
                        </div>
                        </a>
                    </li>
                    <!-- news 3 -->
                    <li class="my-2 p-1">
                        <a href="#" class="d-flex align-items-center justify-content-evenly text-decoration-none text-dark">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Harum unde amet at nulla quae porro.
                            </p>
                            <span class="fs-7 text-primary">about an hour ago</span>
                            </div>
                        </div>
                        </a>
                    </li>
                    <!-- news 4 -->
                    <li class="my-2 p-1">
                        <a href="#" class="d-flex align-items-center justify-content-evenly text-decoration-none text-dark">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Harum unde amet at nulla quae porro.
                            </p>
                            <span class="fs-7 text-primary">about an hour ago</span>
                            </div>
                        </div>
                        </a>
                    </li>
                    <!-- news 5 -->
                    <li class="my-2 p-1">
                        <a href="#" class="d-flex align-items-center justify-content-evenly text-decoration-none text-dark">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <div class="p-2">
                            <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover">
                            </div>
                            <div>
                            <p class="fs-7 m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Harum unde amet at nulla quae porro.
                            </p>
                            <span class="fs-7 text-primary">about an hour ago</span>
                            </div>
                        </div>
                        </a>
                    </li>
                    </ul>
                    <!-- secondary menu -->
                    <div class="align-items-center justify-content-center d-xl-flex mx-2" type="button" id="secondMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                <img src="./Public/upload/TRan.png" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover">
                            </div>
                    <!-- secondary menu dd -->
                    <ul class="dropdown-menu border-0 shadow p-3" aria-labelledby="secondMenu" style="width: 21em">
                    <!-- avatar -->
                    <li type="button">
                        <a href="index.php?ctrl=profile" class="dropdown-item p-1 rounded d-flex align-items-center">
                                        <img src="./Public/upload/TRan.png" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover">
                                        <p class="m-0 fw-semibold">Khánh Duy</p>
                        </a>
                    </li>
                    <hr>
                    <!-- options -->
                    <!-- 1 -->
                    <li class="dropdown-item p-1 my-3 rounded" type="button">
                        <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="d-flex" data-bs-toggle="dropdown">
                            <i class="fas fa-cog bg-gray p-2 rounded-circle"></i>
                            <div class="ms-3 d-flex justify-content-between align-items-center w-100">
                                <p class="m-0">Cài đặt</p>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                            </div>
                            <!-- nested menu -->
                            <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="index.php?ctrl=setting">
                                <div class="rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <p class="m-0">Thông tin cá nhân</p>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="index.php?ctrl=setting&amp;act=change_password">
                                <div class="rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <p class="m-0">Mật khẩu và bảo mật</p>
                                </a>
                            </li>
                            </ul>
                        </li>
                        </ul>
                    </li>
                    <!-- 2 -->
                    <li class="dropdown-item p-1 my-3 rounded" type="button">
                        <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="d-flex">
                            <i class="fas fa-moon bg-gray p-2 rounded-circle" style="width: 32px; height: 32px;"></i>
                            <div class="ms-3 d-flex justify-content-between align-items-center w-100">
                                <p class="m-0">Chế độ hiển thị</p>
                            </div>
                            </div>
                        </li>
                        </ul>
                    </li>
                    <!-- 3 -->
                    <li class="dropdown-item p-1 my-3 rounded" type="button">
                        <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index.php?ctrl=logout" class="d-flex text-decoration-none text-dark">
                            <i class="fas fa-cog bg-gray p-2 rounded-circle"></i>
                            <div class="ms-3 d-flex justify-content-between align-items-center w-100">
                                <p class="m-0">Đăng xuất</p>
                            </div>
                            </a>
                        </li>
                        </ul>
                    </li>
                    </ul>
                    <!-- end -->
                </div>  
            </div>
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
                <!-- avatar -->
                <div class="d-flex justify-content-between w-100">
                    <!-- author -->
                    <div class="d-flex justify-content-between p-3 pb-0">
                    <!-- avatar -->
                    <div class="d-flex justify-content-between w-100 gap-5">
                        <!-- avatar -->
                        <div class="d-flex">
                        <?php
                        if (($photo->getNewAvatarByUser($post_data['user_id']) != null)) { ?>
                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($post_data['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                        <?php } else { ?>
                            <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                        <?php }
                        ?>
                        <div>
                            <p class="m-0 fw-bold"><?= $user->getFullnameByUser($post_data['user_id'])?></p>
                            <span class="text-muted fs-7"><?= calculateTimeAgo($post_data['created_at']) ?></span>
                        </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 ms-3 me-3">
            <?php
               
                echo '<p class="fs-8">'. $post_data['content'] .'</p>';
                
            ?>
        </div>
        <hr>
    </div>
</main>

<!-- Đảm bảo bạn đã bao gồm thư viện jQuery trước khi sử dụng mã này -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var currentIndex = 0;
        var images = $('.slider-image');
        var imageAmount = images.length;

        function cycleImages() {
            var image = $('.slider-image').eq(currentIndex);
            images.hide();
            image.show();
        }

        $('.next-btn').click(function () {
            currentIndex += 1;
            if (currentIndex > imageAmount - 1) {
                currentIndex = 0;
            }
            cycleImages();
        });

        $('.prev-btn').click(function () {
            currentIndex -= 1;
            if (currentIndex < 0) {
                currentIndex = imageAmount - 1;
            }
            cycleImages();
        });

    });
</script>
