<?php
$post = new Post();
$photo = new Photo();
$user = new User();
$comment = new Comment();
$like = new Likes();
$share = new Share();
$notification = new Notification();

$post_id = (int)$_GET['post_id'];
$row = $post->getPostById($post_id);
var_dump($post->getPostById($post_id));
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
    return date("d/m/Y", $timestamp);
  }
}
?>
<main style="padding-top: 56px;">
  <div class="mx-auto pt-4" style="max-width: 680px;">
    <?php
    $shareArray = $share->getAllShareId();
    $sharedPostIds = []; // Mảng để lưu trữ các post_id được chia sẻ
    //lặp lấy post_id
    foreach ($shareArray as $sharedPostId) {
      $sharedPostIds[] = $sharedPostId['post_share_id'];
    }
    if (in_array($post_id, $sharedPostIds)) {
      $post_share_id = $share->getPostShare($post_id);
      $post_data = $post->getPostById($post_id);
      $row = $post->getPostById($post_share_id['post_id']);
      $check_photo = $photo->countPhotoByPost($row['id']);

      //Phân layout dựa trên hình ảnh
      switch ($check_photo) {
        case 0: ?>
          <!-- post-layout -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
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
              <!-- edit -->
              <?php
              if ($user_id === $post_data['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $post_data['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="border rounded-4 m-4">
              <!--avatar-->
              <div class="d-flex align-items-center mt-2 ms-3 mb-3">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                        <p class="px-3">' . $row['content'] . '</p>
                                    </div>';
              }
              ?>
            </div>
            <!-- likes & comments -->
            <div class="post__comment position-relative pt-0">
              <!-- likes-comment -->
              <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                <!-- like -->
                <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $post_data['id'] ?>">
                  <?php
                  $post_id = $post_data['id'];
                  $response = $like->countPhotoByLike($post_id);
                  if ($response) {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                  } else {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                  }
                  ?>
                </button>
                <!-- comment -->
                <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                  <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                  <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                </div>
              </div>
              <hr class="mt-0 mb-2 mx-3" />
              <!-- comment & like bar -->
              <form method="POST" class="d-flex justify-content-around px-3 pb-2">
                <button type="button" name="post_id" value="<?php echo $post_data['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <?php
                  $post_id = $post_data['id'];
                  $Checklike = $like->checklike($user_id, $post_id);
                  if (!$Checklike) {
                    echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                  } else {
                    echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                  }
                  ?>
                  <p class="m-0">Yêu thích</p>
                </button>
                <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                  <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                  <p class="m-0">Bình luận</p>
                </div>
                <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                  <p class="m-0">Chia sẻ</p>
                </button>
              </form>
              <!-- comment model -->
              <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $post_data['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                </div>
                <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $post_data['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                  <div class="d-flex" style="margin-top: 18px;">
                    <?php
                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php } else { ?>
                      <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php }
                    ?>
                    <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                      <input type="hidden" name="parentId" value="0">
                      <input type="hidden" name="postId" value="<?= $post_data['id'] ?>">
                      <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                      <button type="submit" class="border-0 bg-transparent ms-1">
                        <i class="fa-solid fa-paper-plane text-primary"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        case 1: ?>
          <!-- post-layout-1 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
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
              <!-- edit -->
              <?php
              if ($user_id === $post_data['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $post_data['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="border rounded-4 m-4">
              <!--image-->
              <div id="post-images">
                <?php
                $image = $photo->getPhotoByPost($row['id']);
                echo '<img src="./Public/upload/' . $image[0]['image_url'] . '" alt="post image" class="img-fluid " style="width: 100%; border-radius: 15px 15px 0px 0px;"  />';
                ?>
              </div>
              <!--avatar-->
              <div class="d-flex align-items-center mt-2 ms-3 mb-3">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                        <p class="px-3">' . $row['content'] . '</p>
                                    </div>';
              }
              ?>
            </div>
            <!-- likes & comments -->
            <div class="post__comment position-relative pt-0">
              <!-- likes-comment -->
              <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                <!-- like -->
                <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $post_data['id'] ?>">
                  <?php
                  $post_id = $post_data['id'];
                  $response = $like->countPhotoByLike($post_id);
                  if ($response) {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                  } else {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                  }
                  ?>
                </button>
                <!-- comment -->
                <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                  <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                  <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                </div>
              </div>
              <hr class="mt-0 mb-2 mx-3" />
              <!-- comment & like bar -->
              <form method="POST" class="d-flex justify-content-around px-3 pb-2">
                <button type="button" name="post_id" value="<?php echo $post_data['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <?php
                  $post_id = $post_data['id'];
                  $Checklike = $like->checklike($user_id, $post_id);
                  if (!$Checklike) {
                    echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                  } else {
                    echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                  }
                  ?>
                  <p class="m-0">Yêu thích</p>
                </button>
                <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                  <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                  <p class="m-0">Bình luận</p>
                </div>
                <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                  <p class="m-0">Chia sẻ</p>
                </button>
              </form>
              <!-- comment model -->
              <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $post_data['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                </div>
                <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $post_data['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                  <div class="d-flex" style="margin-top: 18px;">
                    <?php
                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php } else { ?>
                      <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php }
                    ?>
                    <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                      <input type="hidden" name="parentId" value="0">
                      <input type="hidden" name="postId" value="<?= $post_data['id'] ?>">
                      <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                      <button type="submit" class="border-0 bg-transparent ms-1">
                        <i class="fa-solid fa-paper-plane text-primary"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        case 2: ?>
          <!-- post-layout-2 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
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
              <!-- edit -->
              <?php
              if ($user_id === $post_data['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $post_data['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="border rounded-4 m-4">
              <!--image-->
              <div class="container m-0 g-0">
                <div class="row g-1" id="post-images">
                  <?php
                  $image = $photo->getPhotoByPost($row['id']);
                  foreach ($image as $img) {
                    echo '<div class="col">
                                            <img src="./Public/upload/' . $img['image_url'] . '" alt="post image" class="img-fluid" style="width: 100%;  height: 550px; border-radius: 10px 10px 0px 0px;"  />
                                            </div>';
                  }
                  ?>
                </div>
              </div>
              <!--avatar-->
              <div class="d-flex align-items-center mt-2 ms-3 mb-3">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                        <p class="px-3">' . $row['content'] . '</p>
                                    </div>';
              }
              ?>
            </div>
            <!-- likes & comments -->
            <div class="post__comment position-relative pt-0">
              <!-- likes-comment -->
              <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                <!-- like -->
                <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                  <?php
                  $post_id = $row['id'];
                  $response = $like->countPhotoByLike($post_id);
                  if ($response) {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                  } else {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                  }

                  ?>
                </button>
                <!-- comment -->
                <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                  <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                  <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                </div>
              </div>
              <hr class="mt-0 mb-2 mx-3" />
              <!-- comment & like bar -->
              <form method="POST" class="d-flex justify-content-around px-3 pb-2">
                <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <?php
                  $post_id = $row['id'];
                  $user_id = $_SESSION['user']['id'];
                  $Checklike = $like->checklike($user_id, $post_id);
                  if (!$Checklike) {
                    echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                  } else {
                    echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                  }
                  ?>
                  <p class="m-0">Yêu thích</p>
                </button>
                <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                  <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                  <p class="m-0">Bình luận</p>
                </div>
                <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                  <p class="m-0">Chia sẻ</p>
                </button>
              </form>
              <!-- comment model -->
              <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $post_data['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                </div>
                <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $post_data['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                  <div class="d-flex" style="margin-top: 18px;">
                    <?php
                    if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php } else { ?>
                      <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php }
                    ?>
                    <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                      <input type="hidden" name="parentId" value="0">
                      <input type="hidden" name="postId" value="<?= $post_data['id'] ?>">
                      <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                      <button type="submit" class="border-0 bg-transparent ms-1">
                        <i class="fa-solid fa-paper-plane text-primary"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- end -->
          </div>
        <?php break;
        case 3: ?>
          <!-- post-layout-3 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
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
              <!-- edit -->
              <?php
              if ($user_id === $post_data['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $post_data['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="border rounded-4 m-4">
              <!--image-->
              <div class="container m-0 g-0" style="width: 100%;">
                <div class="row g-1">
                  <?php
                  $image = $photo->getPhotoByPost($row['id']);
                  $imageUrls = [];
                  foreach ($image as $img) {
                    $imageUrls[] = $img['image_url'];
                  }
                  ?>
                  <div class="col-8">
                    <img src="./Public/upload/<?= $imageUrls[0] ?>" alt="post image" class="img-fluid" style="width: 100%; height: 604px; border-radius: 15px 0 0 0" />
                  </div>
                  <div class="col-4">
                    <?php
                    for ($i = 1; $i <= 2; $i++) {
                      $imageSrc = "./Public/upload/" . $imageUrls[$i];
                      $borderStyle = ($i === 1) ? 'border-radius: 0 15px 0 0' : ''; // Thêm border cho ảnh đầu tiên

                      echo '<img src="' . $imageSrc . '" alt="post image" class="img-fluid mb-1" style="height: 300px; width: 100%; ' . $borderStyle . '" />';
                    }
                    ?>
                  </div>
                </div>
              </div>

              <!--avatar-->
              <div class="d-flex align-items-center mt-2 ms-3 mb-3">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>

              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                        <p class="px-3">' . $row['content'] . '</p>
                                    </div>';
              }
              ?>



            </div>

            <!-- likes & comments -->
            <div class="post__comment position-relative pt-0">
              <!-- likes-comment -->
              <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                <!-- like -->
                <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                  <?php
                  $post_id = $row['id'];
                  $response = $like->countPhotoByLike($post_id);
                  if ($response) {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                  } else {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                  }

                  ?>
                </button>
                <!-- comment -->
                <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                  <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                  <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                </div>
              </div>
              <hr class="mt-0 mb-2 mx-3" />
              <!-- comment & like bar -->
              <form method="POST" class="d-flex justify-content-around px-3 pb-2">
                <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <?php
                  $post_id = $row['id'];
                  $user_id = $_SESSION['user']['id'];
                  $Checklike = $like->checklike($user_id, $post_id);
                  if (!$Checklike) {
                    echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                  } else {
                    echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                  }
                  ?>
                  <p class="m-0">Yêu thích</p>
                </button>
                <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                  <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                  <p class="m-0">Bình luận</p>
                </div>
                <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                  <p class="m-0">Chia sẻ</p>
                </button>
              </form>
              <!-- comment model -->
              <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $post_data['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                </div>
                <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $post_data['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                  <div class="d-flex" style="margin-top: 18px;">
                    <?php
                    if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php } else { ?>
                      <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php }
                    ?>
                    <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                      <input type="hidden" name="parentId" value="0">
                      <input type="hidden" name="postId" value="<?= $post_data['id'] ?>">
                      <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                      <button type="submit" class="border-0 bg-transparent ms-1">
                        <i class="fa-solid fa-paper-plane text-primary"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- end -->
          </div>
        <?php break;
        case 4: ?>
          <!-- post-layout-4 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
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
              <!-- edit -->
              <?php
              if ($user_id === $post_data['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $post_data['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="border rounded-4 m-4">
              <!--image-->
              <div class="container m-0 g-0 mb-1" style="width: 100%;">
                <div class="row g-1">
                  <?php
                  $images = $photo->getPhotoByPost($row['id']);
                  $photoUrl = [];
                  foreach ($images as $img) {
                    $photoUrl[] = $img['image_url'];
                  }
                  ?>
                  <div class="col">
                    <img src="./Public/upload/<?= $photoUrl[0] ?>" alt="post image" class="img-fluid mb-1 object-fit-cover" style="height: 50%; border-radius: 15px 0 0 0;" />
                    <img src="./Public/upload/<?= $photoUrl[1] ?>" alt="post image" class="img-fluid w-100 object-fit-cover" style="height: 50%; " />
                  </div>
                  <div class="col">
                    <img src="./Public/upload/<?= $photoUrl[2] ?>" alt="post image" class="img-fluid mb-1 object-fit-cover" style="height: 50%; border-radius: 0 15px 0 0;" />
                    <img src="./Public/upload/<?= $photoUrl[3] ?>" alt="post image" class="img-fluid w-100 object-fit-cover" style="height: 50%;" />
                  </div>
                </div>
              </div>
              <!--avatar-->
              <div class="d-flex align-items-center mt-2 ms-3 mb-3">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>

              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                        <p class="px-3">' . $row['content'] . '</p>
                                    </div>';
              }
              ?>
            </div>
            <!-- likes & comments -->
            <div class="post__comment position-relative pt-0">
              <!-- likes-comment -->
              <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                <!-- like -->
                <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                  <?php
                  $post_id = $row['id'];
                  $response = $like->countPhotoByLike($post_id);
                  if ($response) {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                  } else {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                  }

                  ?>
                </button>
                <!-- comment -->
                <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                  <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                  <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                </div>
              </div>
              <hr class="mt-0 mb-2 mx-3" />
              <!-- comment & like bar -->
              <form method="POST" class="d-flex justify-content-around px-3 pb-2">
                <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <?php
                  $post_id = $row['id'];
                  $user_id = $_SESSION['user']['id'];
                  $Checklike = $like->checklike($user_id, $post_id);
                  if (!$Checklike) {
                    echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                  } else {
                    echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                  }
                  ?>
                  <p class="m-0">Yêu thích</p>
                </button>
                <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                  <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                  <p class="m-0">Bình luận</p>
                </div>
                <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                  <p class="m-0">Chia sẻ</p>
                </button>
              </form>
              <!-- comment model -->
              <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $post_data['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                </div>
                <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $post_data['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                  <div class="d-flex" style="margin-top: 18px;">
                    <?php
                    if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php } else { ?>
                      <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php }
                    ?>
                    <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                      <input type="hidden" name="parentId" value="0">
                      <input type="hidden" name="postId" value="<?= $post_data['id'] ?>">
                      <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                      <button type="submit" class="border-0 bg-transparent ms-1">
                        <i class="fa-solid fa-paper-plane text-primary"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- end -->
          </div>
        <?php break;
        default: ?>
          <!-- post-layout-4 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
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
              <!-- edit -->
              <?php
              if ($user_id === $post_data['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $post_data['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="border rounded-4 m-4">
              <!--image-->
              <div class="container m-0 g-0 position-relative" style="width: 100%;">
                <div class="row g-1">
                  <?php
                  $images = $photo->getPhotoByPost($row['id']);
                  $imageUrls = [];
                  foreach ($images as $img) {
                    $imageUrls[] = $img['image_url'];
                  }
                  // Biến đếm số lượng ảnh đã hiển thị
                  $displayedCount = 0;
                  $i = 0;
                  $j = 0;
                  while ($i < 2) {
                    echo '<div class="col">';
                    echo '<img src="./Public/upload/' . $imageUrls[$j] . '" alt="post image" class="img-fluid mb-1" style="height: 50%;" />';
                    $j++;
                    echo '<img src="./Public/upload/' . $imageUrls[$j] . '" alt="post image" class="img-fluid" style="height: 50%;" />';
                    echo '</div>';
                    $j++;
                    $i++;
                  }
                  ?>
                </div>
                <div class="h-50 w-50 position-absolute bottom-0 end-0 d-flex align-items-center">
                  <div class="overlay">
                  </div>
                  <p class="w-100 text-white text-center text-center fs-3 z-3">+ <?= $check_photo - 3 ?></p>
                </div>
              </div>
              <!--avatar-->
              <div class="d-flex align-items-center mt-2 ms-3 mb-3">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>

              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                        <p class="px-3">' . $row['content'] . '</p>
                                    </div>';
              }
              ?>



            </div>

            <!-- likes & comments -->
            <div class="post__comment position-relative pt-0">
              <!-- likes-comment -->
              <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                <!-- like -->
                <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                  <?php
                  $post_id = $row['id'];
                  $response = $like->countPhotoByLike($post_id);
                  if ($response) {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                  } else {
                    echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                  }

                  ?>
                </button>
                <!-- comment -->
                <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                  <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                  <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                </div>
              </div>
              <hr class="mt-0 mb-2 mx-3" />
              <!-- comment & like bar -->
              <form method="POST" class="d-flex justify-content-around px-3 pb-2">
                <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <?php
                  $post_id = $row['id'];
                  $user_id = $_SESSION['user']['id'];
                  $Checklike = $like->checklike($user_id, $post_id);
                  if (!$Checklike) {
                    echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                  } else {
                    echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                  }
                  ?>
                  <p class="m-0">Yêu thích</p>
                </button>
                <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                  <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                  <p class="m-0">Bình luận</p>
                </div>
                <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                  <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                  <p class="m-0">Chia sẻ</p>
                </button>
              </form>
              <!-- comment model -->
              <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $post_data['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                </div>
                <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $post_data['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                  <div class="d-flex" style="margin-top: 18px;">
                    <?php
                    if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php } else { ?>
                      <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                    <?php }
                    ?>
                    <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                      <input type="hidden" name="parentId" value="0">
                      <input type="hidden" name="postId" value="<?= $post_data['id'] ?>">
                      <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                      <button type="submit" class="border-0 bg-transparent ms-1">
                        <i class="fa-solid fa-paper-plane text-primary"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
      }
    } else {
      $check_photo = $photo->countPhotoByPost($post_id);
      switch ($check_photo) {
        case 0: ?>
          <!-- post-layout-0 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex justify-content-between w-100">
                <!-- avatar -->
                <div class="d-flex">
                  <?php
                  if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                    <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <?php } else { ?>
                    <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <?php }
                  ?>
                  <div>
                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                    <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                  </div>
                </div>
                <!-- edit -->
                <?php
                if ($user_id === $row['user_id']) { ?>
                  <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                  <!-- edit menu -->
                  <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                    <li class="d-flex align-items-center">
                      <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#" data-bs-toggle="modal" data-bs-target="#updatePostModal">
                        Chỉnh sửa bài viết</a>
                    </li>
                    <li class="d-flex align-items-center btn-delete-post">
                      <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $row['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                        Xóa bài viết
                      </a>
                      <?php
                      if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $delete = $post->deletePost($id);
                        if ($delete) {
                          header('location: ./index.php');
                        }
                      }
                      ?>
                    </li>
                  </ul>
                <?php
                }
                ?>
              </div>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                  <p class="px-3">' . $row['content'] . '</p>
                                </div>';
                echo '<input type="hidden" name="content-post-share" value="' . $row['content'] . '">';
              }
              ?>
              <!-- likes & comments -->
              <div class="post__comment position-relative pt-0">
                <!-- likes-comment -->
                <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                  <!-- like -->
                  <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                    <?php
                    $post_id = $row['id'];
                    $response = $like->countPhotoByLike($post_id);
                    if ($response) {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                    } else {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                    }
                    ?>
                  </button>
                  <!-- comment -->
                  <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                    <p class="m-0"><?= $comment->countCommentByPost($row['id']) ?> bình luận</p>
                    <p class="m-0"><?= $share->countShareByPost($row['id']) ?> chia sẻ</p>
                  </div>
                </div>
                <hr class="mt-0 mb-2 mx-3" />
                <!-- comment & like bar -->
                <form action="" method="post">
                  <div class="d-flex justify-content-around px-3 pb-2">
                    <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <?php
                      $post_id = $row['id'];
                      $Checklike = $like->checklike($user_id, $post_id);
                      if (!$Checklike) {
                        echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                      } else {
                        echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                      }
                      ?>
                      <p class="m-0">Yêu thích</p>
                    </button>
                    <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                      <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                      <p class="m-0">Bình luận</p>
                    </div>
                    <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                      <p class="m-0">Chia sẻ</p>
                    </button>
                  </div>
                </form>
                <!-- comment model -->
                <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                  <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                  <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $row['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                  </div>
                  <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $row['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                    <div class="d-flex" style="margin-top: 18px;">
                      <?php
                      if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php }
                      ?>
                      <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                        <input type="hidden" name="parentId" value="0">
                        <input type="hidden" name="postId" value="<?= $row['id'] ?>">
                        <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                        <button type="submit" class="border-0 bg-transparent ms-1">
                          <i class="fa-solid fa-paper-plane text-primary"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        case 1: ?>
          <!-- post-layout-1 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- edit -->
              <?php
              if ($user_id === $row['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $row['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                      <p class="px-3">' . $row['content'] . '</p>
                                  </div>';
                echo '<input type="hidden" name="content-post-share" value="' . $row['content'] . '">';
              }
              ?>
              <div id="post-images">
                <?php
                $image = $photo->getPhotoByPost($row['id']);
                echo '<img src="./Public/upload/' . $image[0]['image_url'] . '" alt="post image" class="img-fluid" name="postImageShare" style="width: 100%;" />';                        ?>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative pt-0">
                <!-- likes-comment -->
                <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                  <!-- like -->
                  <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                    <?php
                    $post_id = $row['id'];
                    $response = $like->countPhotoByLike($post_id);
                    if ($response) {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                    } else {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                    }
                    ?>
                  </button>
                  <!-- comment -->
                  <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                    <p class="m-0"><?= $comment->countCommentByPost($row['id']) ?> bình luận</p>
                    <p class="m-0"><?= $share->countShareByPost($row['id']) ?> chia sẻ</p>
                  </div>
                </div>
                <hr class="mt-0 mb-2 mx-3" />
                <!-- comment & like bar -->
                <form method="POST">
                  <div class="d-flex justify-content-around px-3 pb-2">
                    <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <?php
                      $post_id = $row['id'];
                      $user_id = $_SESSION['user']['id'];
                      $Checklike = $like->checklike($user_id, $post_id);
                      if (!$Checklike) {
                        echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                      } else {
                        echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                      }
                      ?>
                      <p class="m-0">Yêu thích</p>
                    </button>
                    <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                      <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                      <p class="m-0">Bình luận</p>
                    </div>
                    <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                      <input type="hidden" name="post_id" value="<?php $row['id']; ?>"> <!-- ID của bài viết -->
                      <p class="m-0">Chia sẻ</p>
                    </button>
                  </div>
                </form>
                <!-- comment model -->
                <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                  <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                  <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $row['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                  </div>
                  <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $row['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                    <div class="d-flex" style="margin-top: 18px;">
                      <?php
                      if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php }
                      ?>
                      <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                        <input type="hidden" name="parentId" value="0">
                        <input type="hidden" name="postId" value="<?= $row['id'] ?>">
                        <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                        <button type="submit" class="border-0 bg-transparent ms-1">
                          <i class="fa-solid fa-paper-plane text-primary"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        case 2: ?>
          <!-- post-layout-2 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- edit -->
              <?php
              if ($user_id === $row['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $row['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                  <p class="px-3">' . $row['content'] . '</p>
                                </div>';
                echo '<input type="hidden" name="content-post-share" value="' . $row['content'] . '">';
              }
              ?>
              <div class="container m-0 g-0">
                <div class="row g-1" id="post-images">
                  <?php
                  $image = $photo->getPhotoByPost($row['id']);
                  foreach ($image as $img) {
                    echo '<div class="col">
                                      <img src="./Public/upload/' . $img['image_url'] . '" alt="post image" class="img-fluid" style="width: 100%;  height: 550px;" />
                                      </div>';
                  }
                  ?>
                </div>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative pt-0">
                <!-- likes-comment -->
                <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                  <!-- like -->
                  <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                    <?php
                    $post_id = $row['id'];
                    $response = $like->countPhotoByLike($post_id);
                    if ($response) {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                    } else {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                    }

                    ?>
                  </button>
                  <!-- comment -->
                  <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                    <p class="m-0"><?= $comment->countCommentByPost($row['id']) ?> bình luận</p>
                    <p class="m-0"><?= $share->countShareByPost($row['id']) ?> chia sẻ</p>
                  </div>
                </div>
                <hr class="mt-0 mb-2 mx-3" />
                <!-- comment & like bar -->
                <form action="" method="post">
                  <div class="d-flex justify-content-around px-3 pb-2">
                    <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <?php
                      $post_id = $row['id'];
                      $Checklike = $like->checklike($user_id, $post_id);
                      if (!$Checklike) {
                        echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                      } else {
                        echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                      }
                      ?>
                      <p class="m-0">Yêu thích</p>
                    </button>
                    <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                      <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                      <p class="m-0">Bình luận</p>
                    </div>
                    <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                      <p class="m-0">Chia sẻ</p>
                    </button>
                  </div>
                </form>
                <!-- comment model -->
                <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                  <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                  <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $row['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                  </div>
                  <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $row['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                    <div class="d-flex" style="margin-top: 18px;">
                      <?php
                      if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php }
                      ?>
                      <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                        <input type="hidden" name="parentId" value="0">
                        <input type="hidden" name="postId" value="<?= $row['id'] ?>">
                        <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                        <button type="submit" class="border-0 bg-transparent ms-1">
                          <i class="fa-solid fa-paper-plane text-primary"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        case 3: ?>
          <!-- post-layout-3 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- edit -->
              <?php
              if ($user_id === $row['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $row['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                  <p class="px-3">' . $row['content'] . '</p>
                                </div>';
                echo '<input type="hidden" name="content-post-share" value="' . $row['content'] . '">';
              }
              ?>
              <div class="container m-0 g-0" style="width: 100%;">
                <div class="row g-1">
                  <?php
                  $image = $photo->getPhotoByPost($row['id']);
                  $imageUrls = [];
                  foreach ($image as $img) {
                    $imageUrls[] = $img['image_url'];
                  }
                  ?>
                  <div class="col-8">
                    <img src="./Public/upload/<?= $imageUrls[0] ?>" alt="post image" class="img-fluid" style="width: 100%; height: 604px" />
                  </div>
                  <div class="col-4">
                    <?php
                    for ($i = 1; $i <= 2; $i++) {
                      echo '<img src="./Public/upload/' . $imageUrls[$i] . '" alt="post image" class="img-fluid mb-1" style="height: 300px;" />';
                    }
                    ?>
                  </div>
                </div>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative pt-0">
                <!-- likes-comment -->
                <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                  <!-- like -->
                  <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                    <?php
                    $post_id = $row['id'];
                    $response = $like->countPhotoByLike($post_id);
                    if ($response) {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                    } else {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                    }

                    ?>
                  </button>

                  <!-- comment -->
                  <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                    <p class="m-0"><?= $comment->countCommentByPost($row['id']) ?> bình luận</p>
                    <p class="m-0"><?= $share->countShareByPost($row['id']) ?> chia sẻ</p>
                  </div>
                </div>
                <hr class="mt-0 mb-2 mx-3" />
                <!-- comment & like bar -->
                <form action="" method="post">
                  <div class="d-flex justify-content-around px-3 pb-2">
                    <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <?php
                      $post_id = $row['id'];
                      $Checklike = $like->checklike($user_id, $post_id);
                      if (!$Checklike) {
                        echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                      } else {
                        echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                      }
                      ?>
                      <p class="m-0">Yêu thích</p>
                    </button>
                    <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                      <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                      <p class="m-0">Bình luận</p>
                    </div>
                    <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                      <p class="m-0">Chia sẻ</p>
                    </button>
                  </div>
                </form>
                <!-- comment model -->
                <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                  <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                  <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $row['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                  </div>
                  <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $row['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                    <div class="d-flex" style="margin-top: 18px;">
                      <?php
                      if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php }
                      ?>
                      <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                        <input type="hidden" name="parentId" value="0">
                        <input type="hidden" name="postId" value="<?= $row['id'] ?>">
                        <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                        <button type="submit" class="border-0 bg-transparent ms-1">
                          <i class="fa-solid fa-paper-plane text-primary"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        case 4: ?>
          <!-- post-layout-4 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- edit -->
              <?php
              if ($user_id === $row['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $row['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                  <p class="px-3">' . $row['content'] . '</p>
                                </div>';
                echo '<input type="hidden" name="content-post-share" value="' . $row['content'] . '">';
              }
              ?>
              <div class="container m-0 g-0 mb-1" style="width: 100%;">
                <div class="row g-1">
                  <?php
                  $images = $photo->getPhotoByPost($row['id']);
                  $photoUrl = [];
                  foreach ($images as $img) {
                    $photoUrl[] = $img['image_url'];
                  }
                  ?>
                  <div class="col">
                    <img src="./Public/upload/<?= $photoUrl[0] ?>" alt="post image" class="img-fluid mb-1 object-fit-cover" style="height: 50%;" />
                    <img src="./Public/upload/<?= $photoUrl[1] ?>" alt="post image" class="img-fluid w-100 object-fit-cover" style="height: 50%;" />
                  </div>
                  <div class="col">
                    <img src="./Public/upload/<?= $photoUrl[2] ?>" alt="post image" class="img-fluid mb-1 object-fit-cover" style="height: 50%;" />
                    <img src="./Public/upload/<?= $photoUrl[3] ?>" alt="post image" class="img-fluid w-100 object-fit-cover" style="height: 50%;" />
                  </div>
                </div>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative pt-0">
                <!-- likes-comment -->
                <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                  <!-- like -->
                  <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                    <?php
                    $post_id = $row['id'];
                    $response = $like->countPhotoByLike($post_id);
                    if ($response) {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                    } else {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                    }

                    ?>
                  </button>
                  <!-- comment -->
                  <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                    <p class="m-0"><?= $comment->countCommentByPost($row['id']) ?> bình luận</p>
                    <p class="m-0"><?= $share->countShareByPost($row['id']) ?> chia sẻ</p>
                  </div>
                </div>
                <hr class="mt-0 mb-2 mx-3" />
                <!-- comment & like bar -->
                <form action="" method="post">
                  <div class="d-flex justify-content-around px-3 pb-2">
                    <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <?php
                      $post_id = $row['id'];
                      $Checklike = $like->checklike($user_id, $post_id);
                      if (!$Checklike) {
                        echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                      } else {
                        echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                      }
                      ?>
                      <p class="m-0">Yêu thích</p>
                    </button>
                    <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                      <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                      <p class="m-0">Bình luận</p>
                    </div>
                    <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                      <p class="m-0">Chia sẻ</p>
                    </button>
                  </div>
                </form>
                <!-- comment model -->
                <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                  <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                  <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $row['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                  </div>
                  <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $row['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                    <div class="d-flex" style="margin-top: 18px;">
                      <?php
                      if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php }
                      ?>
                      <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                        <input type="hidden" name="parentId" value="0">
                        <input type="hidden" name="postId" value="<?= $row['id'] ?>">
                        <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                        <button type="submit" class="border-0 bg-transparent ms-1">
                          <i class="fa-solid fa-paper-plane text-primary"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
        <?php break;
        default: ?>
          <!-- post-layout-5 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between p-3 pb-0">
              <!-- avatar -->
              <div class="d-flex align-items-center">
                <?php
                if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <?php }
                ?>
                <div>
                  <p class="m-0 fw-bold"><?= $user->getFullnameByUser($row['user_id']) ?></p>
                  <span class="text-muted fs-7"><?= calculateTimeAgo($row['created_at']) ?></span>
                </div>
              </div>
              <!-- edit -->
              <?php
              if ($user_id === $row['user_id']) { ?>
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <li class="d-flex align-items-center">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
                      Chỉnh sửa bài viết</a>
                  </li>
                  <li class="d-flex align-items-center btn-delete-post">
                    <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=home&id=<?php echo $row['id'] ?>" onclick="confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                      Xóa bài viết</a>
                  </li>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $post->deletePost($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                </ul>
              <?php }
              ?>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <?php
              if ($row['content'] !== null || $row['content'] !== '') {
                echo '<div class="post-content">
                                  <p class="px-3">' . $row['content'] . '</p>
                                </div>';
                echo '<input type="hidden" name="content-post-share" value="' . $row['content'] . '">';
              }
              ?>
              <div class="container m-0 g-0 position-relative" style="width: 100%;">
                <div class="row g-1">
                  <?php
                  $images = $photo->getPhotoByPost($row['id']);
                  $imageUrls = [];
                  foreach ($images as $img) {
                    $imageUrls[] = $img['image_url'];
                  }
                  // Biến đếm số lượng ảnh đã hiển thị
                  $displayedCount = 0;
                  $i = 0;
                  $j = 0;
                  while ($i < 2) {
                    echo '<div class="col">';
                    echo '<img src="./Public/upload/' . $imageUrls[$j] . '" alt="post image" class="img-fluid mb-1" style="height: 50%;" />';
                    $j++;
                    echo '<img src="./Public/upload/' . $imageUrls[$j] . '" alt="post image" class="img-fluid" style="height: 50%;" />';
                    echo '</div>';
                    $j++;
                    $i++;
                  }
                  ?>
                </div>
                <div class="h-50 w-50 position-absolute bottom-0 end-0 d-flex align-items-center">
                  <div class="overlay">
                  </div>
                  <p class="w-100 text-white text-center text-center fs-3 z-3">+ <?= $check_photo - 3 ?></p>
                </div>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative pt-0">
                <!-- likes-comment -->
                <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                  <!-- like -->
                  <button class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>">
                    <?php
                    $post_id = $row['id'];
                    $response = $like->countPhotoByLike($post_id);
                    if ($response) {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">' . $response . ' lượt thích</p>';
                    } else {
                      echo '<p class="m-0 text-muted fs-6 fw-normal like-count" style="cursor: pointer;">0 lượt thích</p>';
                    }

                    ?>
                  </button>
                  <!-- comment -->
                  <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                    <p class="m-0"><?= $comment->countCommentByPost($row['id']) ?> bình luận</p>
                    <p class="m-0"><?= $share->countShareByPost($row['id']) ?> chia sẻ</p>
                  </div>
                </div>
                <hr class="mt-0 mb-2 mx-3" />
                <!-- comment & like bar -->
                <form action="" method="post">
                  <div class="d-flex justify-content-around px-3 pb-2">
                    <button type="button" name="post_id" value="<?php echo $row['id'] ?>" class="btn-like-post dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <?php
                      $post_id = $row['id'];
                      $Checklike = $like->checklike($user_id, $post_id);
                      if (!$Checklike) {
                        echo '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
                      } else {
                        echo '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
                      }
                      ?>
                      <p class="m-0">Yêu thích</p>
                    </button>
                    <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2 toggle-comment">
                      <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                      <p class="m-0">Bình luận</p>
                    </div>
                    <button type="submit" name="sharePost" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                      <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                      <p class="m-0">Chia sẻ</p>
                    </button>
                  </div>
                </form>
                <!-- comment model -->
                <div class="comment-modal flex-column position-relative w-100 h-100" style="max-height: 600px;">
                  <hr class="mt-0 mb-2 mx-3" style="order: 1;" />
                  <div class="comment-list mt-3 p-3 h-100 overflow-y-auto srollbar" data-post-id="<?= $row['id'] ?>" style="height: 400px;max-height: 500px; padding-bottom: 115px !important; order: 2;">
                  </div>
                  <div class="position-absolute bottom-0 bg-white w-100 px-3" data-post-id="<?= $row['id'] ?>" style="z-index: 10; height: 110px; box-shadow: 0px -6px 4px -6px rgba(0, 0, 0, 0.2); order: 3;">
                    <div class="d-flex" style="margin-top: 18px;">
                      <?php
                      if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;" />
                      <?php }
                      ?>
                      <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
                        <input type="hidden" name="parentId" value="0">
                        <input type="hidden" name="postId" value="<?= $row['id'] ?>">
                        <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
                        <button type="submit" class="border-0 bg-transparent ms-1">
                          <i class="fa-solid fa-paper-plane text-primary"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end -->
          </div>
    <?php break;
      }
    } ?>
  </div>
</main>
<script>
  //toggle comment and reply form
  $(document).ready(function() {
    // Xử lý đóng mở comment
    $('.toggle-comment').click(function() {
      var index = $('.toggle-comment').index(this);
      if ($('.comment-modal').eq(index).css('display') === 'flex') {
        $('.comment-modal').eq(index).css('display', 'none');
      } else {
        $('.comment-modal').css('display', 'none');
        $('.comment-modal').eq(index).css('display', 'flex');
      }
    });
    // Xử lý đóng mở form reply
    $(document).on("click", ".btn-reply", function() {
      var index = $(".btn-reply").index(this);
      if ($(".reply-form").eq(index).css("display") === "block") {
        $(".reply-form").eq(index).css("display", "none");
      } else {
        $(".reply-form").css("display", "none");
        $(".reply-form").eq(index).css("display", "block");
      }
    });
    //Xử lý ajax comment
    $(".comment-list").each(function() {
      var $commentList = $(this);
      var postId = $commentList.data("post-id");

      loadComments(postId, $commentList);
    });

    $(document).on('submit', '.cmt-form', function(event) {
      event.preventDefault();

      var $form = $(this);
      var $commentList = $form.closest('.comment-modal').find('.comment-list');
      var formData = $form.serialize();

      $.ajax({
        type: 'POST',
        url: './ajax.php',
        data: formData,
        success: function(data) {
          // Trích xuất post_id từ form hoặc từ comment-list chứa form
          var postId = $commentList.data('post-id');

          loadComments(postId, $commentList);
        },
        error: function() {
          console.log("Lỗi thêm dữ liệu");
        }
      });
    });

    function loadComments(postId, $commentList) {
      $.ajax({
        url: "./ajax.php",
        type: "GET",
        data: {
          post_id: postId
        },
        success: function(data) {
          $commentList.html(data);
        },
        error: function() {
          console.log("Error loading comments");
        }
      });
    };

    let userId = <?php echo $user_id ?>; // Lấy user_id từ PHP

    $(document).on("click", ".btn-like-post", function() {
      let postId = $(this).val();
      let isLiked = localStorage.getItem('liked_' + postId);

      if (!isLiked) {
        let like = '<i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>';
        $(this).find('.fa-regular.fa-heart').replaceWith(like);

        // Gửi yêu cầu AJAX khi thích
        $.ajax({
          type: 'POST',
          url: './ajax.php',
          data: {
            user_id: userId,
            post_id: postId,
            action: "like",
          },
          success: function(response) {
            console.log('Yêu cầu AJAX thành công');
            console.log(response);

            $('.btn-like-button[value="' + postId + '"]').html(response);
            $('.btn-like-post[value="' + postId + '"]').addClass('liked');
            localStorage.setItem('liked_' + postId, true); // Lưu trạng thái đã like vào localStorage
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi gửi yêu cầu AJAX: ' + error);
          }
        });
      } else {
        let unlike = '<i class="fa-regular fa-heart me-3" style="color: #000000;"></i>';
        $(this).find('.fa-solid.fa-heart').replaceWith(unlike);

        // Gửi yêu cầu AJAX khi hủy thích
        $.ajax({
          type: 'POST',
          url: './ajax.php',
          data: {
            user_id: userId,
            post_id: postId,
            action: "unlike",
          },
          success: function(response) {
            console.log('Yêu cầu AJAX thành công');
            console.log(response);
            $('.btn-like-button[value="' + postId + '"]').html(response);
            $('.btn-like-post[value="' + postId + '"]').removeClass('liked');
            localStorage.removeItem('liked_' + postId); // Xóa trạng thái đã like khỏi localStorage
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi gửi yêu cầu AJAX: ' + error);
          }
        });
      }
    });
  });
</script>