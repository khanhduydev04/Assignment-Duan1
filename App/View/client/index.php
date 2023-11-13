<?php
@include_once './App/View/client/layout/header.php';

$controller = "home";
if (isset($_GET['ctrl']))
  $controller = $_GET['ctrl'];

switch ($controller) {
  case "home":
    include_once './App/View/client/page/home.php';
    break;
  case "stories":
    include_once './Controllers/client/StoriesController.php';
    break;
  case "friends":
    include_once './Controllers/client/FriendController.php';
    break;
  case "profile":
    include_once './Controllers/client/ProfileController.php';
    break;
  case "forget_pass":
    include_once './View/client/page/forget_password.php';
    break;
  case "logout":
    unset($_SESSION['user']);
    header("location: index.php");
    exit;
    break;
  default:
    include_once './index.php';
    break;
}
