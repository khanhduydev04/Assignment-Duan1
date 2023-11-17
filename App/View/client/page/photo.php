<div class="container-fluid d-flex justify-content-center align-items-center bg-gray">
        <div class="shadow-sm p-3 bg-white" style="width: 1000px; border-radius: 5px;">
            <div class="d-flex justify-content-between align-items-center">
                <h5><strong class="">Ảnh</strong></h5>
            </div>
            <!-- button -->
            <div class="mt-4 d-flex justify-content-start">
                <div class="me-3">
                    <p type="button" class="ms-3 me-3 text-secondary" onclick="showPicture()">Ảnh của bạn </p>
                    <hr id="Picture_hr" class="border border-primary border-2 opacity-75" >
                </div>
                <div class="me-4">
                    <p type="button" class="text-secondary" onclick="showAvatar()">Ảnh đại diện </p>
                    <hr id="Avatar_hr" class="border border-primary border-2 opacity-75" style="display:none">
                </div>
                <div class="">
                    <p type="button" class="text-secondary" onclick="showCover()">Ảnh bìa</p>
                    <hr id="Cover_hr" class="border border-primary border-2 opacity-75" style="display:none">
                </div>
            </div>

            <!-- List picture -->
            <!--Your picture-->
            <div id="Picture" class="products">
                <div class="container text-center">
                    <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                        <!--picture 1-->
                        <div class="col" style="width: 158px; height: 158px;">
                            <div class="position-picture" style="width: 100%; height: 100%;">
                                <img src="./images/1.jpg" style="width: 100%; height: 100%; border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <div class="d-flex align-items-center position-picture-icon">
                                    <strong 
                                    type="button" 
                                    class="rounded-circle transparent-bg d-flex justify-content-center align-items-center p-2"
                                    style="width: 28px; height: 28px;"
                                    data-bs-custom-class="chat-box"
                                    data-bs-container="body"
                                    data-bs-toggle="popover"
                                    data-bs-placement="right"
                                    data-bs-content='
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class=" fa-solid fa-trash-can"></p>
                                            <p class="ms-2">Xóa ảnh</p>
                                        </div>
                                        '
                                    data-bs-html="true">
                                    <i class="fa-solid fa-pen text-white fs-7"></i>
                                    </strong>

                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="">
                                    <div class="modal-body">
                                        <img src="./images/1.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Avatar-->
            <div id="Avatar" class="products" style="display: none;">
                <div class="container text-center">
                    <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                        <!--picture 1-->
                        <div class="col" style="width: 158px; height: 158px;">
                            <div class="position-picture" style="width: 100%; height: 100%;">
                                <img src="./images/2.jpg" style="width: 100%; height: 100%; border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal1">
                                <div class="d-flex align-items-center position-picture-icon">
                                    <strong 
                                    type="button" 
                                    class="rounded-circle transparent-bg d-flex justify-content-center align-items-center p-2"
                                    style="width: 28px; height: 28px;"
                                    data-bs-custom-class="chat-box"
                                    data-bs-container="body"
                                    data-bs-toggle="popover"
                                    data-bs-placement="right"
                                    data-bs-content='
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class=" fa-solid fa-trash-can"></p>
                                            <p class="ms-2">Xóa ảnh</p>
                                        </div>
                                        '
                                    data-bs-html="true">
                                    <i class="fa-solid fa-pen text-white fs-7"></i>
                                    </strong>

                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="imageModal1" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="">
                                    <div class="modal-body">
                                        <img src="./images/2.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Cover image-->
            <div id="Cover" class="products" style="display: none;">
                <div class="container text-center">
                    <div class="row row-cols-2 row-cols-lg-2 g-2 g-lg-2">
                        <!--picture 1-->
                        <div class="col" style="width: 158px; height: 158px;">
                            <div class="position-picture" style="width: 100%; height: 100%;">
                                <img src="./images/3.jpg" style="width: 100%; height: 100%; border-radius: 10px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal2">
                                <div class="d-flex align-items-center position-picture-icon">
                                    <strong 
                                    type="button" 
                                    class="rounded-circle transparent-bg d-flex justify-content-center align-items-center p-2"
                                    style="width: 28px; height: 28px;"
                                    data-bs-custom-class="chat-box"
                                    data-bs-container="body"
                                    data-bs-toggle="popover"
                                    data-bs-placement="right"
                                    data-bs-content='
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class=" fa-solid fa-trash-can"></p>
                                            <p class="ms-2">Xóa ảnh</p>
                                        </div>
                                        '
                                    data-bs-html="true">
                                    <i class="fa-solid fa-pen text-white fs-7"></i>
                                    </strong>

                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="imageModal2" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="">
                                    <div class="modal-body">
                                        <img src="./images/3.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>