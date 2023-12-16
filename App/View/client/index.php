<?php
@include_once './App/Models/PhotoModel.php';
@include_once './App/Models/UserModel.php';
@include_once './App/Models/FriendModel.php';
@include_once './App/Models/FollowModel.php';
@include_once './App/Models/ShareModel.php';
@include_once './App/Models/PostModel.php';
@include_once './App/Models/StoryModel.php';
@include_once './App/Models/CommentModel.php';
@include_once './App/Models/LikeModel.php';
@include_once './App/Models/NotificationModel.php';

@include_once './App/View/client/layout/header.php';

$controller = "home";
if (isset($_GET['ctrl']))
  $controller = $_GET['ctrl'];

switch ($controller) {
  case "home":
    include_once './App/View/client/page/home.php';
    break;
  case "stories":
    include_once './App/View/client/page/stories.php';
    break;
  case "friends":
    include_once './App/View/client/page/friend.php';
    break;
  case "profile":
    include_once './App/View/client/page/profile.php';
    break;
  case "setting":
    include_once './App/View/client/page/setting.php';
    break;
  case "messages":
    include_once './App/View/client/page/message.php';
    break;
  case "post":
    include_once './App/View/client/page/post.php';
    break;
  case "slider":
    include_once './App/View/client/page/slider_post.php';
    break;
  case "logout":
    unset($_SESSION['user']);
    header("location: index.php");
    exit;
    break;
  default:
    include_once './App/View/client/page/home.php';
    break;
}
