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
                <div class="d-flex justify-content-center align-items-center" style="width: 60%; height: 100%;">
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
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($post_data['user_id']) ?></p>
                                    <span class="text-muted fs-7"><?= calculateTimeAgo($post_data['created_at']) ?></span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 ms-3 me-3">
                <?php
                echo '<p class="fs-8">' . $post_data['content'] . '</p>';
                ?>
            </div>
            <hr>
        </div>
</main>

<!-- Đảm bảo bạn đã bao gồm thư viện jQuery trước khi sử dụng mã này -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var currentIndex = 0;
        var images = $('.slider-image');
        var imageAmount = images.length;

        function cycleImages() {
            var image = $('.slider-image').eq(currentIndex);
            images.hide();
            image.show();
        }

        $('.next-btn').click(function() {
            currentIndex += 1;
            if (currentIndex > imageAmount - 1) {
                currentIndex = 0;
            }
            cycleImages();
        });

        $('.prev-btn').click(function() {
            currentIndex -= 1;
            if (currentIndex < 0) {
                currentIndex = imageAmount - 1;
            }
            cycleImages();
        });

    });
</script>