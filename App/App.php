<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

@require './App/Models/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="./Public/images/beebook-logo.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./Public/css/global.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./Public/css/main.css?v=<?php echo time(); ?>">
  <title>Beebook</title>
</head>

<body>

  <?php
  if (isset($_GET['ctrl']) && $_GET['ctrl'] == 'forgetpassword') {
    include_once './App/Models/UserModel.php';
    @include_once './lib/PHPMailer-master/index.php';
    include_once './App/View/client/page/forget_password.php';
  } else {
    if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 'user')) {
      @include_once './App/View/client/index.php';
    } elseif (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 'admin')) {
      @include_once './App/View/admin/index.php';
    } else {
      include_once './App/Models/UserModel.php';
      include_once './App/View/client/layout/signin.php';
    }
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Thư viện jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="./Public/js/main.js?v=<?php echo time(); ?>"></script>
  <script src="./Public/js/stories.js?v=<?php echo time(); ?>"></script>
</body>

</html>