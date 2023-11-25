<?php
$user =  new User();
$friend = new Friend();
$photo = new Photo();
$follow = new Follow();

$id = $_SESSION['user']['id']; //Lấy id user mặc định
$user_id = $_SESSION['user']['id']; //Lấy id user mặc định

$user_id2 = null;
if (isset($_GET['id'])) {
  $id = $_GET['id']; //Lấy id các user khác
  $user_id2 = $_GET['id']; //Lấy id các user khác
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
?>
<main style="padding-top: 57px;">
  <div class="bg-white w-100 d-flex justify-content-center shadow-sm">
    <div class="profile d-flex flex-column align-items-center">
      <div class="profile-cover d-flex justify-content-center position-relative w-100 rounded-3 bg-gray">
        <!-- Image cover -->
        <?php
        if (isset($_SESSION['user']['id']) && ($photo->getNewCoverByUser($user_id) != null)) { ?>
          <img src="./Public/upload/<?= $photo->getNewCoverByUser($user_id) ?>" alt="" id="image-cover" class="w-100 rounded-3" />
        <?php } ?>
        <!-- Nút mở modal -->
        <button type="button" class="btn mt-2 position-absolute" data-bs-toggle="modal" data-bs-target="#changeCoverModal" style="background-color: rgba(0, 0, 0, 0.4); bottom: 20px; right: 20px;">
          <i class="fa-solid fa-camera" style="color: #ffffff;"></i>
          <span class="ms-1 text-light">Thay đổi ảnh bìa</span>
        </button>
        <!-- Modal changeCoverModal -->
        <div class="modal fade" id="changeCoverModal" tabindex="-1" aria-labelledby="changeCoverModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form action="" method="post">
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
                    <input type="file" accept="image/*" id="imageCover" class="image-input" hidden onchange="showDetailModalWrapper('changeCoverModal')">
                  </div>
                  <div class="modal-desc col-12 mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="" id="description" cols="30" rows="10" class="w-100 p-3 form-control" style="max-height: 80px;"></textarea>
                  </div>
                  <div class="preview col-12 mb-3">
                    <img src="" alt="image-preview" class="w-100 rounded-3" id="imagePreview">
                  </div>
                </div>
                <div class="modal-footer" style="display: none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetDetailModalWrapper('changeCoverModal')">Đóng</button>
                  <button type="submit" class="btn btn-primary" id="saveButton">Lưu thay đổi</button>
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
          if (isset($_SESSION['user']['id']) && ($photo->getNewAvatarByUser($user_id) != null)) { ?>
            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avatar" id="avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;" />
          <?php } else { ?>
            <img src="./Public/images/avt_default.png" alt="avatar" id="avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;" />
          <?php }
          ?>
          <!-- Nút mở modal -->
          <button type="button" class="btn position-absolute rounded-circle p-2 d-flex" data-bs-toggle="modal" data-bs-target="#changeAvatarModal" style="background-color: #E4E6EB; bottom: 25px; right: 25px; transform: translate(50%, 50%);">
            <i class="fa-solid fa-camera" style="color: #17191c; font-size: 20px;"></i>
          </button>
        </div>
        <!-- Modal changeAvatarModal -->
        <div class="modal fade" id="changeAvatarModal" tabindex="-1" aria-labelledby="changeAvatarModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form action="" method="post">
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
                    <input type="file" accept="image/*" id="imageAvatar" class="image-input" hidden onchange="showDetailModalWrapper('changeAvatarModal')">
                  </div>
                  <div class="modal-desc col-12 mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="" id="description" cols="30" rows="10" class="w-100 p-3 form-control" style="max-height: 80px;"></textarea>
                  </div>
                  <div class="preview col-6 mb-3 mx-auto ">
                    <img src="" alt="image-preview" class="w-100 rounded-circle" id="imagePreview" style="aspect-ratio: 1/1;">
                  </div>
                </div>
                <div class="modal-footer" style="display: none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetDetailModalWrapper('changeAvatarModal')">Đóng</button>
                  <button type="submit" class="btn btn-primary" id="saveButton">Lưu thay đổi</button>
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
          <li class="nav__btn <?= isset($_GET['act']) ? '' : 'nav__btn-active' ?>"><a href="index.php?ctrl=profile" class="btn px-4 py-2 text-decoration-none fw-medium">Bài viết</a>
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
                  if ($getFriends !== null || !empty($getFriends)) {
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
                              <p class="fs-7 text-secondary"><?= $friend->countMatualFriend($user_id, $row['id']) ?> bạn chung</p>
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
            <!--Following friend-->
            <div id="follow" class="products" style="display: none;">
              <div class="container overflow-hidden text-center">
                <div class="row gy-1">
                  <?php
                  $getFollows = $follow->getAllFollow($id);
                  if ($getFollows !== null || !empty($getFollows)) {
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
                              <p class="fs-7 text-secondary"><?= $friend->countMatualFriend($user_id, $row['id']) ?> bạn chung</p>
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
              <div class="me-3">
                <p type="button" class="ms-3 me-3 text-secondary" onclick="showPicture()">Ảnh của bạn </p>
                <hr id="Picture_hr" class="border border-primary border-2 opacity-75">
              </div>
              <div class="me-4">
                <p type="button" class="text-secondary" onclick="showAvatar()">Ảnh đại diện </p>
                <hr id="Avatar_hr" class="border border-primary border-2 opacity-75" style="display:none">
              </div>
              <div class="">
                <p type="button" class="text-secondary" onclick="showCover()">Ảnh bìa</p>
                <hr id="Cover_hr" class="border border-primary border-2 opacity-75" style="display:none">
              </div>
            </div>

            <!-- List picture -->
            <!--Your picture-->
            <div id="Picture" class="products">
              <div class="container text-center">
                <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                  <!--picture 1-->
                  <div class="col" style="width: 158px; height: 158px;">
                    <div class="position-picture" style="width: 100%; height: 100%;">
                      <img src="./Public/images/avt.jpg" style="width: 100%; height: 100%; border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">
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

                  <!-- Modal -->
                  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="">
                        <div class="modal-body">
                          <img src="./Public/images/avt.jpg" class="img-fluid rounded" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Avatar-->
            <div id="Avatar" class="products" style="display: none;">
              <div class="container text-center">
                <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                  <!--picture 1-->
                  <div class="col" style="width: 158px; height: 158px;">
                    <div class="position-picture" style="width: 100%; height: 100%;">
                      <img src="./images/2.jpg" style="width: 100%; height: 100%; border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal1">
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

                  <!-- Modal -->
                  <div class="modal fade" id="imageModal1" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="">
                        <div class="modal-body">
                          <img src="./images/2.jpg" class="img-fluid rounded" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Cover image-->
            <div id="Cover" class="products" style="display: none;">
              <div class="container text-center">
                <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                  <!--picture 1-->
                  <div class="col" style="width: 158px; height: 158px;">
                    <div class="position-picture" style="width: 100%; height: 100%;">
                      <img src="./Public/images/avt.jpg" style="width: 100%; height: 100%; border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal2">
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

                  <!-- Modal -->
                  <div class="modal fade" id="imageModal2" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="">
                        <div class="modal-body">
                          <img src="./images/3.jpg" class="img-fluid rounded" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php break;
      }
    } else { ?>
      <div class="d-flex gap-3 w-100">
        <div class="d-none d-lg-flex flex-column gap-3 w-100" style="max-width: 426px;">
          <div class="profile-photos bg-white rounded-3 p-3 shadow-sm">
            <div class="pb-3 d-flex justify-content-between align-items-center">
              <h5><a href="index.php?ctrl=profile&act=photos&id=<?= $id ?>" class="fs-4 fw-bold text-dark text-decoration-none">Ảnh</a></h5>
              <a href="index.php?ctrl=profile&act=photos" class="text-decoration-none">Xem tất cả ảnh</a>
            </div>
            <div class="rounded-3 overflow-hidden d-flex flex-wrap" style="gap: 4px;">
              <?php
              $all_photo = $photo->getAllPhotoByUser($id);
              if ($all_photo && ($all_photo !== null)) {
                $count = 0;
                foreach ($all_photo as $image) {
                  echo '<img src="./Public/upload/' . $image . '" alt="" class="profile-img">';
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
              <!-- <div class="friend-item mb-2">
                <a href="#">
                  <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
                </a>
                <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                  <span>Khánh Duy</span>
                </a>
              </div> -->
            </div>
          </div>
        </div>
        <div class="bg-white rounded-3 shadow-sm" style="flex-basis: 680px; flex-shrink: 1; max-width: 680px"></div>
      </div>
    <?php } ?>
  </div>
</main>