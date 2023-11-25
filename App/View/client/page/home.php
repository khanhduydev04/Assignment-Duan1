<main class="bg-gray postion-relative">
  <!-- ================= Main ================= -->
  <div class="container-fluid">
    <div class="row justify-content-evenly">
      <!-- ================= Sidebar ================= -->
      <div class="col-12 col-lg-3">
        <div class="d-none d-xxl-block h-100 fixed-top overflow-hidden" style="max-width: 360px; width:100%; z-index: 4;">
          <ul class="navber-nav mt-4 ms-3 d-flex flex-column pb-5 mb-5" style="padding-top: 56px;">
            <!--Top-->
            <!--Avatar-->
            <li class="dropdown-item p-1 rounded">
              <a href="index.php?ctrl=profile" class="text-decoration-none text-dark d-flex align-items-center">
                <div class="p-2">
                  <img src="./Public/images/avt.jpg" alt="avata" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover;">
                </div>
                <div class="">
                  <p class="m-0">Hồ Dư Mai Trân</p>
                </div>
              </a>
            </li>
            <!--Friends-->
            <li class="dropdown-item p-1 rounded">
              <a href="" class="text-decoration-none text-dark d-flex align-items-center">
                <div class="p-2">
                  <i data-visualcompletion="css-img" class="" style="background-image:url('https://static.xx.fbcdn.net/rsrc.php/v3/yz/r/4GR4KRf3hN2.png');background-position:0 -296px;background-size:auto;width:36px;height:36px;background-repeat:no-repeat;display:inline-block"></i>
                </div>
                <div class="">
                  <p class="m-0">Bạn bè</p>
                </div>
              </a>
            </li>
            <!--Team-->
            <!-- <li class="dropdown-item p-1 rounded">
              <a href="" class="text-decoration-none text-dark d-flex align-items-center">
                <div class="p-2">
                  <i data-visualcompletion="css-img" class="" style="background-image:url('https://static.xx.fbcdn.net/rsrc.php/v3/yz/r/4GR4KRf3hN2.png');background-position:0 -37px;background-size:auto;width:36px;height:36px;background-repeat:no-repeat;display:inline-block"></i>
                </div>
                <div class="">
                  <p class="m-0">Nhóm</p>
                </div>
              </a>
            </li> -->
            <!--See more-->
            <li class="p-1" type="button">
              <div class="accordion" id="accordionExample">
                <div>
                  <div class="accordion-header">
                    <div class="d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="flase" aria-controls="collapseOne">
                      <div class="p-2">
                        <i class="fas fa-chevron-down rounded-circle p-2" style="background-color: #d5d5d5 !important;"></i>
                      </div>
                      <div>
                        <p class="m-0">Xem thêm</p>
                      </div>
                    </div>
                  </div>
                  <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>Xin chào bạn!</strong> tiện ích đang đợi cập nhật thêm. Cảm ơn bạn đã quan tâm!
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <!--Shortcut-->
          </ul>
        </div>
      </div>
      <!-- ================= Timeline ================= -->
      <div class="col-12 col-lg-6 ">
        <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 56px; max-width: 680px">
          <!-- stories -->
          <div class="stories-container">
            <div class="content">
              <div class="previous-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </div>
              <div class="stories">
                <a href="./upload_story.html" class="story">
                  <img src="./Public/images/avt.jpg" alt="" class="position-relative">
                  <div class="author_add">Thêm tin</div>
                  <h3 class=" author_plus">
                    <i class="fa-solid fa-plus hdh"></i>
                  </h3>
                </a>
              </div>
              <div class="next-btn active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </div>
            </div>
          </div>
          <div class="stories-full-view">
            <div class="close-btn">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>

            <div class="content">
              <div class="previous-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </div>
              <div class="story">
                <img src="images/3.jpg" alt="" />
                <div class="author">Author</div>
              </div>

              <div class="next-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </div>
            </div>
          </div>
          <!-- create post -->
          <div class="bg-white p-3 mt-3 rounded border shadow-sm">
            <!-- avatar -->
            <div class="d-flex" type="button">
              <div class="p-1">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
              </div>
              <button type="button" class="ps-3 rounded-pill border-0 bg-gray pointer w-100 text-start" data-bs-toggle="modal" data-bs-target="#createPostModal">
                Bạn đang nghĩ gì?
              </button>
            </div>
            <!-- create modal -->
            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true" data-bs-backdrop="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <form action="">
                    <!-- head -->
                    <div class="modal-header align-items-center">
                      <h5 class="text-dark text-center w-100 m-0 fw-bold" id="exampleModalLabel">
                        Tạo bài viết
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- body -->
                    <div class="modal-body">
                      <div class="my-1 p-1">
                        <div class="d-flex flex-column">
                          <!-- name -->
                          <div class="d-flex align-items-center mb-2">
                            <div class="p-2">
                              <img src="https://source.unsplash.com/collection/happy-people" alt="from fb" class="rounded-circle" style=" width: 38px; height: 38px; object-fit: cover;" />
                            </div>
                            <div>
                              <p class="m-0 fw-bold">John</p>
                            </div>
                          </div>
                          <!-- text -->
                          <div>
                            <textarea cols="30" rows="5" class="form-control border-0" autofocus style="box-shadow: none;"></textarea>
                          </div>
                          <!-- upload image -->
                          <div>
                            <label class="d-flex justify-content-between border border-1 border-primary rounded p-2 mt-3" for="postImage">
                              <p class="m-0">Thêm hình ảnh vào bài viết</p>
                              <i class="fas fa-images fs-5 text-success pointer mx-1"></i>
                            </label>
                            <input type="file" name="photo[]" id="postImage" hidden>
                          </div>
                        </div>
                      </div>
                      <!-- end -->
                    </div>
                    <!-- footer -->
                    <div class="modal-footer">
                      <button type="submit" name="post" class="btn btn-primary w-100">
                        Đăng
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <hr />
            <!-- actions -->
            <div class="d-flex flex-column flex-lg-row mt-3">
              <!-- a 1 -->
              <div class="dropdown-item rounded d-flex align-items-center justify-content-center" type="button">
                <i class="fas fa-video me-2 text-danger"></i>
                <p class="m-0 text-muted">Live Video</p>
              </div>
              <!-- a 2 -->
              <div class="dropdown-item rounded d-flex align-items-center justify-content-center" type="button">
                <i class="fas fa-photo-video me-2 text-success"></i>
                <p class="m-0 text-muted">Photo/Video</p>
              </div>
              <!-- a 3 -->
              <div class="dropdown-item rounded d-flex align-items-center justify-content-center" type="button">
                <i class="fas fa-smile me-2 text-warning"></i>
                <p class="m-0 text-muted">Feeling/Activity</p>
              </div>
            </div>
          </div>
         <!-- posts -->
         <div class="bg-white p-4 rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between">
              <!-- avatar -->
              <div class="d-flex">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <div>
                  <p class="m-0 fw-bold">Hồ Dư Mai Trân</p>
                  <span class="text-muted fs-7">18 giờ</span>
                </div>
              </div>
              <!-- edit -->
              <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <!-- edit menu -->
              <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Chỉnh sửa bài viết</a>
                </li>
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Xóa bài viết</a>
                </li>
              </ul>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <div>
                <p>
                  Ngày ấy ta tìm thấy anh giữa biển người
                  Hôm nay em trả anh về với biển người ấy
                </p>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative">
                <!-- likes -->
                <div class="
                        d-flex
                        align-items-center
                        top-0
                        start-0
                        position-absolute
                      " style="height: 50px; z-index: 5">
                    <div class="me-2">
                      <i class="fa-solid fa-heart text-danger"></i>
                    </div>
                    <p class="m-0 text-muted fs-7">Phu, Tuan, and 3 người khác</p>
                    
                </div>
                <!-- comments start-->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0">
                    <!-- comment collapse -->
                    <h2 class="accordion-header" id="heading">
                      <div class="
                              accordion-button
                              collapsed
                              pointer
                              d-flex
                              justify-content-end
                            " >
                        <p class="m-0 fs-7" data-bs-toggle="collapse" data-bs-target="#collapsePost" aria-expanded="false" aria-controls="collapsePost">2 bình luận</p>
                        <p class="m-0 ms-2 fs-7">4 lượt chia sẻ</p>
                      </div>    
                    </h2>
                    <hr class="mt-0 mb-3"/>
                    
                    
                    <!-- comment & like bar -->
                    <div class="d-flex justify-content-around">
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                              hover_like
                            ">
                            <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted hover_like p-2" >
                                <i class="fa-regular fa-heart me-3" style="color: #000000;"></i>
                                <p class="m-0">Yêu thích</p>
                            </div>
                      </div>
                      
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                            "
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePost"
                          aria-expanded="false"
                          aria-controls="collapsePost"> 

                        <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                        <p class="m-0">Bình luận</p>
                      </div>
                      <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                         
                          ">
                        <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                        <p class="m-0">Chia sẻ</p>
                      </div>
                    </div>


                    <!-- comment model -->
                      <div
                        id="collapsePost"
                        class="accordion-collapse collapse"
                        aria-labelledby="heading"
                        data-bs-parent="#accordionExample">
                        <hr/>
                        <div class="accordion-body">
                          <!-- comment 1 -->
                          <div class="comment-container">
                            <div class="">
                              <div class="d-flex" onclick="showComment(1)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                  />
                                <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4 bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo ugyftdreeeeeeeeeeeeeeeeeeeeeegggggggggggggggggggggggggggggrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row ">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm(1)" style="cursor: pointer;" >Phản hồi</div>
                                    </div>
                                  </div>
                              </div>
                              <!--repcomment comments 1-->
                              <div class="mb-3" id="repcomment1" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse ms-1 me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>

                            <!--comments 2-->
                            <div class="ms-5">
                              <div class="d-flex my-1 " onclick="showComment(2)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2 mt-1"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                />
                                <!-- comment text -->
                                <div class="">
                                  <div class="p-2 rounded-4 bg-gray">
                                    <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                    <p class="m-0 fs-7">
                                      Khánh Duy ngáoooo
                                    </p>
                                  </div>

                                  <div class="d-flex flex-row">
                                    <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                    <div class="p-2 m-0 fs-7 text-secondary fw-bold " onclick="toggleReplyForm(2)" style="cursor: pointer;" >Phản hồi</div>
                                  </div>
                                </div>
                              </div>

                               <!--repcomment comments 2-->
                                <div class="mb-3" id="repcomment2" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            

                              <!--comments 3-->
                              <div class=" ms-5">
                                <div class="d-flex my-1" onclick="showComment(3)">
                                  <!-- avatar -->
                                  <img
                                    src="https://source.unsplash.com/collection/happy-people"
                                    alt="avatar"
                                    class="rounded-circle me-2 mt-1"
                                    style="
                                      width: 38px;
                                      height: 38px;
                                      object-fit: cover;
                                    "
                                  />
                                  <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4  bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm(3)"style="cursor: pointer;" >Phản hồi</div>
                                    </div>

                                  </div>
                                </div>

                                <!--repcomment comments 3-->
                                <div class=" mb-3" id="repcomment3" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
                          <!-- create comment -->
                          <form class="d-flex my-1">
                            <!-- avatar -->
                            <div>
                              <img
                                src="https://source.unsplash.com/collection/happy-people"
                                alt="avatar"
                                class="rounded-circle me-2"
                                style="
                                  width: 38px;
                                  height: 38px;
                                  object-fit: cover;
                                "
                              />
                            </div>
                            <!-- input -->
                            <input
                              type="text"
                              class="form-control border-0 rounded-pill bg-gray"
                              placeholder="Write a comment"
                            />
                          </form>
                          <!-- end -->
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>

          <!-- posts 1-->
          <div class="bg-white rounded shadow-sm mt-3 ">
            <!-- author -->
            <div class="d-flex justify-content-between pe-4 ps-4 pt-4">
              <!-- avatar -->
              <div class="d-flex">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <div>
                  <p class="m-0 fw-bold">Hồ Dư Mai Trân</p>
                  <span class="text-muted fs-7">18 giờ</span>
                </div>
              </div>
              <!-- edit -->
              <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <!-- edit menu -->
              <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Chỉnh sửa bài viết</a>
                </li>
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Xóa bài viết</a>
                </li>
              </ul>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <div>
                <p class="pe-4 ps-4">
                  Ngày ấy ta tìm thấy anh giữa biển người
                  Hôm nay em trả anh về với biển người ấy
                </p>
                <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="width: 100%;"/>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative">
                <!-- likes -->
                <div class="
                        d-flex
                        align-items-center
                        top-0
                        start-0
                        position-absolute
                        pe-4 ps-4
                      " style="height: 50px; z-index: 5">
                    <div class="me-2">
                      <i class="fa-solid fa-heart text-danger"></i>
                    </div>
                    <p class="m-0 text-muted fs-7">Phu, Tuan, and 3 người khác</p>
                    
                </div>
                <!-- comments start-->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0">
                    <!-- comment collapse -->
                    <h2 class="accordion-header" id="headingOne">
                      <div class="
                              accordion-button
                              collapsed
                              pointer
                              d-flex
                              justify-content-end
                            " >
                        <p class="m-0 fs-7" data-bs-toggle="collapse" data-bs-target="#collapsePost1" aria-expanded="false" aria-controls="collapsePost1">2 bình luận</p>
                        <p class="m-0 ms-2 fs-7">4 lượt chia sẻ</p>
                      </div>    
                    </h2>
                    <hr class="mt-0 mb-3"/>
                    
                    
                    <!-- comment & like bar -->
                    <div class="d-flex justify-content-around mb-4">
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                              
                            ">
                        <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted hover_like p-2" >
                            <i class="fa-regular fa-heart me-3" style="color: #000000;"></i>
                            <p class="m-0">Yêu thích</p>
                        </div>
                      </div>
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                            "
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePost1"
                          aria-expanded="false"
                          aria-controls="collapsePost1"> 

                        <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                        <p class="m-0">Bình luận</p>
                      </div>
                      <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                         
                          ">
                        <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                        <p class="m-0">Chia sẻ</p>
                      </div>
                    </div>


                    <!-- comment model -->
                      <div
                        id="collapsePost1"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <hr/>
                        <div class="accordion-body">
                          <!-- comment 1 -->
                          <div class="comment-container">
                            <div class="">
                              <div class="d-flex" onclick="showComment1(1)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                  />
                                <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4 bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo ugyftdreeeeeeeeeeeeeeeeeeeeeegggggggggggggggggggggggggggggrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row ">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm1(1)" style="cursor: pointer;" >Phản hồi</div>
                                    </div>
                                  </div>
                              </div>
                              <!--repcomment comments 1-->
                              <div class="mb-3" id="repcomment11" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse ms-1 me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>

                            <!--comments 2-->
                            <div class="ms-5">
                              <div class="d-flex my-1 " onclick="showComment1(2)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2 mt-1"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                />
                                <!-- comment text -->
                                <div class="">
                                  <div class="p-2 rounded-4 bg-gray">
                                    <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                    <p class="m-0 fs-7">
                                      Khánh Duy ngáoooo
                                    </p>
                                  </div>

                                  <div class="d-flex flex-row">
                                    <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                    <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm1(2)"style="cursor: pointer;" >Phản hồi</div>
                                  </div>
                                </div>
                              </div>

                               <!--repcomment comments 2-->
                                <div class="mb-3" id="repcomment12" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            

                              <!--comments 3-->
                              <div class=" ms-5">
                                <div class="d-flex my-1" onclick="showComment1(3)">
                                  <!-- avatar -->
                                  <img
                                    src="https://source.unsplash.com/collection/happy-people"
                                    alt="avatar"
                                    class="rounded-circle me-2 mt-1"
                                    style="
                                      width: 38px;
                                      height: 38px;
                                      object-fit: cover;
                                    "
                                  />
                                  <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4  bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm1(3)"style="cursor: pointer;" >Phản hồi</div>
                                    </div>

                                  </div>
                                </div>

                                <!--repcomment comments 3-->
                                <div class=" mb-3" id="repcomment13" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
                          <!-- create comment -->
                          <form class="d-flex my-1">
                            <!-- avatar -->
                            <div>
                              <img
                                src="https://source.unsplash.com/collection/happy-people"
                                alt="avatar"
                                class="rounded-circle me-2"
                                style="
                                  width: 38px;
                                  height: 38px;
                                  object-fit: cover;
                                "
                              />
                            </div>
                            <!-- input -->
                            <input
                              type="text"
                              class="form-control border-0 rounded-pill bg-gray"
                              placeholder="Write a comment"
                            />
                          </form>
                          <!-- end -->
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>
          
           <!-- posts 2 -->
          <div class="bg-white rounded shadow-sm mt-3 ">
            <!-- author -->
            <div class="d-flex justify-content-between pe-4 ps-4 pt-4">
              <!-- avatar -->
              <div class="d-flex ">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <div>
                  <p class="m-0 fw-bold ">Hồ Dư Mai Trân</p>
                  <span class="text-muted fs-7">18 giờ</span>
                </div>
              </div>
              <!-- edit -->
              <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <!-- edit menu -->
              <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Chỉnh sửa bài viết</a>
                </li>
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Xóa bài viết</a>
                </li>
              </ul>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <div>
                <p class="ps-4 pe-4">
                  Ngày ấy ta tìm thấy anh giữa biển người
                  Hôm nay em trả anh về với biển người ấy
                </p>

                <div class="container m-0 g-0">
                  <div class="row g-1">
                    <div class="col">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="width: 100%;"/>
                    </div>
                    <div class="col">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="width: 100%;"/>
                    </div>
                  </div>
                </div>
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative">
                <!-- likes -->
                <div class="
                        d-flex
                        align-items-center
                        top-0
                        start-0
                        position-absolute
                        ms-4
                      " style="height: 50px; z-index: 5">
                    <div class="me-2">
                      <i class="fa-solid fa-heart text-danger"></i>
                    </div>
                    <p class="m-0 text-muted fs-7">Phu, Tuan, and 3 người khác</p>
                    
                </div>
                <!-- comments start-->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0">
                    <!-- comment collapse -->
                    <h2 class="accordion-header" id="headingTwo">
                      <div class="
                              accordion-button
                              collapsed
                              pointer
                              d-flex
                              justify-content-end
                            " >
                        <p class="m-0 fs-7" data-bs-toggle="collapse" data-bs-target="#collapsePost2" aria-expanded="false" aria-controls="collapsePost2">2 bình luận</p>
                        <p class="m-0 ms-2 fs-7">4 lượt chia sẻ</p>
                      </div>    
                    </h2>
                    <hr class="mt-0 mb-3"/>
                    
                    
                    <!-- comment & like bar -->
                    <div class="d-flex justify-content-around mb-4">
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                              
                            ">
                        <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted hover_like p-2" >
                                <i class="fa-regular fa-heart me-3" style="color: #000000;"></i>
                                <p class="m-0">Yêu thích</p>
                            </div>
                      </div>
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                            "
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePost2"
                          aria-expanded="false"
                          aria-controls="collapsePost2"> 

                        <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                        <p class="m-0">Bình luận</p>
                      </div>
                      <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                         
                          ">
                        <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                        <p class="m-0">Chia sẻ</p>
                      </div>
                    </div>


                    <!-- comment model -->
                      <div
                        id="collapsePost2"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <hr/>
                        <div class="accordion-body">
                          <!-- comment 1 -->
                          <div class="comment-container">
                            <div class="">
                              <div class="d-flex" onclick="showComment2(1)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                  />
                                <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4 bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo ugyftdreeeeeeeeeeeeeeeeeeeeeegggggggggggggggggggggggggggggrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row ">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm2(1)" style="cursor: pointer;" >Phản hồi</div>
                                    </div>
                                  </div>
                              </div>
                              <!--repcomment comments 1-->
                              <div class="mb-3" id="repcomment21" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse ms-1 me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>

                            <!--comments 2-->
                            <div class="ms-5">
                              <div class="d-flex my-1 " onclick="showComment2(2)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2 mt-1"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                />
                                <!-- comment text -->
                                <div class="">
                                  <div class="p-2 rounded-4 bg-gray">
                                    <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                    <p class="m-0 fs-7">
                                      Khánh Duy ngáoooo
                                    </p>
                                  </div>

                                  <div class="d-flex flex-row">
                                    <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                    <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm2(2)"style="cursor: pointer;" >Phản hồi</div>
                                  </div>
                                </div>
                              </div>

                               <!--repcomment comments 2-->
                                <div class="mb-3" id="repcomment22" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            

                              <!--comments 3-->
                              <div class=" ms-5">
                                <div class="d-flex my-1" onclick="showComment2(3)">
                                  <!-- avatar -->
                                  <img
                                    src="https://source.unsplash.com/collection/happy-people"
                                    alt="avatar"
                                    class="rounded-circle me-2 mt-1"
                                    style="
                                      width: 38px;
                                      height: 38px;
                                      object-fit: cover;
                                    "
                                  />
                                  <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4  bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm2(3)"style="cursor: pointer;" >Phản hồi</div>
                                    </div>

                                  </div>
                                </div>

                                <!--repcomment comments 3-->
                                <div class=" mb-3" id="repcomment23" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
                          <!-- create comment -->
                          <form class="d-flex my-1">
                            <!-- avatar -->
                            <div>
                              <img
                                src="https://source.unsplash.com/collection/happy-people"
                                alt="avatar"
                                class="rounded-circle me-2"
                                style="
                                  width: 38px;
                                  height: 38px;
                                  object-fit: cover;
                                "
                              />
                            </div>
                            <!-- input -->
                            <input
                              type="text"
                              class="form-control border-0 rounded-pill bg-gray"
                              placeholder="Write a comment"
                            />
                          </form>
                          <!-- end -->
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>
          
          <!-- posts 3 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between   pe-4 ps-4 pt-4">
              <!-- avatar -->
              <div class="d-flex">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <div>
                  <p class="m-0 fw-bold">Hồ Dư Mai Trân</p>
                  <span class="text-muted fs-7">18 giờ</span>
                </div>
              </div>
              <!-- edit -->
              <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <!-- edit menu -->
              <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Chỉnh sửa bài viết</a>
                </li>
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Xóa bài viết</a>
                </li>
              </ul>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <div>
                <p class="me-4 ms-4">
                  Ngày ấy ta tìm thấy anh giữa biển người
                  Hôm nay em trả anh về với biển người ấy
                </p>

                <div class="container m-0 g-0" style="width: 100%;">
                  <div class="row g-1">
                    <div class="col-8">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="width: 100%;"/>
                    </div>
                    <div class="col-4">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid mb-1" style="height: 50%;"/>
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="hieght: 50%;"/>
                    </div>
                  </div>
                </div>
                
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative">
                <!-- likes -->
                <div class="
                        d-flex
                        align-items-center
                        top-0
                        start-0
                        position-absolute
                        ms-4
                      " style="height: 50px; z-index: 5">
                    <div class="me-2">
                      <i class="fa-solid fa-heart text-danger"></i>
                    </div>
                    <p class="m-0 text-muted fs-7">Phu, Tuan, and 3 người khác</p>
                    
                </div>
                <!-- comments start-->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0">
                    <!-- comment collapse -->
                    <h2 class="accordion-header" id="headingThere">
                      <div class="
                              accordion-button
                              collapsed
                              pointer
                              d-flex
                              justify-content-end
                            " >
                        <p class="m-0 fs-7" data-bs-toggle="collapse" data-bs-target="#collapsePost3" aria-expanded="false" aria-controls="collapsePost3">2 bình luận</p>
                        <p class="m-0 ms-2 fs-7">4 lượt chia sẻ</p>
                      </div>    
                    </h2>
                    <hr class="mt-0 mb-3"/>
                    
                    
                    <!-- comment & like bar -->
                    <div class="d-flex justify-content-around pb-4">
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                              
                            ">
                        <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted hover_like p-2" >
                                <i class="fa-regular fa-heart me-3" style="color: #000000;"></i>
                                <p class="m-0">Yêu thích</p>
                            </div>
                      </div>
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                            "
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePost3"
                          aria-expanded="false"
                          aria-controls="collapsePost3"> 

                        <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                        <p class="m-0">Bình luận</p>
                      </div>
                      <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                         
                          ">
                        <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                        <p class="m-0">Chia sẻ</p>
                      </div>
                    </div>


                    <!-- comment model -->
                      <div
                        id="collapsePost3"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingThere"
                        data-bs-parent="#accordionExample">
                        <hr/>
                        <div class="accordion-body">
                          <!-- comment 1 -->
                          <div class="comment-container">
                            <div class="">
                              <div class="d-flex" onclick="showComment3(1)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                  />
                                <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4 bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo ugyftdreeeeeeeeeeeeeeeeeeeeeegggggggggggggggggggggggggggggrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row ">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm3(1)" style="cursor: pointer;" >Phản hồi</div>
                                    </div>
                                  </div>
                              </div>
                              <!--repcomment comments 1-->
                              <div class="mb-3" id="repcomment31" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse ms-1 me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>

                            <!--comments 2-->
                            <div class="ms-5">
                              <div class="d-flex my-1 " onclick="showComment3(2)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2 mt-1"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                />
                                <!-- comment text -->
                                <div class="">
                                  <div class="p-2 rounded-4 bg-gray">
                                    <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                    <p class="m-0 fs-7">
                                      Khánh Duy ngáoooo
                                    </p>
                                  </div>

                                  <div class="d-flex flex-row">
                                    <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                    <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm3(2)"style="cursor: pointer;" >Phản hồi</div>
                                  </div>
                                </div>
                              </div>

                               <!--repcomment comments 2-->
                                <div class="mb-3" id="repcomment32" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            

                              <!--comments 3-->
                              <div class=" ms-5">
                                <div class="d-flex my-1" onclick="showComment3(3)">
                                  <!-- avatar -->
                                  <img
                                    src="https://source.unsplash.com/collection/happy-people"
                                    alt="avatar"
                                    class="rounded-circle me-2 mt-1"
                                    style="
                                      width: 38px;
                                      height: 38px;
                                      object-fit: cover;
                                    "
                                  />
                                  <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4  bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm3(3)"style="cursor: pointer;" >Phản hồi</div>
                                    </div>

                                  </div>
                                </div>

                                <!--repcomment comments 3-->
                                <div class=" mb-3" id="repcomment33" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
                          <!-- create comment -->
                          <form class="d-flex my-1">
                            <!-- avatar -->
                            <div>
                              <img
                                src="https://source.unsplash.com/collection/happy-people"
                                alt="avatar"
                                class="rounded-circle me-2"
                                style="
                                  width: 38px;
                                  height: 38px;
                                  object-fit: cover;
                                "
                              />
                            </div>
                            <!-- input -->
                            <input
                              type="text"
                              class="form-control border-0 rounded-pill bg-gray"
                              placeholder="Write a comment"
                            />
                          </form>
                          <!-- end -->
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>

          <!-- posts 4 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between   pe-4 ps-4 pt-4">
              <!-- avatar -->
              <div class="d-flex">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <div>
                  <p class="m-0 fw-bold">Hồ Dư Mai Trân</p>
                  <span class="text-muted fs-7">18 giờ</span>
                </div>
              </div>
              <!-- edit -->
              <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <!-- edit menu -->
              <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Chỉnh sửa bài viết</a>
                </li>
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Xóa bài viết</a>
                </li>
              </ul>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <div>
                <p class="me-4 ms-4">
                  Ngày ấy ta tìm thấy anh giữa biển người
                  Hôm nay em trả anh về với biển người ấy
                </p>

                <div class="container m-0 g-0 mb-1" style="width: 100%;">
                  <div class="row g-1">
                    <div class="col">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid mb-1" style="height: 50%;"/>
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="hieght: 50%;"/>
                    </div>
                    <div class="col">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid mb-1" style="height: 50%;"/>
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="hieght: 50%;"/>
                    </div>
                  </div>
                </div>
                
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative">
                <!-- likes -->
                <div class="
                        d-flex
                        align-items-center
                        top-0
                        start-0
                        position-absolute
                        ms-4
                      " style="height: 50px; z-index: 5">
                    <div class="me-2">
                      <i class="fa-solid fa-heart text-danger"></i>
                    </div>
                    <p class="m-0 text-muted fs-7">Phu, Tuan, and 3 người khác</p>
                    
                </div>
                <!-- comments start-->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0">
                    <!-- comment collapse -->
                    <h2 class="accordion-header" id="headingFour">
                      <div class="
                              accordion-button
                              collapsed
                              pointer
                              d-flex
                              justify-content-end
                            " >
                        <p class="m-0 fs-7" data-bs-toggle="collapse" data-bs-target="#collapsePost4" aria-expanded="false" aria-controls="collapsePost4">2 bình luận</p>
                        <p class="m-0 ms-2 fs-7">4 lượt chia sẻ</p>
                      </div>    
                    </h2>
                    <hr class="mt-0 mb-3"/>
                    
                    
                    <!-- comment & like bar -->
                    <div class="d-flex justify-content-around pb-4">
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                              
                            ">
                        <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted hover_like p-2" >
                                <i class="fa-regular fa-heart me-3" style="color: #000000;"></i>
                                <p class="m-0">Yêu thích</p>
                            </div>
                      </div>
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                            "
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePost4"
                          aria-expanded="false"
                          aria-controls="collapsePost4"> 

                        <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                        <p class="m-0">Bình luận</p>
                      </div>
                      <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                         
                          ">
                        <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                        <p class="m-0">Chia sẻ</p>
                      </div>
                    </div>


                    <!-- comment model -->
                      <div
                        id="collapsePost4"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingFour"
                        data-bs-parent="#accordionExample">
                        <hr/>
                        <div class="accordion-body">
                          <!-- comment 1 -->
                          <div class="comment-container">
                            <div class="">
                              <div class="d-flex" onclick="showComment4(1)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                  />
                                <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4 bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo ugyftdreeeeeeeeeeeeeeeeeeeeeegggggggggggggggggggggggggggggrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row ">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm4(1)" style="cursor: pointer;" >Phản hồi</div>
                                    </div>
                                  </div>
                              </div>
                              <!--repcomment comments 1-->
                              <div class="mb-3" id="repcomment41" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse ms-1 me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>

                            <!--comments 2-->
                            <div class="ms-5">
                              <div class="d-flex my-1 " onclick="showComment4(2)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2 mt-1"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                />
                                <!-- comment text -->
                                <div class="">
                                  <div class="p-2 rounded-4 bg-gray">
                                    <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                    <p class="m-0 fs-7">
                                      Khánh Duy ngáoooo
                                    </p>
                                  </div>

                                  <div class="d-flex flex-row">
                                    <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                    <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm4(2)"style="cursor: pointer;" >Phản hồi</div>
                                  </div>
                                </div>
                              </div>

                               <!--repcomment comments 2-->
                                <div class="mb-3" id="repcomment42" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            

                              <!--comments 3-->
                              <div class=" ms-5">
                                <div class="d-flex my-1" onclick="showComment4(3)">
                                  <!-- avatar -->
                                  <img
                                    src="https://source.unsplash.com/collection/happy-people"
                                    alt="avatar"
                                    class="rounded-circle me-2 mt-1"
                                    style="
                                      width: 38px;
                                      height: 38px;
                                      object-fit: cover;
                                    "
                                  />
                                  <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4  bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm4(3)"style="cursor: pointer;" >Phản hồi</div>
                                    </div>

                                  </div>
                                </div>

                                <!--repcomment comments 3-->
                                <div class=" mb-3" id="repcomment43" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
                          <!-- create comment -->
                          <form class="d-flex my-1">
                            <!-- avatar -->
                            <div>
                              <img
                                src="https://source.unsplash.com/collection/happy-people"
                                alt="avatar"
                                class="rounded-circle me-2"
                                style="
                                  width: 38px;
                                  height: 38px;
                                  object-fit: cover;
                                "
                              />
                            </div>
                            <!-- input -->
                            <input
                              type="text"
                              class="form-control border-0 rounded-pill bg-gray"
                              placeholder="Write a comment"
                            />
                          </form>
                          <!-- end -->
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>

          <!-- posts 5 -->
          <div class="bg-white rounded shadow-sm mt-3">
            <!-- author -->
            <div class="d-flex justify-content-between   pe-4 ps-4 pt-4">
              <!-- avatar -->
              <div class="d-flex">
                <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                <div>
                  <p class="m-0 fw-bold">Hồ Dư Mai Trân</p>
                  <span class="text-muted fs-7">18 giờ</span>
                </div>
              </div>
              <!-- edit -->
              <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <!-- edit menu -->
              <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Chỉnh sửa bài viết</a>
                </li>
                <li class="d-flex align-items-center">
                  <a class="
                          dropdown-item
                          d-flex
                          justify-content-around
                          align-items-center
                          fs-7
                        " href="#">
                    Xóa bài viết</a>
                </li>
              </ul>
            </div>
            <!-- post content -->
            <div class="mt-3">
              <!-- content -->
              <div>
                <p class="me-4 ms-4">
                  Ngày ấy ta tìm thấy anh giữa biển người
                  Hôm nay em trả anh về với biển người ấy
                </p>

                <div class="container m-0 g-0" style="width: 100%;">
                  <div class="row g-1">
                    <div class="col">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid mb-1" style="height: 50%;"/>
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid" style="hieght: 50%;"/>
                    </div>
                    <div class="col ">
                      <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid mb-1" style="height: 50%;"/>
                      <div class="post_plus">
                        <img src="./Public/images/avt.jpg" alt="post image" class="img-fluid " style="hieght: 50%;"/>
                        <div class="overlay"></div>
                        <i class="fa-solid fa-plus post_image_plus">2</i>
                      </div>
                      
                    </div>
                  </div>
                </div>
                
              </div>
              <!-- likes & comments -->
              <div class="post__comment position-relative">
                <!-- likes -->
                <div class="
                        d-flex
                        align-items-center
                        top-0
                        start-0
                        position-absolute
                        ms-4
                      " style="height: 50px; z-index: 5">
                    <div class="me-2">
                      <i class="fa-solid fa-heart text-danger"></i>
                    </div>
                    <p class="m-0 text-muted fs-7">Phu, Tuan, and 3 người khác</p>
                    
                </div>
                <!-- comments start-->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0">
                    <!-- comment collapse -->
                    <h2 class="accordion-header" id="headingFive">
                      <div class="
                              accordion-button
                              collapsed
                              pointer
                              d-flex
                              justify-content-end
                            " >
                        <p class="m-0 fs-7" data-bs-toggle="collapse" data-bs-target="#collapsePost5" aria-expanded="false" aria-controls="collapsePost5">2 bình luận</p>
                        <p class="m-0 ms-2 fs-7">4 lượt chia sẻ</p>
                      </div>    
                    </h2>
                    <hr class="mt-0 mb-3"/>
                    
                    
                    <!-- comment & like bar -->
                    <div class="d-flex justify-content-around pb-4">
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                              
                            ">
                        <div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted hover_like p-2" >
                                <i class="fa-regular fa-heart me-3" style="color: #000000;"></i>
                                <p class="m-0">Yêu thích</p>
                            </div>
                      </div>
                      <div class="
                              dropdown-item
                              rounded
                              d-flex
                              justify-content-center
                              align-items-center
                              pointer
                              text-muted
                            "
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePost5"
                          aria-expanded="false"
                          aria-controls="collapsePost5"> 

                        <i class="fa-regular fa-comment me-3" style="color: #000000;"></i>
                        <p class="m-0">Bình luận</p>
                      </div>
                      <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                         
                          ">
                        <i class="fa-solid fa-share me-3" style="color: #000000;"></i>
                        <p class="m-0">Chia sẻ</p>
                      </div>
                    </div>


                    <!-- comment model -->
                      <div
                        id="collapsePost5"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingFive"
                        data-bs-parent="#accordionExample">
                        <hr/>
                        <div class="accordion-body">
                          <!-- comment 1 -->
                          <div class="comment-container">
                            <div class="">
                              <div class="d-flex" onclick="showComment5(1)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                  />
                                <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4 bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo ugyftdreeeeeeeeeeeeeeeeeeeeeegggggggggggggggggggggggggggggrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row ">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm5(1)" style="cursor: pointer;" >Phản hồi</div>
                                    </div>
                                  </div>
                              </div>
                              <!--repcomment comments 1-->
                              <div class="mb-3" id="repcomment51" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse ms-1 me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>

                            <!--comments 2-->
                            <div class="ms-5">
                              <div class="d-flex my-1 " onclick="showComment5(2)">
                                <!-- avatar -->
                                <img
                                  src="https://source.unsplash.com/collection/happy-people"
                                  alt="avatar"
                                  class="rounded-circle me-2 mt-1"
                                  style="
                                    width: 38px;
                                    height: 38px;
                                    object-fit: cover;
                                  "
                                />
                                <!-- comment text -->
                                <div class="">
                                  <div class="p-2 rounded-4 bg-gray">
                                    <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                    <p class="m-0 fs-7">
                                      Khánh Duy ngáoooo
                                    </p>
                                  </div>

                                  <div class="d-flex flex-row">
                                    <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                    <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm5(2)"style="cursor: pointer;" >Phản hồi</div>
                                  </div>
                                </div>
                              </div>

                               <!--repcomment comments 2-->
                                <div class="mb-3" id="repcomment52" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            

                              <!--comments 3-->
                              <div class=" ms-5">
                                <div class="d-flex my-1" onclick="showComment5(3)">
                                  <!-- avatar -->
                                  <img
                                    src="https://source.unsplash.com/collection/happy-people"
                                    alt="avatar"
                                    class="rounded-circle me-2 mt-1"
                                    style="
                                      width: 38px;
                                      height: 38px;
                                      object-fit: cover;
                                    "
                                  />
                                  <!-- comment text -->
                                  <div class="">
                                    <div class="p-2 rounded-4  bg-gray">
                                      <p class="m-0 mb-1 fs-7 fw-bolder">Hồ Dư Mai Trân</p>
                                      <p class="m-0 fs-7">
                                        Khánh Duy ngáoooo
                                      </p>
                                    </div>

                                    <div class="d-flex flex-row">
                                      <div class="p-2 m-0 fs-7 text-secondary">12 giờ</div>
                                      <div class="p-2 m-0 fs-7 text-secondary fw-bold" onclick="toggleReplyForm5(3)"style="cursor: pointer;" >Phản hồi</div>
                                    </div>

                                  </div>
                                </div>

                                <!--repcomment comments 3-->
                                <div class=" mb-3" id="repcomment53" style="display:none">
                                  <form class="d-flex my-1">
                                    <!-- avatar -->
                                    <div>
                                      <img
                                        src="https://source.unsplash.com/collection/happy-people"
                                        alt="avatar"
                                        class="rounded-circle me-2"
                                        style="
                                          width: 38px;
                                          height: 38px;
                                          object-fit: cover;
                                        "
                                      />
                                    </div>
                                    <!-- input -->
                                    <div class="bg-gray p-1 rounded-4 d-flex align-items-center" style="width: 100%;">
                                      <textarea
                                          class="form-control border-0 rounded-pill bg-gray input search-input"
                                          placeholder="Viết bình luận..."
                                          autofocus
                                          style="box-shadow: none; resize: vertical;"
                                      ></textarea>

                                      <div class="d-flex flex-row-reverse me-2">
                                        <i class="fa-solid fa-paper-plane text-primary"></i>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
                          <!-- create comment -->
                          <form class="d-flex my-1">
                            <!-- avatar -->
                            <div>
                              <img
                                src="https://source.unsplash.com/collection/happy-people"
                                alt="avatar"
                                class="rounded-circle me-2"
                                style="
                                  width: 38px;
                                  height: 38px;
                                  object-fit: cover;
                                "
                              />
                            </div>
                            <!-- input -->
                            <input
                              type="text"
                              class="form-control border-0 rounded-pill bg-gray"
                              placeholder="Write a comment"
                            />
                          </form>
                          <!-- end -->
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ================= Chatbar ================= -->
      <div class="col-12 col-lg-3">
        <div class="d-none d-xxl-block h-100 fixed-top end-0 overflow-hidden scrollbar" style=" max-width: 360px; width: 100%; z-index: 4; padding-top: 56px; left: initial !important;">
          <div class="p-3 mt-4">
            <!-- contacts -->
            <hr class="m-0" />
            <div class="my-3 d-flex justify-content-between align-items-center">
              <p class="text-muted fs-5 m-0">Người liên hệ</p>
            </div>
            <!-- friend 1 -->
            <li class="dropdown-item rounded my-2 px-0" type="button" data-bs-toggle="modal" data-bs-target="#singleChat1">
              <!-- avatar -->
              <div class="d-flex align-items-center mx-2 chat-avatar">
                <div class="position-relative">
                  <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <span class="
                        position-absolute
                        bottom-0
                        translate-middle
                        border border-light
                        rounded-circle
                        bg-success
                        p-1
                      " style="left: 75%">
                    <span class="visually-hidden"></span>
                  </span>
                </div>
                <p class="m-0">Võ Khánh Duy</p>
              </div>
            </li>
            <!-- friend 2 -->
            <li class="dropdown-item rounded my-2 px-0" type="button" data-bs-toggle="modal" data-bs-target="#singleChat3">
              <!-- avatar -->
              <div class="d-flex align-items-center mx-2 chat-avatar">
                <div class="position-relative">
                  <img src="./Public/images/avt.jpg" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <span class="
                        position-absolute
                        bottom-0
                        translate-middle
                        border border-light
                        rounded-circle
                        bg-success
                        p-1
                      " style="left: 75%">
                    <span class="visually-hidden"></span>
                  </span>
                </div>
                <p class="m-0">Hồ Dư Mai Trân</p>
              </div>
            </li>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ================= Chat Icon ================= -->
  <div class="fixed-bottom right-100 p-3" style="z-index: 6; left: initial" type="button" data-bs-toggle="modal" data-bs-target="#newChat">
    <i class="fas fa-edit bg-white rounded-circle p-3 shadow"></i>
  </div>
</main>