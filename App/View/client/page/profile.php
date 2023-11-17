<main>
  <div class="pt-5 bg-white w-100 d-flex justify-content-center shadow-sm">
    <div class="profile d-flex flex-column align-items-center">
      <div class="profile-cover d-flex justify-content-center position-relative w-100">
        <img src="./Public/images/banner-men.png" alt="" id="image-cover" class="w-100 rounded-3">
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
          <img src="./Public/images/avt.jpg" alt="" id="avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;">
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
            <h3 class="fs-3 fw-bold mb-1">Khánh Duy</h3>
            <a href="#" class="text-secondary fw-medium text-decoration-none">200 bạn bè</a>
          </div>
          <div class="profile-action">
            <form action="">
              <!-- add friend button -->
              <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fa-solid fa-user-plus" style="color: #ffffff; font-size: 18px;"></i>
                <span>Thêm bạn bè</span>
              </button>
              <!-- cancel request button -->
              <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 d-none">
                <i class="fa-solid fa-user-xmark" style="color: #ffffff; font-size: 18px;"></i>
                <span>Hủy lời mời</span>
              </button>
              <!-- dropdown friend -->
              <div class="dropdown d-none">
                <button class="btn btn-secondary border-0 text-dark dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #E4E6EB;">
                  <i class="fa-solid fa-user-check" style="color: #17191c;"></i>
                  <span>Bạn bè</span>
                </button>
                <ul class="dropdown-menu">
                  <li><button type="submit" class="dropdown-item">Bỏ theo dõi</button></li>
                  <li><button type="submit" class="dropdown-item">Hủy bạn bè</button></li>
                </ul>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="main-container w-100%">
        <ul class="m-0 py-2 d-flex align-items-center gap-1 list-unstyled" style="height: 60px;">
          <li class="nav__btn nav__btn-active"><a href="#" class="btn px-4 py-2 text-decoration-none fw-medium">Bài
              viết</a>
          </li>
          <li class="nav__btn"><a href="#" class="btn px-4 py-2 text-decoration-none fw-medium">Bạn bè</a>
          </li>
          <li class="nav__btn"><a href="#" class="btn px-4 py-2 text-decoration-none fw-medium">Ảnh</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="main-container mx-auto mt-3">
    <div class="d-flex gap-3 w-100">
      <div class="d-none d-lg-flex flex-column gap-3" style="max-width: 426px;">
        <div class="profile-photos bg-white rounded-3 p-3 shadow-sm">
          <div class="pb-3 d-flex justify-content-between align-items-center">
            <h5><a href="index.php?ctrl=profile&act=photos" class="fs-4 fw-bold text-dark text-decoration-none">Ảnh</a></h5>
            <a href="index.php?ctrl=profile&act=photos" class="text-decoration-none">Xem tất cả ảnh</a>
          </div>
          <div class="rounded-3 overflow-hidden d-flex flex-wrap" style="gap: 4px;">
            <img src="./Public/images/banner-men.png" alt="" class="profile-img">
            <img src="./Public/images/banner-men.png" alt="" class="profile-img">
            <img src="./Public/images/banner-men.png" alt="" class="profile-img">
            <img src="./Public/images/banner-men.png" alt="" class="profile-img">
            <img src="./Public/images/banner-men.png" alt="" class="profile-img">
          </div>
        </div>
        <div class="profile-friends bg-white rounded-3 p-3 shadow-sm">
          <div class="pb-3 d-flex justify-content-between align-items-center">
            <h5><a href="index.php?ctrl=profile&act=friends" class="fs-4 fw-bold text-dark text-decoration-none">Bạn bè</a></h5>
            <a href="index.php?ctrl=profile&act=friends" class="text-decoration-none">Xem tất cả bạn bè</a>
          </div>
          <div class="d-flex flex-wrap" style="column-gap: 8px;">
            <div class="friend-item mb-2">
              <a href="#">
                <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
              </a>
              <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                <span>Khánh Duy</span>
              </a>
            </div>
            <div class="friend-item mb-2">
              <a href="#">
                <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
              </a>
              <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                <span>Khánh Duy</span>
              </a>
            </div>
            <div class="friend-item mb-2">
              <a href="#">
                <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
              </a>
              <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                <span>Khánh Duy</span>
              </a>
            </div>
            <div class="friend-item mb-2">
              <a href="#">
                <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
              </a>
              <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                <span>Khánh Duy</span>
              </a>
            </div>
            <div class="friend-item mb-2">
              <a href="#">
                <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
              </a>
              <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                <span>Khánh Duy</span>
              </a>
            </div>
            <div class="friend-item mb-2">
              <a href="#">
                <img src="./Public/images/banner-men.png" alt="" class="friend-image w-100 object-fit-cover rounded-2">
              </a>
              <a href="#" class="mt-1 d-flex flex-column text-decoration-none text-dark fw-semibold">
                <span>Khánh Duy</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-3 shadow-sm" style="flex-basis: 680px; flex-shrink: 1; max-width: 680px"></div>
    </div>
  </div>
</main>