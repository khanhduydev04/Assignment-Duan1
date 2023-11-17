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
    include_once './App/Controllers/client/StoriesController.php';
    break;
  case "friends":
    include_once './App/View/client/page/friend.php';
    break;
  case "profile":
    include_once './App/View/client/page/profile.php';
    break;
  case "information":
    include_once './App/View/client/page/setting.php';
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
