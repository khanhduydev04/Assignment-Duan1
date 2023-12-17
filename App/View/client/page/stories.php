<?php
$user_id = $_SESSION['user']['id'];
$user = new User();
$photo = new Photo();
?>
<main>
    <div class="container-fluid">
        <div class="row jusstify-contents-evenly" style="height: 100vh">
            <!--Sitebar-->
            <div class="col-12 col-lg-3 shadow-sm mb-5 bg-white" style="height: 100%">
                <div class="d-flex flex-row mb-3">
                    <a href="./home.html" class="p-2 me-3" style="width: 35px; height: 35px; object-fit: cover;">
                        <h1 class="fa-solid fa-circle-xmark text-secondary"></h1>
                    </a>
                    <div class="p-2 me-2" style="width: 35px; height: 35px; object-fit: cover;">
                        <h1 class="fa-brands fa-facebook text-primary "></h1>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h5 class="fw-bolder">Tin của bạn</h5>
                    </div>
                    <div class="">
                        <i class="fa-solid fa-gear rounded-circle me-2 p-2 bg-light"></i>
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div class="p-2">
                        <?php
                        if (($photo->getNewAvatarByUser($user_id) != null)) { ?>
                            <img src="./Public/upload/<?= $photo->getNewAvatarByUser($user_id) ?>" alt="avatar" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover" />
                        <?php } else { ?>
                            <img src="./Public/images/avt_default.png" alt="avatar" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover" />
                        <?php }
                        ?>
                    </div>
                    <div class="p-2 d-flex align-items-center">
                        <p class="m-0 fw-bold"><?= $user->getFullnameByUser($user_id) ?></p>
                    </div>
                </div>
                <?php
                $user = new User();
                $user_id = $_SESSION['user']['id'];;
                if (isset($_POST['createStory'])) {
                    $user_id = $_POST['user_id'];
                    $temp_image_path = $_FILES['imageName']['tmp_name'];
                    $original_image_name = $_FILES['imageName']['name'];
                    $new_image_path = 'Public/upload/' . $original_image_name;

                    if (move_uploaded_file($temp_image_path, $new_image_path)) {
                        // Nếu di chuyển file thành công, tiến hành thêm vào CSDL
                        $story = new Stories();
                        $addStory = $story->createStory($user_id, $original_image_name);

                        if ($addStory) {
                            // Nếu thêm thành công, hiển thị thông báo thành công
                            echo "<script>alert('Bạn đã thêm khoảnh khắc thành công.');</script>";
                        } else {
                            // Nếu có lỗi khi thêm vào CSDL, hiển thị thông báo lỗi
                            echo "<script>alert('Có lỗi xảy ra khi thêm khoảnh khắc.');</script>";
                        }
                    } else {
                        // Nếu di chuyển file thất bại, hiển thị thông báo lỗi
                        echo "<script>alert('Có lỗi xảy ra khi lưu ảnh.');</script>";
                    }
                }
                ?>
                <!--form button cần hiện cùng-->
                <form class="image-form buttom_image_story p-3 col-3 hidden" method="POST" enctype="multipart/form-data">
                    <img src="" alt="Form Preview" id="formPreview" name="StoriesImage" style="width: 40%; height: 90%;" hidden>
                    <input name="user_id" value="<?php echo $user_id ?>" hidden>
                    <input type="file" id="imageName" name="imageName" style="display: none;" hidden> <!-- Thêm thẻ input để lưu tên file ảnh -->
                    <button type="button" class="btn btn-secondary btn col-4 ms-1 me-3">Bỏ</button>
                    <button type="submit" class="btn btn-primary btn col-7" name="createStory">Chia sẻ lên tin</button>
                </form>
            </div>
            <!--Body-->
            <div class="col-12 col-lg-9 bg-gray" style="height: 100%">
                <div class="container-fluid d-flex align-items-center justify-content-center container_story" style="height:90%">
                    <div class="position-relative me-3">
                        <label for="uploadImage" class="image-container">
                            <i data-visualcompletion="css-img" class="x1ey2m1c xds687c x10l6tqk x17qophe x13vifvy" style="background-image: url('https://static.xx.fbcdn.net/rsrc.php/v3/yq/r/Zd_TxH-pOMv.png'); 
                                background-position: 0px 0px; background-size: auto; width: 220px; height: 330px; background-repeat: no-repeat; display: inline-block;">
                            </i>
                            <div class="position-absolute top-0 end-0 d-flex justify-content-center align-items-center" style="width:100%; height:100%">
                                <div class="text-center">
                                    <!-- Hình ảnh và văn bản mẫu -->
                                    <div class="d-flex justify-content-center align-items-center" style="width:100%">
                                        <p class="d-flex justify-content-center align-items-center bg-white rounded-circle shadow-sm" style="width: 35px; height: 35px">
                                            <i data-visualcompletion="css-img" class="x1b0d499 xep6ejk" style="background-image: url('https://static.xx.fbcdn.net/rsrc.php/v3/yN/r/F1QkOdJrVbL.png'); 
                                                background-position: 0px -436px; background-size: auto; width: 20px; height: 20px; background-repeat: no-repeat; display: inline-block;">
                                            </i>
                                        </p>
                                    </div>
                                    <!-- Text -->
                                    <p class="text-white">Tạo tin ảnh</p>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="uploadImage" class="image-input" style="display: none;" onchange="previewImage(this)">
                    </div>
                    <!-- Khung hiển thị xem trước -->
                    <div class="preview-container shadow-sm pt-3 pb-5 pe-3 ps-3 hidden">
                        <p class="fw-medium">Xem trước</p>
                        <div class="d-flex justify-content-center align-items-center bg-dark" style="width:100%; height: 100%;">
                            <img src="" alt="Preview" id="preview" class="" style="width: 40%; height: 90%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>