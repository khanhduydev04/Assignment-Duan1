<?php
@include_once './App/Models/db.php';
@include_once './App/Models/FollowModel.php';
@include_once './App/Models/FriendModel.php';
@include_once './App/Models/UserModel.php';
@include_once './App/Models/PhotoModel.php';
@include_once './App/Models/ShareModel.php';

$user = new User();
$friend = new Friend();
$follow = new Follow();
$photo = new Photo();
$share = new Share();

//handel live search
if (isset($_POST['search']) && $_POST['search'] != '') {
  $search_value = $_POST['search'];
  $output = '';
  $result = $user->searchUser($search_value);

  if ($result && $result !== null) {
    foreach ($result as $row) {
      $output .= '<li class="my-3">
      <a href="index.php?ctrl=profile&id=' . $row['id'] . '" class="text-decoration-none text-dark">
          <div class="alert fade show dropdown-item p-1 m-0 d-flex align-items-center justify-content-between" role="alert">
              <div class="d-flex align-items-center">';
      // Kiểm tra avatar user
      if ($photo->getNewAvatarByUser($row['id']) !== null) {
        $output .= '<img src="./Public/upload/' . $photo->getNewAvatarByUser($row['id']) . '" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />';
      } else {
        $output .= '<img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />';
      }
      $output .= '<p class="m-0">' . $row['first_name'] . ' ' . $row['last_name'] . '</p>
              </div>
              <button type="button" class="btn-close p-0 m-0" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </a>
      </li>';
    }
    echo $output;
  } else {
    echo '<p class="text-dark fw-semibold text-center">Không tìm thấy kết quả</p>';
  }
}
