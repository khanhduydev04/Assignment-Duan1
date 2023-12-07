<?php
$friend = new Friend();
$post = new Post();
$photo = new Photo();
$user = new User();
$comment = new Comment();
$like = new Likes();
$share = new Share();
$story = new Stories();

$uploadDir = './Public/upload/';
$allowedExtensions = ['png', 'jpg', 'jpeg'];
$error = [];

$id = $_SESSION['user']['id']; //Lấy id user mặc định
$user_id = $_SESSION['user']['id']; //Lấy id user mặc định

$user_id2 = null;
if (isset($_GET['id'])) {
  $id = $_GET['id']; //Lấy id các user khác
  $user_id2 = $_GET['id']; //Lấy id các user khác
}

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

// add friend
if (isset($_POST["send_request"])) {
  if ($friend->addFriend($user_id, $user_id2)) {
    if ($follow->insertFollow($user_id, $user_id2)) {
      header("Location: index.php?ctrl=profile&id=$user_id2");
    }
  }
}
//accept request
if (isset($_POST["accept_request"])) {
  $friend_id = $friend->getFriendID($user_id, $user_id2);
  $follow_id = $follow->getFollowID($user_id, $user_id2);
  if ($friend->acceptRequest($friend_id)) {
    if ($follow->insertFollow($user_id, $user_id2)) {
      header("Location: index.php?ctrl=profile&id=$user_id2");
    }
  }
}
//cancel request && delete friend
if (isset($_POST["cancel_request"]) || isset($_POST["delete_friend"])) {
  $friend_id = $friend->getFriendID($user_id, $user_id2);
  $follow_id = $follow->getFollowID($user_id, $user_id2);
  if ($friend->deleteFriend($friend_id)) {
    if ($follow->deleteFollow($follow_id)) {
      header("Location: index.php?ctrl=profile&id=$user_id2");
    }
  }
}
//cancel_follow
if (isset($_POST["cancel_follow"])) {
  $follow_id = $follow->getFollowID($user_id, $user_id2);
  $follow->deleteFollow($follow_id);
}
//add_follow
if (isset($_POST["add_follow"])) {
  $follow->insertFollow($user_id, $user_id2);
}

//Xử lý ảnh
function uploadImage($inputName, $uploadDir, $allowedExtensions)
{
  $singleImage = $_FILES[$inputName]['tmp_name'];
  $singleImageName = $_FILES[$inputName]['name'];
  $singleImageExt = strtolower(pathinfo($singleImageName, PATHINFO_EXTENSION));

  if (empty($singleImageName)) {
    $error[] = "Vui lòng chọn file.";
  } else {
    if (in_array($singleImageExt, $allowedExtensions)) {
      $singleTargetFilePath = $uploadDir . $singleImageName;

      if (move_uploaded_file($singleImage, $singleTargetFilePath)) {
        return basename($singleImageName);
      } else {
        $error[] = "Upload file thất bại $singleImageName";
      }
    } else {
      $error[] = "$singleImageName không đúng định dạng yêu cầu.";
    }
  }

  return ['error' => $error];
}

// post
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
      header("Location: index.php?ctrl=profile");
      exit();
    }
  }
}

//post avatar
if (isset($_POST['postAvatar']) && $_POST['postAvatar']) {
  $content = $_POST['content-avatar'];
  $id_user = $user_id;
  $status = 'avatar';

  $file_name = uploadImage('avatar-image', $uploadDir, $allowedExtensions);
  if (isset($file_name['error'])) {
    echo implode("<br>", $file_name['error']);
  } else {
    $result = $post->insertPost($content, $id_user);
    if ($result[0]) {
      $post_id = $result[1];
      $photo->insertPhoto($file_name, $status, $post_id);
    }
  }
}

//post cover
if (isset($_POST['postCover']) && $_POST['postCover']) {
  $content = $_POST['content-cover'];
  $id_user = $user_id;
  $status = 'cover';

  $file_name = uploadImage('cover-image', $uploadDir, $allowedExtensions);
  if (isset($file_name['error'])) {
    echo implode("<br>", $file_name['error']);
  } else {
    $result = $post->insertPost($content, $id_user);
    if ($result[0]) {
      $post_id = $result[1];
      $photo->insertPhoto($file_name, $status, $post_id);
    }
  }
}
?>
<main style="padding-top: 57px;" class="pb-4">
  <div class="bg-white w-100 d-flex justify-content-center shadow-sm">
    <div class="profile d-flex flex-column align-items-center">
      <div class="profile-cover d-flex justify-content-center position-relative w-100 rounded-3 bg-gray">
        <!-- Image cover -->
        <?php
        if ($photo->getNewCoverByUser($id) != null) { ?>
          <img src="./Public/upload/<?= $photo->getNewCoverByUser($id) ?>" alt="" id="image-cover" class="w-100 rounded-3" />
        <?php }
        if ($id === $user_id) { ?>
          <!-- Nút mở modal changeCover-->
          <button type="button" class="btn mt-2 position-absolute" data-bs-toggle="modal" data-bs-target="#changeCoverModal" style="background-color: rgba(0, 0, 0, 0.4); bottom: 20px; right: 20px;">
            <i class="fa-solid fa-camera" style="color: #ffffff;"></i>
            <span class="ms-1 text-light">Thay đổi ảnh bìa</span>
          </button>
        <?php } ?>
        <!-- Modal changeCoverModal -->
        <div class="modal fade" id="changeCoverModal" tabindex="-1" aria-labelledby="changeCoverModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-header position-relative">
                  <h5 class="modal-title w-100 text-center fw-bold" id="changeCoverModalLabel">Chọn
                    ảnh bìa</h5>
                  <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="right: 20px;"></button>
                </div>
                <div class="modal-body">

                  <div class="col-12 mb-3">
                    <label for="imageCover" id="labelUpload" class="btn btn-outline-primary cursor-pointer w-100 px-1 text-center fw-medium rounded-2">
                      + Tải ảnh lên
                    </label>
                    <input type="file" accept="image/*" id="imageCover" class="image-input" name="cover-image" hidden onchange="showDetailModalWrapper('changeCoverModal')">
                  </div>
                  <div class="modal-desc col-12 mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="content-cover" id="description" cols="30" rows="10" class="w-100 p-3 form-control" style="max-height: 80px;"></textarea>
                  </div>
                  <div class="preview col-12 mb-3">
                    <img src="" alt="image-preview" class="w-100 rounded-3" id="imagePreview">
                  </div>
                </div>
                <div class="modal-footer modal-change-footer" style="display: none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetDetailModalWrapper('changeCoverModal')">Đóng</button>
                  <input type="submit" class="btn btn-primary" id="saveButton" name="postCover" value="Lưu thay đổi">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="main-container d-flex align-items-center position-relative border-bottom px-3 pb-3">
        <div class="profile-avatar position-relative me-4" style="width: 170px; height: 170px; margin-top: -70px;">
          <!-- Image avatar -->
          <?php
          if ($photo->getNewAvatarByUser($id) != null) { ?>
            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($id) ?>" alt="avatar" id="avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;" />
          <?php } else { ?>
            <img src="./Public/images/avt_default.png" alt="avatar" id="avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;" />
          <?php }
          if ($id === $user_id) { ?>
            <!-- Nút mở modal changeAvatar-->
            <button type="button" class="btn position-absolute rounded-circle p-2 d-flex" data-bs-toggle="modal" data-bs-target="#changeAvatarModal" style="background-color: #E4E6EB; bottom: 25px; right: 25px; transform: translate(50%, 50%);">
              <i class="fa-solid fa-camera" style="color: #17191c; font-size: 20px;"></i>
            </button>
          <?php } ?>
        </div>
        <!-- Modal changeAvatarModal -->
        <div class="modal fade" id="changeAvatarModal" tabindex="-1" aria-labelledby="changeAvatarModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-header position-relative">
                  <h5 class="modal-title w-100 text-center fw-bold" id="changeAvatarModalLabel">Chọn
                    ảnh đại diện</h5>
                  <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="right: 20px;"></button>
                </div>
                <div class="modal-body">
                  <div class="col-12 mb-3">
                    <label for="imageAvatar" id="labelUpload" class="btn btn-outline-primary cursor-pointer w-100 px-1 text-center fw-medium rounded-2">
                      + Tải ảnh lên
                    </label>
                    <input type="file" id="imageAvatar" class="image-input" name="avatar-image" hidden onchange="showDetailModalWrapper('changeAvatarModal')">
                  </div>
                  <div class="modal-desc col-12 mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="content-avatar" id="description" cols="30" rows="10" class="w-100 p-3 form-control" style="max-height: 80px;"></textarea>
                  </div>
                  <div class="preview col-6 mb-3 mx-auto ">
                    <img src="" alt="image-preview" class="w-100 rounded-circle" id="imagePreview" style="aspect-ratio: 1/1;">
                  </div>
                </div>
                <div class="modal-footer modal-change-footer" style="display: none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetDetailModalWrapper('changeAvatarModal')">Đóng</button>
                  <input type="submit" class="btn btn-primary" id="saveButton" name="postAvatar" value="Lưu thay đổi">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-grow-1">
          <div class="profile-name">
            <h3 class="fs-3 fw-bold mb-1"><?= $user->getFullnameByUser($id) ?></h3>
            <a href="index.php?ctrl=profile&act=friends" class="text-secondary fw-medium text-decoration-none"><?= $friend->countAllFriend($id) ?> bạn bè</a>
          </div>
          <div class="profile-action">
            <form action="" method="post">
              <?php
              if ($id !== $user_id) {
                $isFriend = $friend->checkIsFriend($user_id, $id);

                switch ($isFriend) {
                  case "Bạn bè": ?>
                    <!-- dropdown friend -->
                    <div class="dropdown">
                      <button class="btn btn-secondary border-0 text-dark dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #E4E6EB;">
                        <i class="fa-solid fa-user-check" style="color: #17191c;"></i>
                        <span>Bạn bè</span>
                      </button>
                      <ul class="dropdown-menu">
                        <?php
                        if (!$follow->getFollowID($user_id, $user_id2)) {
                          echo '<li><button type="submit" class="dropdown-item  py-2 fw-semibold" name="add_follow">Theo dõi</button></li>';
                        } else {
                          echo '<li><button type="submit" class="dropdown-item  py-2 fw-semibold" name="cancel_follow">Bỏ theo dõi</button></li>';
                        }
                        ?>
                        <li><button type="submit" class="dropdown-item  py-2 fw-semibold" name="delete_friend">Hủy bạn bè</button></li>
                      </ul>
                    </div>
                  <?php break;
                  case "Đã gửi lời mời": ?>
                    <!-- cancel request button -->
                    <button type="submit" class="btn btn-secondary d-flex align-items-center gap-2" name="cancel_request">
                      <i class="fa-solid fa-user-xmark" style="font-size: 18px;"></i>
                      <span>Hủy lời mời</span>
                    </button>
                  <?php break;
                  case "Lời mời đến bạn": ?>
                    <!-- accept request button -->
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-check" style="color: #ffffff; font-size: 18px;"></i>
                        <span class="">Phản hồi</span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><button type="submit" class="dropdown-item py-2 fw-semibold" name="accept_request">Chấp nhận</button></li>
                        <li><button type="submit" class="dropdown-item py-2 fw-semibold" name="delete_friend">Xóa lời mời</button></li>
                      </ul>
                    </div>
                  <?php break;
                  default: ?>
                    <!-- add friend button -->
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" name="send_request">
                      <i class="fa-solid fa-user-plus" style="color: #ffffff; font-size: 18px;"></i>
                      <span>Thêm bạn bè</span>
                    </button>
              <?php break;
                }
              }
              ?>
            </form>
          </div>
        </div>
      </div>
      <div class="main-container w-100%">
        <ul class="m-0 py-2 d-flex align-items-center gap-1 list-unstyled" style="height: 60px;">
          <li class="nav__btn <?= isset($_GET['act']) ? '' : 'nav__btn-active' ?>"><a href="index.php?ctrl=profile&id=<?= $id ?>" class="btn px-4 py-2 text-decoration-none fw-medium">Bài viết</a>
          </li>
          <li class="nav__btn <?= (isset($_GET['act']) && $_GET['act'] == 'friends') ? 'nav__btn-active' : '' ?>"><a href="index.php?ctrl=profile&act=friends&id=<?= $id ?>" class="btn px-4 py-2 text-decoration-none fw-medium">Bạn bè</a>
          </li>
          <li class="nav__btn  <?= (isset($_GET['act']) && $_GET['act'] == 'photos') ? 'nav__btn-active' : '' ?>"><a href="index.php?ctrl=profile&act=photos&id=<?= $id ?>" class="btn px-4 py-2 text-decoration-none fw-medium">Ảnh</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="main-container mx-auto mt-3">
    <?php
    if (isset($_GET['act'])) {
      $act = $_GET['act'];

      switch ($act) {
        case "friends": ?>
          <div class="shadow-sm p-3 bg-white rounded-3 w-100">
            <div class="d-flex justify-content-between align-items-center">
              <h5><strong>Bạn bè</strong></h5>
              <form action="" class="search-friend">
                <i class="fa-solid fa-magnifying-glass search-friend-icon"></i>
                <input class="search-friend-form" type="search" placeholder="Tìm kiếm">
              </form>
            </div>
            <!-- button -->
            <div class="mt-4 d-flex justify-content-start">
              <div class="me-3">
                <p type="button" class="ms-3 me-3 text-secondary fw-semibold" onclick="showFriend()">Tất cả bạn bè </p>
                <hr id="friend_hr" class="border border-primary border-2 opacity-75">
              </div>
              <div class="">
                <p type="button" class="text-secondary fw-semibold" onclick="showFollow()">Đang theo dõi </p>
                <hr id="follow_hr" class="border border-primary border-2 opacity-75" style="display:none">
              </div>
            </div>
            <!-- List friend -->
            <!--All friend-->
            <div id="friend" class="products">
              <div class="container overflow-hidden text-center">
                <div class="row gy-1">
                  <?php
                  $getFriends = $friend->getAllFriendByUser($id);
                  if ($getFriends !== null && $getFriends) {
                    foreach ($getFriends as $row) {
                      if ($id != $row['user_id1']) {
                        $row = $user->getUserById($row['user_id1']);
                      } elseif ($id != $row['user_id2']) {
                        $row = $user->getUserById($row['user_id2']);
                      } ?>
                      <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                          <!--Avatar-->
                          <div class="d-flex justify-content-center align-items-center">
                            <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                              <?php
                              if ($photo->getNewAvatarByUser($row['id']) !== null) { ?>
                                <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;" />
                              <?php } else { ?>
                                <img src="./Public/images/avt_default.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;" />
                              <?php }
                              ?>
                            </a>
                            <div class="ms-2 mt-2 text-start">
                              <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>" class="text-dark">
                                <h6><?= $row['first_name'] . ' ' . $row['last_name'] ?></h6>
                              </a>
                              <?php
                              if ($friend->countMatualFriend($user_id, $row['id']) != 0) {
                                echo '<p class="fs-7 text-secondary">' . $friend->countMatualFriend($user_id, $row['id']) . ' bạn chung</p>';
                              }
                              ?>
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <strong type="button" data-bs-custom-class="chat-box" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    ' data-bs-html="true">
                              ...
                            </strong>
                          </div>
                        </div>
                      </div>
                  <?php  }
                  } else {
                    echo '<p class="fw-semibold text-center w-100">Không có bạn bè để hiển thị</p>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <!--Following friend-->
            <div id="follow" class="products" style="display: none;">
              <div class="container overflow-hidden text-center">
                <div class="row gy-1">
                  <?php
                  $getFollows = $follow->getAllFollow($id);
                  if ($getFollows !== null && $getFollows) {
                    foreach ($getFollows as $row) {
                      $row = $user->getUserById($row['user_id2']) ?>
                      <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                          <!--Avatar-->
                          <div class="d-flex justify-content-center align-items-center">
                            <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>">
                              <?php
                              if ($photo->getNewAvatarByUser($row['id']) !== null) { ?>
                                <img src="./Public/upload/<?= $photo->getNewAvatarByUser($row['id']) ?>" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;" />
                              <?php } else { ?>
                                <img src="./Public/images/avt_default.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;" />
                              <?php }
                              ?>
                            </a>
                            <div class="ms-2 mt-2 text-start">
                              <a href="index.php?ctrl=profile&id=<?= $row['id'] ?>" class="text-dark">
                                <h6><?= $user->getFullnameByUser($row['id']) ?></h6>
                              </a>
                              <?php
                              if ($friend->countMatualFriend($user_id, $row['id']) != 0) {
                                echo '<p class="fs-7 text-secondary">' . $friend->countMatualFriend($user_id, $row['id']) . ' bạn chung</p>';
                              }
                              ?>
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <strong type="button" data-bs-custom-class="chat-box" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    ' data-bs-html="true">
                              ...
                            </strong>
                          </div>
                        </div>
                      </div>
                  <?php  }
                  } else {
                    echo '<p class="fw-semibold text-center">Không có bạn bè để hiển thị</p>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php break;
        case "photos": ?>
          <div class="shadow-sm p-3 bg-white rounded-3 w-100">
            <div class="d-flex justify-content-between align-items-center">
              <h5><strong class="">Ảnh</strong></h5>
            </div>
            <!-- button -->
            <div class="mt-4 d-flex justify-content-start">
              <div class="me-4">
                <p type="button" class="ms-3 me-3 text-secondary fw-semibold" onclick="showPicture()">Ảnh của bạn </p>
                <hr id="Picture_hr" class="border border-primary border-2 opacity-75">
              </div>
              <div class="me-4">
                <p type="button" class="text-secondary fw-semibold" onclick="showAvatar()">Ảnh đại diện </p>
                <hr id="Avatar_hr" class="border border-primary border-2 opacity-75" style="display:none">
              </div>
              <div class="">
                <p type="button" class="text-secondary fw-semibold" onclick="showCover()">Ảnh bìa</p>
                <hr id="Cover_hr" class="border border-primary border-2 opacity-75" style="display:none">
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="">
                  <div class="modal-body">
                    <img src="" class="img-fluid rounded" alt="" id="modalImage">
                  </div>
                </div>
              </div>
            </div>
            <!--Your picture-->
            <div id="Picture" class="products">
              <div class="container text-center">
                <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                  <?php
                  $all_photos = $photo->getAllPhotoByUser($id);
                  if ($all_photos && $all_photos !== null) {
                    foreach ($all_photos as $image_item) { ?>
                      <div class="col" style="width: 158px; height: 158px;">
                        <div class="position-picture" style="width: 100%; height: 100%;">
                          <img src="./Public/upload/<?= $image_item['image_url'] ?>" class="w-100 h-100 object-fit-cover" style="border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-src="./Public/upload/<?= $image_item['image_url'] ?>">
                          <div class="d-flex align-items-center position-picture-icon">
                            <strong type="button" class="rounded-circle transparent-bg d-flex justify-content-center align-items-center p-2" style="width: 28px; height: 28px;" data-bs-custom-class="chat-box" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content='
                              <div class="d-flex justify-content-center align-items-center">
                                <p class=" fa-solid fa-trash-can"></p>
                                <p class="ms-2">Xóa ảnh</p>
                              </div>
                            ' data-bs-html="true">
                              <i class="fa-solid fa-pen text-white fs-7"></i>
                            </strong>
                          </div>
                        </div>
                      </div>
                  <?php }
                  } else {
                    echo '<p class="w-100 fw-semibold text-center">Không có ảnh để hiển thị</p>';
                  } ?>
                </div>
              </div>
            </div>
            <!--Avatar-->
            <div id="Avatar" class="products" style="display: none;">
              <div class="container text-center">
                <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                  <?php
                  $all_avt = $photo->getAllAvatarByUser($id);
                  if ($all_avt && $all_avt !== null) {
                    foreach ($all_avt as $image_item) { ?>
                      <div class="col" style="width: 158px; height: 158px;">
                        <div class="position-picture" style="width: 100%; height: 100%;">
                          <img src="./Public/upload/<?= $image_item['image_url'] ?>" class="w-100 h-100 object-fit-cover" style="border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-src="./Public/upload/<?= $image_item['image_url'] ?>">
                          <div class="d-flex align-items-center position-picture-icon">
                            <strong type="button" class="rounded-circle transparent-bg d-flex justify-content-center align-items-center p-2" style="width: 28px; height: 28px;" data-bs-custom-class="chat-box" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content='
                              <div class="d-flex justify-content-center align-items-center">
                                <p class=" fa-solid fa-trash-can"></p>
                                <p class="ms-2">Xóa ảnh</p>
                              </div>
                            ' data-bs-html="true">
                              <i class="fa-solid fa-pen text-white fs-7"></i>
                            </strong>
                          </div>
                        </div>
                      </div>
                  <?php }
                  } else {
                    echo '<p class="w-100 fw-semibold text-center">Không có ảnh để hiển thị</p>';
                  } ?>
                </div>
              </div>
            </div>
            <!--Cover image-->
            <div id="Cover" class="products" style="display: none;">
              <div class="container text-center">
                <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                  <?php
                  $all_cover = $photo->getAllCoverByUser($id);
                  if ($all_cover && $all_cover !== null) {
                    foreach ($all_cover as $image_item) { ?>
                      <div class="col" style="width: 158px; height: 158px;">
                        <div class="position-picture" style="width: 100%; height: 100%;">
                          <img src="./Public/upload/<?= $image_item['image_url'] ?>" class="w-100 h-100 object-fit-cover" style="border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-src="./Public/upload/<?= $image_item['image_url'] ?>">
                          <div class="d-flex align-items-center position-picture-icon">
                            <strong type="button" class="rounded-circle transparent-bg d-flex justify-content-center align-items-center p-2" style="width: 28px; height: 28px;" data-bs-custom-class="chat-box" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content='
                              <div class="d-flex justify-content-center align-items-center">
                                <p class=" fa-solid fa-trash-can"></p>
                                <p class="ms-2">Xóa ảnh</p>
                              </div>
                            ' data-bs-html="true">
                              <i class="fa-solid fa-pen text-white fs-7"></i>
                            </strong>
                          </div>
                        </div>
                      </div>
                  <?php }
                  } else {
                    echo '<p class="w-100 fw-semibold text-center">Không có ảnh để hiển thị</p>';
                  } ?>
                </div>
              </div>
            </div>
          </div>
      <?php break;
      }
    } else { ?>
      <div class="d-flex gap-3 w-100 align-items-start">
        <div class="d-none d-lg-flex flex-column gap-3 w-100 position-sticky" style="max-width: 426px; top: 57px;">
          <div class="profile-photos bg-white rounded-3 p-3 shadow-sm">
            <div class="pb-3 d-flex justify-content-between align-items-center">
              <h5><a href="index.php?ctrl=profile&act=photos&id=<?= $id ?>" class="fs-4 fw-bold text-dark text-decoration-none">Ảnh</a></h5>
              <a href="index.php?ctrl=profile&act=photos&id=<?= $id ?>" class="text-decoration-none">Xem tất cả ảnh</a>
            </div>
            <div class="rounded-3 overflow-hidden d-flex flex-wrap" style="gap: 4px;">
              <?php
              $all_photo = $photo->getAllPhotoByUser($id);
              if ($all_photo && ($all_photo !== null)) {
                $count = 0;
                foreach ($all_photo as $image) {
                  echo '<img src="./Public/upload/' . $image['image_url'] . '" alt="" class="profile-img">';
                  $count++;
                  if ($count == 6) {
                    break;
                  }
                }
              } ?>
              <!-- <img src="./Public/images/banner-men.png" alt="" class="profile-img"> -->
            </div>
          </div>
          <div class="profile-friends bg-white rounded-3 p-3 shadow-sm">
            <div class="pb-3 d-flex justify-content-between align-items-center">
              <h5><a href="index.php?ctrl=profile&act=friends" class="fs-4 fw-bold text-dark text-decoration-none">Bạn bè</a></h5>
              <a href="index.php?ctrl=profile&act=friends&id=<?= $id ?>" class="text-decoration-none">Xem tất cả bạn bè</a>
            </div>
            <div class="d-flex flex-wrap" style="column-gap: 8px;">
              <?php
              $all_friend = $friend->getAllFriendByUser($id);
              if ($all_friend && ($all_friend !== null)) {
                $count = 0;
                foreach ($all_friend as $friend_item) {
                  if ($friend_item['user_id1'] !== $id) {
                    $friend_item = $user->getUserById($friend_item['user_id1']);
                  } else {
                    $friend_item = $user->getUserById($friend_item['user_id2']);
                  } ?>
                  <div class="friend-item mb-2">
                    <a href="index.php?ctrl=profile&id=<?= $friend_item['id'] ?>">
                      <?php
                      if ($photo->getNewAvatarByUser($friend_item['id']) != null) { ?>
                        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($friend_item['id']) ?>" class="friend-image w-100 object-fit-cover rounded-2" />
                      <?php } else { ?>
                        <img src="./Public/images/avt_default.png" class="friend-image w-100 object-fit-cover rounded-2" />
                      <?php }
                      ?>
                    </a>
                    <a href="index.php?ctrl=profile&id=<?= $friend_item['id'] ?>" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                      <span><?= $user->getFullnameByUser($friend_item['id']) ?></span>
                    </a>
                  </div>
              <?php $count++;
                  if ($count == 6) {
                    break;
                  }
                }
              } ?>
            </div>
          </div>
        </div>
        <div class="" style="flex-basis: 680px; flex-shrink: 1; max-width: 680px; margin-top: -16px;">
          <?php
          if ($id === $user_id) { ?>
            <!-- create post -->
            <div class="bg-white mt-3 p-3 rounded border shadow-sm">
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
                              <textarea cols="30" rows="5" class="form-control border-0" autofocus name="content-post" id="content-post" style="box-shadow: none;" oninput="toggleSubmitButton()"></textarea>
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
          <?php }
          ?>

          <?php
          $all_post = $post->getAllPostByUser($id);
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
              }
            }
          }
          // Xử lý share bài post              
          if (isset($_POST['sharePost'])) {
            $content = "";
            $post_id = $row['id'];
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
    <?php } ?>
  </div>
</main>
<script>
  function setupImageModal() {
    // Lấy modal và phần tử hình ảnh
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    var modalImage = document.getElementById('modalImage');

    // Kiểm tra xem modal và hình ảnh có tồn tại không
    if (!imageModal || !modalImage) {
      console.error('Modal or modal image not found.');
      return;
    }

    // Lấy tất cả các phần tử mở modal
    var modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');

    // Kiểm tra xem có phần tử nào không
    if (!modalTriggers.length) {
      console.warn('No elements found with data-bs-toggle="modal".');
      return;
    }

    // Gán sự kiện click cho mỗi phần tử mở modal
    modalTriggers.forEach(function(trigger) {
      trigger.addEventListener('click', function() {
        // Lấy đường dẫn của hình ảnh từ thuộc tính data-bs-src
        var src = this.getAttribute('data-bs-src');

        // Kiểm tra xem đường dẫn có tồn tại không
        if (!src) {
          console.error('Data-bs-src attribute not found on the clicked element.');
          return;
        }

        // Cập nhật src của hình ảnh trong modal
        modalImage.setAttribute('src', src);

        // Hiển thị modal
        imageModal.show();
      });
    });
  }
  // Gọi hàm khi trang đã tải hoàn toàn
  document.addEventListener("DOMContentLoaded", setupImageModal);

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
  });

  //Xử lý ajax comment
  $(document).ready(function() {
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
    }
  });

  $(document).ready(function() {
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