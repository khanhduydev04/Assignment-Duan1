<?php
$post = new Post();
$photo = new Photo();
$user = new User();
$comment = new Comment();
$like = new Likes();
$share = new Share();
$story = new Stories();

$uploadDir = './Public/upload/';
$allowedExtensions = ['png', 'jpg', 'jpeg'];
$errors = [];

$user_id = $_SESSION['user']['id']; //id của user hiện tại

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

//Xử lý sửa đăng bài viết
if (isset($_POST['update-post']) && $_POST['update-post']) {
  $content = $_POST['content-post-update'];
  $post_id = $_POST['post_id']; // Assuming you have a hidden input field containing the post ID
  $user_id = $_SESSION['user']['id'];

  $uploadedImages = array(); // Lưu ảnh đã xử lý

  if (!empty($_FILES['photoUpdate']['name'][0])) {
    $uploadDir = './Public/upload/'; // Đường dẫn thư mục lưu trữ ảnh

    foreach ($_FILES['photoUpdate']['tmp_name'] as $key => $tmp_name) {
      $file_name = $_FILES['photoUpdate']['name'][$key];
      $file_tmp = $_FILES['photoUpdate']['tmp_name'][$key];
      $file_size = $_FILES['photoUpdate']['size'][$key];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif'); // Các phần mở rộng được phép

      if (in_array($file_ext, $allowedExtensions)) {
        $targetFilePath = $uploadDir . $file_name;

        if (move_uploaded_file($file_tmp, $targetFilePath)) {
          $uploadedImages[] = basename($file_name); // Lưu tên file ảnh đã tải lên
        } else {
          echo "Lỗi khi tải lên file $file_name.";
        }
      } else {
        echo "Chỉ chấp nhận file có định dạng JPG, JPEG, PNG, GIF.";
      }
    }
  }

  if (empty($errors)) {
    $result = $post->updatePost($post_id, $content);
    if ($result) {
      // Xóa tất cả ảnh cũ liên quan đến bài viết
      $photo->deletePhoto($post_id);

      // Thêm ảnh mới
      if (!empty($uploadedImages)) {
        $status = 'post';
        foreach ($uploadedImages as $path) {
          $photo->insertPhoto($path, $status, $post_id);
        }
      }

      header("Location: index.php");
      exit();
    } else {
      echo "Cập nhật bài viết thất bại.";
    }
  }
}

//Xử lý đăng bài post
if (isset($_POST['post']) && $_POST['post']) {
  $content = $_POST['content-post'];
  $user_id = $_SESSION['user']['id'];

  $uploadedImages = array(); //Lưu ảnh đã xử lý

  if (!empty($_FILES['photo']['name'][0]) && isset($_FILES['photo']['name'][0])) {
    // Xử lý nhiều file ảnh
    foreach ($_FILES['photo']['tmp_name'] as $key => $tmp_name) {
      $file_name = $_FILES['photo']['name'][$key];
      $file_tmp = $_FILES['photo']['tmp_name'][$key];
      $file_size = $_FILES['photo']['size'][$key];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      if (in_array($file_ext, $allowedExtensions)) {
        $targetFilePath = $uploadDir . $file_name;
        if (move_uploaded_file($file_tmp, $targetFilePath)) {
          $uploadedImages[] = basename($file_name);
        } else {
          echo $errors[] = "Upload album file thất bại $file_name";
        }
      } else {
        echo $errors[] = "$file_name album file đã chọn không đúng yêu cầu.";
      }
    }
  }

  if (empty($errors)) {
    $result = $post->insertPost($content, $user_id);
    if ($result[0]) {
      if (!empty($uploadedImages)) {
        $post_id = $result[1];
        $status = 'post';
        foreach ($uploadedImages as $path) {
          $photo->insertPhoto($path, $status, $post_id);
        }
      }
      header("Location: index.php");
      exit();
    }
  }
}
?>
<main class="bg-gray postion-relative">
  <!-- ================= Main ================= -->
  <div class="container-fluid">
    <div class="row justify-content-evenly">
      <!-- ================= Sidebar ================= -->
      <div class="col-12 col-lg-3">
        <div class="d-none d-xxl-block h-100 fixed-top overflow-hidden" style="max-width: 360px; width:100%; z-index: 4;">
          <ul class="navber-nav mt-4 ms-3 d-flex flex-column pb-5 mb-5" style="padding-top: 56px;">
            <!--Top-->
            <!--Avatar-->
            <li class="dropdown-item p-1 rounded">
              <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                <div class="p-2">
                  <?php
                  if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                    <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                  <?php } else { ?>
                    <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                  <?php }
                  ?>
                </div>
                <div class="">
                  <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                </div>
              </a>
            </li>
            <!--Friends-->
            <li class="dropdown-item p-1 rounded">
              <a href="index.php?ctrl=friends" class="text-decoration-none text-dark d-flex align-items-center">
                <div class="p-2">
                  <i data-visualcompletion="css-img" class="" style="background-image:url('https://static.xx.fbcdn.net/rsrc.php/v3/yz/r/4GR4KRf3hN2.png');background-position:0 -296px;background-size:auto;width:36px;height:36px;background-repeat:no-repeat;display:inline-block"></i>
                </div>
                <div class="">
                  <p class="m-0">Bạn bè</p>
                </div>
              </a>
            </li>
            <!--See more-->
            <li class="p-1" type="button">
              <div class="accordion" id="accordionExample">
                <div>
                  <div class="accordion-header">
                    <div class="d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="flase" aria-controls="collapseOne">
                      <div class="p-2">
                        <i class="fas fa-chevron-down rounded-circle p-2" style="background-color: #d5d5d5 !important;"></i>
                      </div>
                      <div>
                        <p class="m-0">Xem thêm</p>
                      </div>
                    </div>
                  </div>
                  <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>Xin chào bạn!</strong> tiện ích đang đợi cập nhật thêm. Cảm ơn bạn đã quan tâm!
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- ================= Timeline ================= -->
      <div class="col-12 col-lg-6 ">
        <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 56px; max-width: 680px">
          <!-- stories -->
          <div class="stories-container">
            <div class="content">
              <div class="previous-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </div>

              <div class="stories">
                <a href="index.php?ctrl=stories" class="story">
                  <?php
                  if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                    <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avatar " class="position-relative" />
                  <?php } else { ?>
                    <img src="./Public/images/avt_default.png" alt="avatar" class="position-relative" />
                  <?php }
                  ?>
                  <img src="./Public/images/avt.jpg" alt="" class="position-relative">
                  <div class="author_add">Thêm tin</div>
                  <h3 class=" author_plus">
                    <i class="fa-solid fa-plus hdh"></i>
                  </h3>
                </a>

                <?php
                $user_id = $_SESSION['user']['id']; //id của user hiện tại     
                $getStory = $story->getStoriesWithUsers($user_id);
                foreach ($getStory as $row) {
                ?>

                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $story->hideStory($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>

                  <div class="story">
                    <div class="story" onclick="showFullView(event)">
                      <img src="./Public/upload/<?php echo $row['image_url']; ?>" alt="">
                      <div class="author"><?php echo $row['last_name'] . ' ' . $row['first_name']; ?></div>
                      <?php
                      if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2 avatar_story" style="width: 38px; height: 38px; object-fit: cover;">
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2 avatar_story" style="width: 38px; height: 38px; object-fit: cover;">
                      <?php }
                      ?>

                    </div>
                    <?php
                    $user_id_story = $story->getUserIdByStory($row['id']);
                    if ($user_id === $user_id_story) {
                    ?>
                      <a class="delete_id_story" href="index.php?ctrl=home&id=<?php echo $row['id'] ?>">
                        <i class="fa-solid fa-delete-left" style="color: #ffffff;"></i>
                      </a>
                    <?php } ?>
                  </div>

                <?php
                }
                ?>

                <?php
                $user_id = $_SESSION['user']['id']; //id của user hiện tại     
                $getStory = $story->getStoriesNotWithUsers($user_id);
                foreach ($getStory as $row) {
                ?>
                  <?php
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $delete = $story->hideStory($id);
                    if ($delete) {
                      header('location: ./index.php');
                    }
                  }
                  ?>
                  <div class="story">
                    <div class="story" onclick="showFullView(event)">
                      <img src="./Public/upload/<?php echo $row['image_url']; ?>" alt="">
                      <div class="author"><?php echo $row['last_name'] . ' ' . $row['first_name']; ?></div>
                      <?php
                      if (($photo->getNewAvatarByUser($row['user_id']) != null)) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['user_id']) ?>" alt="avatar" class="rounded-circle me-2 avatar_story" style="width: 38px; height: 38px; object-fit: cover;">
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2 avatar_story" style="width: 38px; height: 38px; object-fit: cover;">
                      <?php }
                      ?>

                    </div>
                    <?php
                    $user_id_story = $story->getUserIdByStory($row['id']);
                    if ($user_id === $user_id_story) {
                    ?>
                      <a class="delete_id_story" href="index.php?ctrl=home&id=<?php echo $row['id'] ?>">
                        <i class="fa-solid fa-delete-left" style="color: #ffffff;"></i>
                      </a>
                    <?php } ?>
                  </div>

                <?php
                }
                ?>


              </div>

              <div class="next-btn active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </div>
            </div>
          </div>

          <div class="stories-full-view">
            <div class="close-btn">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>

            <div class="content">
              <div class="previous-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </div>



              <div class="story d-flex justify-content-center">
                <img src="" alt="" />
                <div class="author"></div>
                <img class="avatar_story_view" src="" style="width: 38px; height: 38px; border-radius: 50%;">
              </div>


              <div class="next-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </div>
            </div>
          </div>

          <!-- create post -->
          <div class="bg-white p-3 mt-3 rounded border shadow-sm">
            <!-- avatar -->
            <div class="d-flex" type="button">
              <div class="p-1">
                <?php
                if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                  <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                <?php } else { ?>
                  <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                <?php }
                ?>
              </div>
              <button type="button" class="ps-3 rounded-pill border-0 bg-gray pointer w-100 text-start" data-bs-toggle="modal" data-bs-target="#createPostModal">
                Bạn đang nghĩ gì?
              </button>
            </div>
            <!-- create modal -->
            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true" data-bs-backdrop="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class=" modal-content">
                  <form action="" method="post" id="form-post" enctype="multipart/form-data">
                    <!-- head -->
                    <div class="modal-header flex-column border-0 pb-1 p-0">
                      <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                        <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                          Tạo bài viết
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <!-- name -->
                      <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                        <div class="p-2">
                          <?php
                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                          <?php } else { ?>
                            <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                          <?php }
                          ?>
                        </div>
                        <div>
                          <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                        </div>
                      </div>
                    </div>
                    <!-- body -->
                    <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                      <div class="my-1 p-1">
                        <div class="d-flex flex-column">
                          <!-- textarea -->
                          <div>
                            <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post" id="content-post" style="box-shadow: none;" oninput="toggleSubmitButton()" placeholder="Bạn đang nghĩ gì thế ?"></textarea>
                          </div>
                          <!-- images preview -->
                          <div class="post-preview w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>
                        </div>
                      </div>
                      <!-- end -->
                    </div>
                    <!-- footer -->
                    <div class="modal-footer">
                      <!-- upload image -->
                      <div class="w-100">
                        <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImage">
                          <p class="m-0">Thêm hình ảnh vào bài viết</p>
                          <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                        </label>
                        <input type="file" name="photo[]" id="postImage" multiple hidden onchange="showPreviewPostImage()">
                      </div>
                      <input type="submit" name="post" id="submitPost" class="btn btn-secondary w-100" value="Đăng" disabled>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <hr />
            <!-- actions -->
            <div class="d-flex flex-column flex-lg-row mt-3">
              <!-- a 1 -->
              <div class="dropdown-item rounded d-flex align-items-center justify-content-center" type="button">
                <i class="fas fa-video me-2 text-danger"></i>
                <p class="m-0 text-muted">Live Video</p>
              </div>
              <!-- a 2 -->
              <div class="dropdown-item rounded d-flex align-items-center justify-content-center" type="button">
                <i class="fas fa-photo-video me-2 text-success"></i>
                <p class="m-0 text-muted">Photo/Video</p>
              </div>
              <!-- a 3 -->
              <div class="dropdown-item rounded d-flex align-items-center justify-content-center" type="button">
                <i class="fas fa-smile me-2 text-warning"></i>
                <p class="m-0 text-muted">Feeling/Activity</p>
              </div>
            </div>
          </div>

          <?php
          $all_post = $post->getAllPost($user_id);
          if ($all_post && $all_post !== null) {
            foreach ($all_post as $row) {
              $shareArray = $share->getAllShareId();
              $sharedPostIds = []; // Mảng để lưu trữ các post_id được chia sẻ
              //lặp lấy post_id
              foreach ($shareArray as $sharedPostId) {
                $sharedPostIds[] = $sharedPostId['post_share_id'];
              }
              if (in_array($row['id'], $sharedPostIds)) {
                $post_share_id = $share->getPostShare($row['id']);
                $post_data = $post->getPostById($row['id']);
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
                          <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                          <!-- Modal like-->
                          <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                    Tất cả
                                    <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $userIds = $like->getIdUserByIdLike($row['id']);
                                  foreach ($userIds as $userId) {
                                    $user_id = $userId['user_id'];
                                  ?>
                                    <li class="dropdown-item p-1 rounded">
                                      <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                        <div class="p-2">
                                          <?php
                                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php } else { ?>
                                            <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php }
                                          ?>
                                        </div>
                                        <div class="">
                                          <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                        </div>
                                      </a>
                                    </li>
                                  <?php
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- comment -->
                          <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                            <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                            <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                          </div>
                        </div>
                        <hr class="mt-0 mb-2 mx-3" />
                        <!-- comment & like bar -->
                        <div class="d-flex justify-content-around px-3 pb-2">
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
                          <form method="POST" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                            <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="sharePost" class="d-flex justify-content-center align-items-center">
                              <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                              <p class="m-0">Chia sẻ</p>
                            </button>
                          </form>
                        </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" id="post-images">
                          <?php
                          $image = $photo->getPhotoByPost($row['id']);
                          echo '<img src="./Public/upload/' . $image[0]['image_url'] . '" alt="post image" class="img-fluid " style="width: 100%; border-radius: 15px 15px 0px 0px;"  />';
                          ?>
                        </a>
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
                          <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                          <!-- Modal like-->
                          <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                    Tất cả
                                    <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $userIds = $like->getIdUserByIdLike($row['id']);
                                  foreach ($userIds as $userId) {
                                    $user_id = $userId['user_id'];
                                  ?>
                                    <li class="dropdown-item p-1 rounded">
                                      <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                        <div class="p-2">
                                          <?php
                                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php } else { ?>
                                            <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php }
                                          ?>
                                        </div>
                                        <div class="">
                                          <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                        </div>
                                      </a>
                                    </li>
                                  <?php
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- comment -->
                          <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                            <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                            <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                          </div>
                        </div>
                        <hr class="mt-0 mb-2 mx-3" />
                        <!-- comment & like bar -->
                        <div class="d-flex justify-content-around px-3 pb-2">
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
                          <form method="POST" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                            <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="sharePost" class="d-flex justify-content-center align-items-center">
                              <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                              <p class="m-0">Chia sẻ</p>
                            </button>
                          </form>
                        </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0">
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
                        </a>
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
                          <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                          <!-- Modal like-->
                          <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                    Tất cả
                                    <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $userIds = $like->getIdUserByIdLike($row['id']);
                                  foreach ($userIds as $userId) {
                                    $user_id = $userId['user_id'];
                                  ?>
                                    <li class="dropdown-item p-1 rounded">
                                      <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                        <div class="p-2">
                                          <?php
                                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php } else { ?>
                                            <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php }
                                          ?>
                                        </div>
                                        <div class="">
                                          <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                        </div>
                                      </a>
                                    </li>
                                  <?php
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- comment -->
                          <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                            <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                            <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                          </div>
                        </div>
                        <hr class="mt-0 mb-2 mx-3" />
                        <!-- comment & like bar -->
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
                          <form method="POST" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                            <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="sharePost" class="d-flex justify-content-center align-items-center">
                              <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                              <p class="m-0">Chia sẻ</p>
                            </button>
                          </form>
                        </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0" style="width: 100%;">
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
                        </a>

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
                          <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                          <!-- Modal like-->
                          <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                    Tất cả
                                    <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $userIds = $like->getIdUserByIdLike($row['id']);
                                  foreach ($userIds as $userId) {
                                    $user_id = $userId['user_id'];
                                  ?>
                                    <li class="dropdown-item p-1 rounded">
                                      <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                        <div class="p-2">
                                          <?php
                                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php } else { ?>
                                            <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php }
                                          ?>
                                        </div>
                                        <div class="">
                                          <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                        </div>
                                      </a>
                                    </li>
                                  <?php
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- comment -->
                          <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                            <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                            <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                          </div>
                        </div>
                        <hr class="mt-0 mb-2 mx-3" />
                        <!-- comment & like bar -->
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
                          <form method="POST" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                            <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="sharePost" class="d-flex justify-content-center align-items-center">
                              <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                              <p class="m-0">Chia sẻ</p>
                            </button>
                          </form>
                        </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0 mb-1" style="width: 100%;">
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
                        </a>
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
                          <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                          <!-- Modal like-->
                          <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                    Tất cả
                                    <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $userIds = $like->getIdUserByIdLike($row['id']);
                                  foreach ($userIds as $userId) {
                                    $user_id = $userId['user_id'];
                                  ?>
                                    <li class="dropdown-item p-1 rounded">
                                      <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                        <div class="p-2">
                                          <?php
                                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php } else { ?>
                                            <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php }
                                          ?>
                                        </div>
                                        <div class="">
                                          <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                        </div>
                                      </a>
                                    </li>
                                  <?php
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- comment -->
                          <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                            <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                            <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                          </div>
                        </div>
                        <hr class="mt-0 mb-2 mx-3" />
                        <!-- comment & like bar -->
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
                          <form method="POST" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                            <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="sharePost" class="d-flex justify-content-center align-items-center">
                              <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                              <p class="m-0">Chia sẻ</p>
                            </button>
                          </form>
                        </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0 position-relative" style="width: 100%;">
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
                        </a>
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
                          <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                          <!-- Modal like-->
                          <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                    Tất cả
                                    <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $userIds = $like->getIdUserByIdLike($row['id']);
                                  foreach ($userIds as $userId) {
                                    $user_id = $userId['user_id'];
                                  ?>
                                    <li class="dropdown-item p-1 rounded">
                                      <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                        <div class="p-2">
                                          <?php
                                          if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php } else { ?>
                                            <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                          <?php }
                                          ?>
                                        </div>
                                        <div class="">
                                          <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                        </div>
                                      </a>
                                    </li>
                                  <?php
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- comment -->
                          <div class="d-flex gap-2 fw-normal fs-6 align-items-center" id="headingOne">
                            <p class="m-0"><?= $comment->countCommentByPost($post_data['id']) ?> bình luận</p>
                            <p class="m-0"><?= $share->countShareByPost($post_data['id']) ?> chia sẻ</p>
                          </div>
                        </div>
                        <hr class="mt-0 mb-2 mx-3" />
                        <!-- comment & like bar -->
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
                          <form method="POST" class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted action-post-item p-2">
                            <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="sharePost" class="d-flex justify-content-center align-items-center">
                              <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                              <p class="m-0">Chia sẻ</p>
                            </button>
                          </form>
                        </div>
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
                $check_photo = $photo->countPhotoByPost($row['id']);
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
                                <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#updatePost_<?php echo $row['id']; ?>">
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
                      <!-- update post modal -->
                      <div class="modal fade" id="updatePost_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePost_<?php echo $row['id']; ?>Label" aria-hidden="true" data-bs-backdrop="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class=" modal-content">
                            <form action="" method="post" id="form-post" enctype="multipart/form-data">
                              <!-- head -->
                              <div class="modal-header flex-column border-0 pb-1 p-0">
                                <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                                  <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                                    Chỉnh sửa bài viết
                                  </h5>
                                  <button type="button" class="btn-close toggle-update-post" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- name -->
                                <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                                  <div class="p-2">
                                    <?php
                                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php } else { ?>
                                      <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php }
                                    ?>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                                  </div>
                                </div>
                              </div>
                              <!-- body -->
                              <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                                <div class="my-1 p-1">
                                  <div class="d-flex flex-column">
                                    <!-- textarea -->
                                    <div>
                                      <?php
                                      if ($row['content'] !== null || $row['content'] !== '') {
                                        echo '
                                          <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post-update" id="content-post-update" style="box-shadow: none;" oninput="toggleSubmitButtonUpdate()">' . $row['content'] . '</textarea>
                                          ';
                                      }
                                      ?>
                                    </div>
                                    <input type="hidden" name="post_id" value="<?php echo $row['id'] ?>">
                                    <!-- images preview -->
                                    <div class="post-preview-update w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>
                                    <div class="container position-relative delete-image-update">
                                      <button type="button" class="btn btn-danger btn-sm delete-update-post" name="delete_image">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      <?php
                                      ?>
                                      <div class="row">
                                        <?php
                                        $image = $photo->getPhotoByPost($row['id']);
                                        foreach ($image as $img) {
                                          echo '<div class="col-md-6 mb-3">
                                                      <img src="./Public/upload/' . $img['image_url'] . '" class="img-fluid" style="width: 98%;">
                                                    </div>';
                                        }
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- end -->
                              </div>
                              <!-- footer -->
                              <div class="modal-footer">
                                <!-- upload image -->
                                <div class="w-100">
                                  <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImageUpdate">
                                    <p class="m-0">Thêm hình ảnh vào bài viết</p>
                                    <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                                  </label>
                                  <input type="file" name="photoUpdate[]" id="postImageUpdate" multiple hidden onchange="showPreviewPostImageUpdate()">
                                </div>
                                <input type="submit" name="update-post" id="submitPostUpdate" class="btn btn-secondary w-100" value="Cập nhật" disabled>
                              </div>
                            </form>
                          </div>
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
                            <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                            <!-- Modal like-->
                            <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                      Tất cả
                                      <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    $userIds = $like->getIdUserByIdLike($row['id']);
                                    foreach ($userIds as $userId) {
                                      $user_id = $userId['user_id'];
                                    ?>
                                      <li class="dropdown-item p-1 rounded">
                                        <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                          <div class="p-2">
                                            <?php
                                            if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                              <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php } else { ?>
                                              <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php }
                                            ?>
                                          </div>
                                          <div class="">
                                            <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                          </div>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>


                                  </div>
                                </div>
                              </div>
                            </div>

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

                              <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
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
                                <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#" data-bs-toggle="modal" data-bs-target="#updatePost_<?php echo $row['id']; ?>">
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
                      <!-- update post modal -->
                      <div class="modal fade" id="updatePost_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePostLabel" aria-hidden="true" data-bs-backdrop="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class=" modal-content">
                            <form action="" method="post" id="form-post" enctype="multipart/form-data">
                              <!-- head -->
                              <div class="modal-header flex-column border-0 pb-1 p-0">
                                <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                                  <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                                    Chỉnh sửa bài viết
                                  </h5>
                                  <button type="button" class="btn-close toggle-update-post" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- name -->
                                <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                                  <div class="p-2">
                                    <?php
                                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php } else { ?>
                                      <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php }
                                    ?>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                                  </div>
                                </div>
                              </div>
                              <!-- body -->
                              <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                                <div class="my-1 p-1">
                                  <div class="d-flex flex-column">
                                    <!-- textarea -->
                                    <div>
                                      <?php
                                      if ($row['content'] !== null || $row['content'] !== '') {
                                        echo '
                                          <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post-update" id="content-post-update" style="box-shadow: none;" oninput="toggleSubmitButtonUpdate()">' . $row['content'] . '</textarea>
                                          ';
                                      }
                                      ?>
                                    </div>
                                    <input type="hidden" name="post_id" value="<?php echo $row['id'] ?>">
                                    <!-- images preview -->
                                    <div class="post-preview-update w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>

                                    <div class="container position-relative delete-image-update">
                                      <button type="button" class="btn btn-danger btn-sm delete-update-post" name="delete_image">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      <?php

                                      ?>
                                      <div class="row">
                                        <?php
                                        $image = $photo->getPhotoByPost($row['id']);
                                        foreach ($image as $img) {
                                          echo '<div class="col-md-6 mb-3">
                                                      <img src="./Public/upload/' . $img['image_url'] . '" class="img-fluid" style="width: 98%;">
                                                    </div>';
                                        }
                                        ?>
                                      </div>
                                    </div>


                                  </div>
                                </div>
                                <!-- end -->
                              </div>
                              <!-- footer -->
                              <div class="modal-footer">
                                <!-- upload image -->
                                <div class="w-100">
                                  <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImageUpdate">
                                    <p class="m-0">Thêm hình ảnh vào bài viết</p>
                                    <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                                  </label>
                                  <input type="file" name="photoUpdate[]" id="postImageUpdate" multiple hidden onchange="showPreviewPostImageUpdate()">
                                </div>
                                <input type="submit" name="update-post" id="submitPostUpdate" class="btn btn-secondary w-100" value="Cập nhật" disabled>
                              </div>
                            </form>
                          </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" id="post-images">
                          <?php
                          $image = $photo->getPhotoByPost($row['id']);
                          echo '<img src="./Public/upload/' . $image[0]['image_url'] . '" alt="post image" class="img-fluid" name="postImageShare" style="width: 100%;" />';                        ?>
                        </a>
                        <!-- likes & comments -->
                        <div class="post__comment position-relative pt-0">
                          <!-- likes-comment -->
                          <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                            <!-- like -->
                            <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                            <!-- Modal like-->
                            <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                      Tất cả
                                      <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    $userIds = $like->getIdUserByIdLike($row['id']);
                                    foreach ($userIds as $userId) {
                                      $user_id = $userId['user_id'];
                                    ?>
                                      <li class="dropdown-item p-1 rounded">
                                        <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                          <div class="p-2">
                                            <?php
                                            if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                              <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php } else { ?>
                                              <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php }
                                            ?>
                                          </div>
                                          <div class="">
                                            <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                          </div>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>


                                  </div>
                                </div>
                              </div>
                            </div>

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

                              <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
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
                            <li class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#updatePost_<?php echo $row['id']; ?>">
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

                      <!-- update post modal -->
                      <div class="modal fade" id="updatePost_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePost_<?php echo $row['id']; ?>Label" aria-hidden="true" data-bs-backdrop="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class=" modal-content">
                            <form action="" method="post" id="form-post" enctype="multipart/form-data">
                              <!-- head -->
                              <div class="modal-header flex-column border-0 pb-1 p-0">
                                <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                                  <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                                    Chỉnh sửa bài viết
                                  </h5>
                                  <button type="button" class="btn-close toggle-update-post" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- name -->
                                <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                                  <div class="p-2">
                                    <?php
                                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php } else { ?>
                                      <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php }
                                    ?>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                                  </div>
                                </div>
                              </div>
                              <!-- body -->
                              <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                                <div class="my-1 p-1">
                                  <div class="d-flex flex-column">
                                    <!-- textarea -->
                                    <div>
                                      <?php
                                      if ($row['content'] !== null || $row['content'] !== '') {
                                        echo '
                                          <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post-update" id="content-post-update" style="box-shadow: none;" oninput="toggleSubmitButtonUpdate()">' . $row['content'] . '</textarea>
                                          ';
                                      }
                                      ?>
                                    </div>
                                    <input type="hidden" name="post_id" value="<?php echo $row['id'] ?>">
                                    <!-- images preview -->
                                    <div class="post-preview-update w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>

                                    <div class="container position-relative delete-image-update">
                                      <button type="button" class="btn btn-danger btn-sm delete-update-post" name="delete_image">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      <?php

                                      ?>
                                      <div class="row">
                                        <?php
                                        $image = $photo->getPhotoByPost($row['id']);
                                        foreach ($image as $img) {
                                          echo '<div class="col-md-6 mb-3">
                                                      <img src="./Public/upload/' . $img['image_url'] . '" class="img-fluid" style="width: 98%;">
                                                    </div>';
                                        }
                                        ?>
                                      </div>
                                    </div>


                                  </div>
                                </div>
                                <!-- end -->
                              </div>
                              <!-- footer -->
                              <div class="modal-footer">
                                <!-- upload image -->
                                <div class="w-100">
                                  <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImageUpdate">
                                    <p class="m-0">Thêm hình ảnh vào bài viết</p>
                                    <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                                  </label>
                                  <input type="file" name="photoUpdate[]" id="postImageUpdate" multiple hidden onchange="showPreviewPostImageUpdate()">
                                </div>
                                <input type="submit" name="update-post" id="submitPostUpdate" class="btn btn-secondary w-100" value="Cập nhật" disabled>
                              </div>
                            </form>
                          </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0">
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
                        </a>
                        <!-- likes & comments -->
                        <div class="post__comment position-relative pt-0">
                          <!-- likes-comment -->
                          <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                            <!-- like -->
                            <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                            <!-- Modal like-->
                            <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                      Tất cả
                                      <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    $userIds = $like->getIdUserByIdLike($row['id']);
                                    foreach ($userIds as $userId) {
                                      $user_id = $userId['user_id'];
                                    ?>
                                      <li class="dropdown-item p-1 rounded">
                                        <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                          <div class="p-2">
                                            <?php
                                            if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                              <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php } else { ?>
                                              <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php }
                                            ?>
                                          </div>
                                          <div class="">
                                            <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                          </div>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>


                                  </div>
                                </div>
                              </div>
                            </div>

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

                              <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
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
                              <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#" data-bs-toggle="modal" data-bs-target="#updatePost_<?php echo $row['id']; ?>">
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

                      <!-- update post modal -->
                      <div class="modal fade" id="updatePost_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePost_<?php echo $row['id']; ?>Label" aria-hidden="true" data-bs-backdrop="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class=" modal-content">
                            <form action="" method="post" id="form-post" enctype="multipart/form-data">
                              <!-- head -->
                              <div class="modal-header flex-column border-0 pb-1 p-0">
                                <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                                  <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                                    Chỉnh sửa bài viết
                                  </h5>
                                  <button type="button" class="btn-close toggle-update-post" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- name -->
                                <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                                  <div class="p-2">
                                    <?php
                                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php } else { ?>
                                      <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php }
                                    ?>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                                  </div>
                                </div>
                              </div>
                              <!-- body -->
                              <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                                <div class="my-1 p-1">
                                  <div class="d-flex flex-column">
                                    <!-- textarea -->
                                    <div>
                                      <?php
                                      if ($row['content'] !== null || $row['content'] !== '') {
                                        echo '
                                          <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post-update" id="content-post-update" style="box-shadow: none;" oninput="toggleSubmitButtonUpdate()">' . $row['content'] . '</textarea>
                                          ';
                                      }
                                      ?>
                                    </div>
                                    <input type="hidden" name="post_id" value="<?php echo $row['id'] ?>">
                                    <!-- images preview -->
                                    <div class="post-preview-update w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>

                                    <div class="container position-relative delete-image-update">
                                      <button type="button" class="btn btn-danger btn-sm delete-update-post" name="delete_image">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      <?php

                                      ?>
                                      <div class="row">
                                        <?php
                                        $image = $photo->getPhotoByPost($row['id']);
                                        foreach ($image as $img) {
                                          echo '<div class="col-md-6 mb-3">
                                                      <img src="./Public/upload/' . $img['image_url'] . '" class="img-fluid" style="width: 98%;">
                                                    </div>';
                                        }
                                        ?>
                                      </div>
                                    </div>


                                  </div>
                                </div>
                                <!-- end -->
                              </div>
                              <!-- footer -->
                              <div class="modal-footer">
                                <!-- upload image -->
                                <div class="w-100">
                                  <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImageUpdate">
                                    <p class="m-0">Thêm hình ảnh vào bài viết</p>
                                    <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                                  </label>
                                  <input type="file" name="photoUpdate[]" id="postImageUpdate" multiple hidden onchange="showPreviewPostImageUpdate()">
                                </div>
                                <input type="submit" name="update-post" id="submitPostUpdate" class="btn btn-secondary w-100" value="Cập nhật" disabled>
                              </div>
                            </form>
                          </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0" style="width: 100%;">
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
                        </a>
                        <!-- likes & comments -->
                        <div class="post__comment position-relative pt-0">
                          <!-- likes-comment -->
                          <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                            <!-- like -->
                            <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                            <!-- Modal like-->
                            <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                      Tất cả
                                      <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    $userIds = $like->getIdUserByIdLike($row['id']);
                                    foreach ($userIds as $userId) {
                                      $user_id = $userId['user_id'];
                                    ?>
                                      <li class="dropdown-item p-1 rounded">
                                        <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                          <div class="p-2">
                                            <?php
                                            if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                              <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php } else { ?>
                                              <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php }
                                            ?>
                                          </div>
                                          <div class="">
                                            <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                          </div>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>


                                  </div>
                                </div>
                              </div>
                            </div>

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

                              <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
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
                              <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#" data-bs-toggle="modal" data-bs-target="#updatePost_<?php echo $row['id']; ?>">
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

                      <!-- update post modal -->
                      <div class="modal fade" id="updatePost_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePost_<?php echo $row['id']; ?>Label" aria-hidden="true" data-bs-backdrop="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class=" modal-content">
                            <form action="" method="post" id="form-post" enctype="multipart/form-data">
                              <!-- head -->
                              <div class="modal-header flex-column border-0 pb-1 p-0">
                                <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                                  <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                                    Chỉnh sửa bài viết
                                  </h5>
                                  <button type="button" class="btn-close toggle-update-post" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- name -->
                                <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                                  <div class="p-2">
                                    <?php
                                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php } else { ?>
                                      <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php }
                                    ?>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                                  </div>
                                </div>
                              </div>
                              <!-- body -->
                              <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                                <div class="my-1 p-1">
                                  <div class="d-flex flex-column">
                                    <!-- textarea -->
                                    <div>
                                      <?php
                                      if ($row['content'] !== null || $row['content'] !== '') {
                                        echo '
                                          <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post-update" id="content-post-update" style="box-shadow: none;" oninput="toggleSubmitButtonUpdate()">' . $row['content'] . '</textarea>
                                          ';
                                      }
                                      ?>
                                    </div>
                                    <input type="hidden" name="post-preview-update" value="<?php echo $row['id'] ?>">
                                    <!-- images preview -->
                                    <div class="post-preview-update w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>

                                    <div class="container position-relative delete-image-update">
                                      <button type="button" class="btn btn-danger btn-sm delete-update-post" name="delete_image">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      <?php

                                      ?>
                                      <div class="row">
                                        <?php
                                        $image = $photo->getPhotoByPost($row['id']);
                                        foreach ($image as $img) {
                                          echo '<div class="col-md-6 mb-3">
                                                      <img src="./Public/upload/' . $img['image_url'] . '" class="img-fluid" style="width: 98%;">
                                                    </div>';
                                        }
                                        ?>
                                      </div>
                                    </div>


                                  </div>
                                </div>
                                <!-- end -->
                              </div>
                              <!-- footer -->
                              <div class="modal-footer">
                                <!-- upload image -->
                                <div class="w-100">
                                  <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImageUpdate">
                                    <p class="m-0">Thêm hình ảnh vào bài viết</p>
                                    <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                                  </label>
                                  <input type="file" name="photoUpdate[]" id="postImageUpdate" multiple hidden onchange="showPreviewPostImageUpdate()">
                                </div>
                                <input type="submit" name="update-post" id="submitPostUpdate" class="btn btn-secondary w-100" value="Cập nhật" disabled>
                              </div>
                            </form>
                          </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0 mb-1" style="width: 100%;">
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
                        </a>
                        <!-- likes & comments -->
                        <div class="post__comment position-relative pt-0">
                          <!-- likes-comment -->
                          <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                            <!-- like -->
                            <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                            <!-- Modal like-->
                            <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                      Tất cả
                                      <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    $userIds = $like->getIdUserByIdLike($row['id']);
                                    foreach ($userIds as $userId) {
                                      $user_id = $userId['user_id'];
                                    ?>
                                      <li class="dropdown-item p-1 rounded">
                                        <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                          <div class="p-2">
                                            <?php
                                            if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                              <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php } else { ?>
                                              <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php }
                                            ?>
                                          </div>
                                          <div class="">
                                            <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                          </div>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>


                                  </div>
                                </div>
                              </div>
                            </div>

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

                              <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
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
                              <a class="dropdown-item d-flex justify-content-around align-items-center fs-7" href="#" data-bs-toggle="modal" data-bs-target="#updatePost_<?php echo $row['id']; ?>">
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

                      <!-- update post modal -->
                      <div class="modal fade" id="updatePost_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePost_<?php echo $row['id']; ?>Label" aria-hidden="true" data-bs-backdrop="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class=" modal-content">
                            <form action="" method="post" id="form-post" enctype="multipart/form-data">
                              <!-- head -->
                              <div class="modal-header flex-column border-0 pb-1 p-0">
                                <div class="w-100 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle p-3">
                                  <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                                    Chỉnh sửa bài viết
                                  </h5>
                                  <button type="button" class="btn-close toggle-update-post" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- name -->
                                <div class="w-100 d-flex align-items-center justify-content-start mt-1 px-3">
                                  <div class="p-2">
                                    <?php
                                    if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                      <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php } else { ?>
                                      <img src="./Public/images/avt_default.png" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;">
                                    <?php }
                                    ?>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                                  </div>
                                </div>
                              </div>
                              <!-- body -->
                              <div class="modal-body overflow-y-auto pt-0" style="max-height: 400px;">
                                <div class="my-1 p-1">
                                  <div class="d-flex flex-column">
                                    <!-- textarea -->
                                    <div>
                                      <?php
                                      if ($row['content'] !== null || $row['content'] !== '') {
                                        echo '
                                          <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post-update" id="content-post-update" style="box-shadow: none;" oninput="toggleSubmitButtonUpdate()">' . $row['content'] . '</textarea>
                                          ';
                                      }
                                      ?>
                                    </div>
                                    <input type="hidden" name="post-preview-update" value="<?php echo $row['id'] ?>">
                                    <!-- images preview -->
                                    <div class="post-preview-update w-100 bolder-1 rounded p-1 mt-2 position-relative"></div>
                                    <div class="container position-relative delete-image-update">
                                      <button type="button" class="btn btn-danger btn-sm delete-update-post" name="delete_image">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      <?php
                                      ?>
                                      <div class="row">
                                        <?php
                                        $image = $photo->getPhotoByPost($row['id']);
                                        foreach ($image as $img) {
                                          echo '<div class="col-md-6 mb-3">
                                                      <img src="./Public/upload/' . $img['image_url'] . '" class="img-fluid" style="width: 98%;">
                                                    </div>';
                                        }
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- end -->
                              </div>
                              <!-- footer -->
                              <div class="modal-footer">
                                <!-- upload image -->
                                <div class="w-100">
                                  <label class="d-flex justify-content-between border border-1 rounded p-3 my-1 shadow-sm" for="postImageUpdate">
                                    <p class="m-0">Thêm hình ảnh vào bài viết</p>
                                    <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                                  </label>
                                  <input type="file" name="photoUpdate[]" id="postImageUpdate<?php echo $row['id']; ?>" multiple hidden onchange="showPreviewPostImageUpdate(postImageUpdate<?php echo $row['id']; ?>)">
                                </div>
                                <input type="submit" name="update-post" id="submitPostUpdate<?php echo $row['id']; ?>" class="btn btn-secondary w-100" value="Cập nhật" disabled>
                              </div>
                            </form>
                          </div>
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
                        <a href="./index.php?ctrl=slider&id_post=<?php echo $row['id'] ?>" class="container m-0 g-0 position-relative" style="width: 100%;">
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
                        </a>
                        <!-- likes & comments -->
                        <div class="post__comment position-relative pt-0">
                          <!-- likes-comment -->
                          <div class="d-flex align-items-center justify-content-between px-3" style="height: 50px; z-index: 5">
                            <!-- like -->
                            <button type="button" class="border-0 shadow-none bg-white d-flex gap-2 align-items-center btn-like-button" value="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle_<?php echo $row['id']; ?>">
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

                            <!-- Modal like-->
                            <div class="modal fade" id="exampleModalToggle_<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel_<?php echo $row['id']; ?>" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-6 d-flex justify-content-center align-items-center gap-2" id="exampleModalToggleLabel">
                                      Tất cả
                                      <i class="fa-solid fa-heart me-3" style="color: #ff0000;"></i>
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    $userIds = $like->getIdUserByIdLike($row['id']);
                                    foreach ($userIds as $userId) {
                                      $user_id = $userId['user_id'];
                                    ?>
                                      <li class="dropdown-item p-1 rounded">
                                        <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                                          <div class="p-2">
                                            <?php
                                            if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                                              <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php } else { ?>
                                              <img src="./Public/images/avt_default.png" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php }
                                            ?>
                                          </div>
                                          <div class="">
                                            <p class="m-0"><?= $user->getFullnameByUser($user_id) ?></p>
                                          </div>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>


                                  </div>
                                </div>
                              </div>
                            </div>
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

                              <input type="hidden" name="sharePostId" value="<?php echo $row['id'] ?>">
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
              }
            }
          }
          // Xử lý share bài post              
          if (isset($_POST['sharePost'])) {
            $content = "";
            $post_id = $_POST['sharePostId'];
            $result = $post->insertPost($content, $user_id);
            if ($result[0]) {
              $post_share_id = $result[1];
              $share = $share->insertShare($user_id, $post_id, $post_share_id);
              header('location: index.php');
            }
          }
          ?>
        </div>
      </div>
      <!-- ================= Chatbar ================= -->
      <div class="col-12 col-lg-3">
        <div class="d-none d-xxl-block h-100 fixed-top end-0 overflow-hidden scrollbar" style=" max-width: 360px; width: 100%; z-index: 4; padding-top: 56px; left: initial !important;">
          <div class="p-3 mt-4">
            <!-- contacts -->
            <hr class="m-0" />
            <div class="my-3 d-flex justify-content-between align-items-center">
              <p class="text-muted fs-5 m-0">Người liên hệ</p>
            </div>
            <!-- friend 1 -->
            <li class="dropdown-item rounded my-2 px-0" type="button" data-bs-toggle="modal" data-bs-target="#singleChat1">
              <!-- avatar -->
              <div class="d-flex align-items-center mx-2 chat-avatar">
                <div class="position-relative">
                  <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <span class="position-absolute bottom-0 translate-middle border border-light rounded-circle bg-success p-1" style="left: 75%">
                    <span class="visually-hidden"></span>
                  </span>
                </div>
                <p class="m-0">Võ Khánh Duy</p>
              </div>
            </li>
            <!-- friend 2 -->
            <li class="dropdown-item rounded my-2 px-0" type="button" data-bs-toggle="modal" data-bs-target="#singleChat3">
              <!-- avatar -->
              <div class="d-flex align-items-center mx-2 chat-avatar">
                <div class="position-relative">
                  <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <span class="position-absolute bottom-0 translate-middle border border-light rounded-circle bg-success p-1" style="left: 75%">
                    <span class="visually-hidden"></span>
                  </span>
                </div>
                <p class="m-0">Hồ Dư Mai Trân</p>
              </div>
            </li>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ================= Chat Icon ================= -->
  <div class="fixed-bottom right-100 p-3" style="z-index: 6; left: initial" type="button" data-bs-toggle="modal" data-bs-target="#newChat">
    <i class="fas fa-edit bg-white rounded-circle p-3 shadow"></i>
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


  $(document).ready(function() {
    $('.delete-update-post').click(function() {
      $('.delete-image-update').hide(); // Remove all content inside the 'row' div
    });
  });
  $(document).ready(function() {
    $('.toggle-update-post').click(function() {
      $('.delete-image-update').toggle(); // Toggle visibility of elements with the 'post-image' class
    });
  });
</script>