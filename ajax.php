<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

@include_once './App/Models/db.php';
@include_once './App/Models/FollowModel.php';
@include_once './App/Models/FriendModel.php';
@include_once './App/Models/UserModel.php';
@include_once './App/Models/PhotoModel.php';
@include_once './App/Models/ShareModel.php';
@include_once './App/Models/CommentModel.php';
@include_once './App/Models/PostModel.php';
@include_once './App/Models/LikeModel.php';
@include_once './App/Models/MessageModel.php';
@include_once './App/Models/NotificationModel.php';

$user = new User();
$friend = new Friend();
$follow = new Follow();
$photo = new Photo();
$share = new Share();
$cmt = new Comment();
$post = new Post();
$like = new Likes();
$message = new Message();
$notification = new Notification();


//handle live search
if (isset($_POST['search']) && $_POST['search'] != '') {
  $search_value = $_POST['search'];
  $output = '';
  $result = $user->searchUser($search_value);

  if ($result && $result !== null) {
    foreach ($result as $row) {
      $output .= '<li class="my-3">
      <a href="index.php?ctrl=profile&user_id=' . $row['id'] . '" class="text-decoration-none text-dark">
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
//handle comment post
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

$all_post = $post->getAllPostByUser($_SESSION['user']['id']);
$user_post_id = [];
foreach ($all_post as $user_post) {
  $user_post_id[] = $user_post['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Xử lý thêm bình luận vào cơ sở dữ liệu
  if (isset($_POST['parentId']) && isset($_POST['postId']) && isset($_POST['content'])) {
    $parent_id = $_POST['parentId'];
    $post_id = $_POST['postId'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['id'];

    // insert comment vào csdl
    $result = $cmt->insertComment($content, $parent_id, $user_id, $post_id);
    if (!$result) {
      echo 'Không thể thêm mới comment';
    } else {
      if (!in_array($post_id, $user_post_id)) {
        $noti_name = $user->getFullnameByUser($user_id);
        $noti_content = "$noti_name đã bình luận về bài viết của bạn";
        $noti_href = "index.php?ctrl=post&post_id=$post_id";
        $noti_user_id = $post->getPostById($post_id);
        $notification->insertNotification($noti_content, $noti_href, $noti_user_id['user_id']);
      }
      if ($parent_id !== 0) {
        $noti_name = $user->getFullnameByUser($user_id);
        $noti_content = "$noti_name đã trả lời bình luận của bạn";
        $noti_href = "index.php?ctrl=post&post_id=$post_id";
        $noti_user_id = $comment->getUserCommentId($result[1]);
        $notification->insertNotification($noti_content, $noti_href, $noti_user_id['user_id']);
      }
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Kiểm tra xem có tham số post_id được truyền không
  if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    // Lấy danh sách bình luận và hiển thị bằng đệ quy
    $comments = getComments($post_id, 0, 0, 2);
    displayComments($comments);
  }
}

function getComments($post_id, $parent_id = 0, $depth = 0, $maxDepth = 2)
{
  if ($depth > $maxDepth) {
    $depth = $maxDepth; // Gán độ sâu là giá trị tối đa nếu vượt quá
  }
  global $cmt;
  $result = $cmt->getCommentByPost($post_id, $parent_id);
  $comments = [];

  foreach ($result as $row) {
    $row['replies'] = getComments($post_id, $row['id'], $depth + 1, $maxDepth);
    $comments[] = $row;
  }
  return $comments;
}

function displayComment($comment, $depth = 0)
{
  global $photo;
  global $user; ?>

  <div class="comment-item d-flex gap-2 mb-3">
    <!-- avatar acount -->
    <div class="cmt-avatar flex-grow-1" style="width: 32px; height: 32px;">
      <?php
      if (($photo->getNewAvatarByUser($comment['user_id']) != null)) { ?>
        <img src="./Public/upload/<?= $photo->getNewAvatarByUser($comment['user_id']) ?>" alt="" class="w-100 h-100 rounded-circle object-fit-cover">
      <?php } else { ?>
        <img src="./Public/images/avt_default.png" alt="" class="w-100 h-100 rounded-circle object-fit-cover">
      <?php }
      ?>
    </div>
    <!-- content and reply form -->
    <div class="comment-detail d-flex flex-column gap-1" style="width: calc(100% - (32px + 8px));">
      <div class="rounded-4 p-2" style="background-color: #f2f0f5;width: max-content; max-width: 100%;">
        <p class="fw-semibold mb-0" style="margin-bottom: 2px;"><?= $user->getFullnameByUser($comment['user_id']) ?></p>
        <p class="comment-content mb-0"><?= $comment['content'] ?></p>
      </div>
      <div class="d-flex gap-3 fs-7">
        <span class="text-secondary"><?= calculateTimeAgo($comment['created_at']) ?></span>
        <span class="btn-reply fw-semibold" style="cursor: pointer;">Phản hồi</span>
      </div>
      <div class="reply-form">
        <div class="d-flex mt-2">
          <?php
          if (($photo->getNewAvatarByUser($_SESSION['user']['id']) != null)) { ?>
            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($_SESSION['user']['id']) ?>" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;">
          <?php } else { ?>
            <img src="./Public/images/avt_default.png" alt="" class="rounded-circle object-fit-cover me-2" style="width: 32px; height: 32px;">
          <?php }
          ?>
          <form action="" method="post" class="cmt-form flex-grow-1 position-relative d-flex">
            <input type="hidden" name="parentId" value="<?= $comment['id'] ?>">
            <input type="hidden" name="postId" value="<?= $comment['post_id'] ?>">
            <textarea name="content" id="form-reply" cols="30" rows="10" class="form-control"></textarea>
            <button type="submit" class="border-0 bg-transparent ms-1">
              <i class="fa-solid fa-paper-plane text-primary"></i>
            </button>
          </form>
        </div>
      </div>
      <?php foreach ($comment['replies'] as $reply) {
        if ($depth == 2) {
          echo '</div>';
          echo '</div>';
          // Hiển thị cùng cấp với cấp 3
          displayComment($reply, $depth);
        } else {
          echo '<div class="sub-comment-list mt-2">';
          displayComment($reply, $depth + ($depth == 2 ? 0 : 1)); // Không tăng depth nếu là cấp 3
          echo '</div>';
        }
      }
      ?>
    </div>
  </div>
<?php }

function displayComments($comments)
{
  foreach ($comments as $comment) {
    if ($comment['parent_id'] == 0) {
      displayComment($comment);
    }
  }
}
?>

<?php
// Thực hiện xử lý yêu cầu từ phía client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Kiểm tra xem dữ liệu post_id, user_id và action có được gửi không
  if (isset($_POST['action']) && isset($_POST['post_id']) && isset($_POST['user_id'])) {
    $action = $_POST['action'];
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // Tiến hành xử lý yêu cầu thích hoặc bỏ thích dựa trên action gửi từ client
    if ($action === 'like') {
      $response = $like->like($user_id, $post_id);
      if ($response[0]) {
        if (!in_array($post_id, $user_post_id)) {
          $noti_name = $user->getFullnameByUser($user_id);
          $noti_content = "$noti_name đã yêu thích bài viết của bạn";
          $noti_href = "index.php?ctrl=post&post_id=$post_id";
          $noti_user_id = $post->getPostById($post_id);
          $notification->insertNotification($noti_content, $noti_href, $noti_user_id['user_id']);
        }
      }
    } else {
      $response = $like->unlike($user_id, $post_id);
    }

    // Sau khi xử lý, trả về số lượt thích mới để cập nhật trên giao diện client
    $updated_likes = $like->countPhotoByLike($post_id);
    echo $updated_likes ? $updated_likes . ' lượt thích' : '0 lượt thích';
  }
}
?>

<?php
if (isset($_POST['action']) && $_POST['action'] == 'fetch_chat') {
  $user_id1 = $_POST['form_user_id'];
  $user_id2 = $_POST['to_user_id'];

  echo json_encode($message->getChat($user_id1, $user_id2));
}
?>