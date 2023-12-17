<?php
$photo = new Photo();
$user = new User();
$notification = new Notification();
?>
<!-- header -->
<header class="header bg-white d-flex align-items-center fixed-top shadow-sm" style="min-height: 56px; z-index: 999">
  <div class="container-fluid">
    <div class="row align-items-center">
      <!-- search -->
      <div class="col d-flex align-items-center">
        <!-- header logo -->
        <a href="index.php" class="d-block overflow-hidden rounded-circle" style="width: 2.5rem">
          <img src="./Public/images/beebook-logo.png" alt="Logo Beebook" class="object-fit-cover w-100">
        </a>
        <!-- search bar -->
        <div class="input-group ms-2" type="button">
          <!-- mobile -->
          <span class="input-group-prepend d-lg-none" id="searchMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <div class="input-group-text bg-gray border-0 rounded-circle" style="min-height: 40px">
              <i class="fas fa-search text-muted"></i>
            </div>
          </span>
          <!-- desktop -->
          <span class="input-group-prepend d-none d-lg-flex position-relative border-0 rounded-pill bg-gray overflow-hidden" style="min-height: 40px; min-width: 230px" id="searchMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <div class="d-lg-flex align-items-center bg-gray ps-3">
              <i class="fas fa-search"></i>
            </div>
            <input type="text" class="form-control search-input bg-gray rounded-pill border-0 h-100" placeholder="Tìm kiếm BeeSocial" id="search-input">
          </span>
          <!-- search menu -->
          <ul class="dropdown-menu overflow-auto border-0 shadow p-3" aria-labelledby="searchMenu" style="width: 18em; max-height: 400px">
            <!-- search input -->
            <li class="d-lg-none">
              <form action="" method="post">
                <input type="text" class="rounded-pill border-0 bg-gray dropdown-item" placeholder="Tìm kiếm..." autofocus id="search-input" />
              </form>
            </li>
            <div id="search-data"></div>
          </ul>
        </div>
      </div>
      <!-- nav -->
      <nav class="col d-none d-xl-flex justify-content-center">
        <!-- home -->
        <div class="mx-1 nav__btn <?= isset($_GET['ctrl']) ? '' : 'nav__btn-active' ?>">
          <a href="index.php" class="btn px-5">
            <i class="fas fa-home text-muted fs-4"></i>
          </a>
        </div>
        <!-- friend -->
        <div class="mx-1 nav__btn <?= (isset($_GET['ctrl']) && $_GET['ctrl'] == 'friends') ? 'nav__btn-active' : '' ?>">
          <a href="index.php?ctrl=friends" class="btn px-5">
            <i class="fa-solid fa-user-group  text-muted fs-4"></i>
          </a>
        </div>
        <!-- account -->
        <div class="mx-1 nav__btn <?= (isset($_GET['ctrl']) && $_GET['ctrl'] == 'profile' && !isset($_GET['user_id'])) ? 'nav__btn-active' : '' ?>">
          <a href="index.php?ctrl=profile" class="btn px-5">
            <i class="fa-solid fa-circle-user text-muted fs-4"></i>
          </a>
        </div>
        <!-- setting -->
        <div class="mx-1 nav__btn <?= (isset($_GET['ctrl']) && $_GET['ctrl'] == 'setting') ? 'nav__btn-active' : '' ?>">
          <a href="index.php?ctrl=setting" class="btn px-5">
            <i class="fa-solid fa-gear text-muted fs-4"></i>
          </a>
        </div>
      </nav>
      <!-- menus -->
      <div class="col d-flex align-items-center justify-content-end">
        <!-- chat -->
        <a class="rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center mx-2" style="width: 38px; height: 38px" type="button" id="chatMenu" href="index.php?ctrl=messages">
          <i class="fas fa-comment text-dark"></i>
        </a>
        <!-- notifications -->
        <div class=" rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center mx-2" style="width: 38px; height: 38px" type="button" id="notMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
          <i class="fas fa-bell"></i>
        </div>
        <!-- notifications dd -->
        <ul class="dropdown-menu border-0 shadow p-3" id="notification" aria-labelledby="notMenu" style="width: 21em; max-height: 500px; overflow-y: auto">
          <!-- header -->
          <li class="p-1">
            <div class="d-flex justify-content-between">
              <h2 class="fs-4">Thông báo</h2>
            </div>
          </li>
          <?php
          $user_noti = $notification->getNotifications($_SESSION['user']['id']);
          foreach ($user_noti as $noti_item) { ?>
            <li class="px-2 py-3 rounded-2 noti-item"><a href="<?= $noti_item['href'] ?>" class="text-dark"><?= $noti_item['content'] ?></a></li>
          <?php }
          ?>
        </ul>
        <!-- secondary menu -->
        <div class="align-items-center justify-content-center d-xl-flex mx-2" type="button" id="secondMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
          <?php
          if (isset($_SESSION['user']['id']) && ($photo->getNewAvatarByUser($_SESSION['user']['id']) != null)) { ?>
            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($_SESSION['user']['id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />
          <?php } else { ?>
            <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />
          <?php }
          ?>
        </div>
        <!-- secondary menu dd -->
        <ul class="dropdown-menu border-0 shadow p-3" aria-labelledby="secondMenu" style="width: 21em">
          <!-- avatar -->
          <li type="button">
            <a href="index.php?ctrl=profile" class="dropdown-item p-1 rounded d-flex align-items-center">
              <?php
              if (isset($_SESSION['user']['id']) && ($photo->getNewAvatarByUser($_SESSION['user']['id']) != null)) { ?>
                <img src="./Public/upload/<?= $photo->getNewAvatarByUser($_SESSION['user']['id']) ?>" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />
              <?php } else { ?>
                <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />
              <?php }
              ?>
              <p class="m-0 fw-semibold"><?= $user->getFullnameByUser($_SESSION['user']['id']) ?></p>
            </a>
          </li>
          <hr>
          <!-- options -->
          <!-- 1 -->
          <li class="dropdown-item p-1 my-3 rounded" type="button">
            <ul class="navbar-nav">
              <li class="nav-item">
                <div class="d-flex" data-bs-toggle="dropdown">
                  <i class="fas fa-cog bg-gray p-2 rounded-circle"></i>
                  <div class="ms-3 d-flex justify-content-between align-items-center w-100">
                    <p class="m-0">Cài đặt</p>
                    <i class="fas fa-chevron-right"></i>
                  </div>
                </div>
                <!-- nested menu -->
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="index.php?ctrl=setting">
                      <div class="rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px">
                        <i class="fas fa-newspaper"></i>
                      </div>
                      <p class="m-0">Thông tin cá nhân</p>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="index.php?ctrl=setting&act=change_password">
                      <div class="rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px">
                        <i class="fas fa-lock"></i>
                      </div>
                      <p class="m-0">Mật khẩu và bảo mật</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- 2 -->
          <li class="dropdown-item p-1 my-3 rounded" type="button">
            <ul class="navbar-nav">
              <li class="nav-item">
                <div class="d-flex">
                  <i class="fas fa-moon bg-gray p-2 rounded-circle" style="width: 32px; height: 32px;"></i>
                  <div class="ms-3 d-flex justify-content-between align-items-center w-100">
                    <p class="m-0">Chế độ hiển thị</p>
                  </div>
                </div>
              </li>
            </ul>
          </li>
          <!-- 3 -->
          <li class="dropdown-item p-1 my-3 rounded" type="button">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="index.php?ctrl=logout" class="d-flex text-decoration-none text-dark">
                  <i class="fas fa-cog bg-gray p-2 rounded-circle"></i>
                  <div class="ms-3 d-flex justify-content-between align-items-center w-100">
                    <p class="m-0">Đăng xuất</p>
                  </div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- end -->
      </div>
    </div>
  </div>
</header>
<!-- chat popup items -->
<!-- chat 1 -->
<div class="modal fade" id="singleChat1" tabindex="-1" aria-labelledby="singleChat1Label" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog modal-sm position-absolute bottom-0 end-0 w-17" style="transform: translateX(-80px)">
    <div class="modal-content border-0 shadow">
      <!-- head -->
      <div class="modal-header">
        <div class="dropdown-item d-flex rounded" type="button" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-html="true">
          <!-- avatar -->
          <div class="position-relative">
            <img src="https://source.unsplash.com/random/1" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
            <span class="position-absolute bottom-0 translate-middle p-1 bg-success border border-light rounded-circle" style="left: 75%">
              <span class="visually-hidden">New alerts</span>
            </span>
          </div>
          <!-- name -->
          <div>
            <p class="m-0">Mike <i class="fas fa-angle-down"></i></p>
            <span class="text-muted fs-7">Active Now</span>
          </div>
        </div>
        <!-- close -->
        <i class="fas fa-video mx-2 text-muted pointer"></i>
        <i class="fas fa-phone-alt mx-2 text-muted pointer"></i>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- body -->
      <div class="modal-body p-0 overflow-auto" style="max-height: 300px">
        <!-- message l -->
        <li class="list-group-item border-0 d-flex">
          <!-- avatar -->
          <div>
            <img src="https://source.unsplash.com/random/1" alt="avatar" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover" />
          </div>
          <!-- message -->
          <p class="bg-gray p-2 rounded">Lorem, ipsum dolor</p>
        </li>
        <!-- message r -->
        <li class="list-group-item border-0 d-flex justify-content-end">
          <!-- message -->
          <p class="bg-gray p-2 rounded">Lorem, ipsum dolor</p>
          <!-- avatar -->
          <div>
            <img src="https://source.unsplash.com/collection/happy-people" alt="avatar" class="rounded-circle ms-2" style="width: 28px; height: 28px; object-fit: cover" />
          </div>
        </li>
        <!-- message l -->
        <li class="list-group-item border-0 d-flex">
          <!-- avatar -->
          <div>
            <img src="https://source.unsplash.com/random/1" alt="avatar" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover" />
          </div>
          <!-- message -->
          <p class="bg-gray p-2 rounded">Lorem, ipsum dolor</p>
        </li>
        <!-- message r -->
        <li class="list-group-item border-0 d-flex justify-content-end">
          <!-- message -->
          <p class="bg-gray p-2 rounded">Lorem, ipsum dolor</p>
          <!-- avatar -->
          <div>
            <img src="https://source.unsplash.com/collection/happy-people" alt="avatar" class="rounded-circle ms-2" style="width: 28px; height: 28px; object-fit: cover" />
          </div>
        </li>
        <!-- message l -->
        <li class="list-group-item border-0 d-flex">
          <!-- avatar -->
          <div>
            <img src="https://source.unsplash.com/random/1" alt="avatar" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover" />
          </div>
          <!-- message -->
          <p class="bg-gray p-2 rounded">Lorem, ipsum dolor</p>
        </li>
        <!-- message r -->
        <li class="list-group-item border-0 d-flex justify-content-end">
          <!-- message -->
          <p class="bg-gray p-2 rounded">Lorem, ipsum dolor</p>
          <!-- avatar -->
          <div>
            <img src="https://source.unsplash.com/collection/happy-people" alt="avatar" class="rounded-circle ms-2" style="width: 28px; height: 28px; object-fit: cover" />
          </div>
        </li>
      </div>
      <!-- message input -->
      <div class="modal-footer p-0 m-0 border-0">
        <div class="d-flex">
          <div class="d-flex align-items-center">
            <i class="fas fa-plus-circle mx-1 fs-5 text-muted pointer"></i>
            <i class="far fa-file-image mx-1 fs-5 text-muted pointer"></i>
            <i class="fas fa-portrait mx-1 fs-5 text-muted pointer"></i>
            <i class="fas fa-adjust mx-1 fs-5 text-muted pointer"></i>
          </div>
          <div>
            <input type="text" class="form-control rounded-pill border-0 bg-gray" placeholder="Aa" />
          </div>
          <div class="d-flex align-items-center mx-2">
            <i class="fas fa-thumbs-up fs-5 text-muted pointer"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    //search
    $("#search-input").on("keyup", function() {
      var search_term = $(this).val();
      $.ajax({
        url: "ajax.php",
        type: "POST",
        data: {
          search: search_term
        },
        success: function(data) {
          $("#search-data").html(data);
        }
      });
    });
  });
</script>