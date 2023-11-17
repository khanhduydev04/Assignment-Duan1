<div class="container-fluid d-flex justify-content-center align-items-center bg-gray">
        <div class="shadow-sm p-3 bg-white" style="width: 1000px; border-radius: 5px;">
            <div class="d-flex justify-content-between align-items-center">
                <h5><strong class="">Bạn bè</strong></h5>
                <form action="" class="search-friend">
                    <i class="fa-solid fa-magnifying-glass search-friend-icon"></i>
                    <input class="search-friend-form" type="search" value="" placeholder="Tìm kiếm">
                </form>
            </div>
            <!-- button -->
            <div class="mt-4 d-flex justify-content-start">
                <div class="me-3">
                    <p type="button" class="ms-3 me-3 text-secondary" onclick="showFriend()">Bạn bè </p>
                    <hr id="friend_hr" class="border border-primary border-2 opacity-75" style="display:none">
                </div>
                <div class="">
                    <p type="button" class="text-secondary" onclick="showFollow()">Người theo dõi </p>
                    <hr id="follow_hr" class="border border-primary border-2 opacity-75" >
                </div>
            </div>

            <!-- List friend -->
            <!--All friend-->
            <div id="friend" class="products">
                <div class="container overflow-hidden text-center">
                    <div class="row gy-1">
                    <!--Friend 1-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/avatar.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Hồ Dư Mai Trân</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 2-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/1.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Võ Khánh Duy</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 3-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/2.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Thái Toàn</h6>
                                    <p class="fs-7 text-secondary">1 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 4-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/3.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Cao Bá Phước</h6>
                                    <p class="fs-7 text-secondary">2 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 5-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/avatar.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Hồ Dư Mai Trân</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 6-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/1.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Võ Khánh Duy</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 7-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/2.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Thái Toàn</h6>
                                    <p class="fs-7 text-secondary">1 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 8-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/3.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Cao Bá Phước</h6>
                                    <p class="fs-7 text-secondary">2 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 9-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/3.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Cao Bá Phước</h6>
                                    <p class="fs-7 text-secondary">2 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 10-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/3.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Cao Bá Phước</h6>
                                    <p class="fs-7 text-secondary">2 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                      
                    </div>
                </div>
            </div>

            <!--Follow friend-->
            <div id="follow" class="products" style="display: none;">
                <div class="container overflow-hidden text-center">
                    <div class="row gy-1">
                    <!--Friend 1-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/1.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Võ Khánh Duy</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 2-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/1.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Võ Khánh Duy</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 3-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/avatar.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Hồ Dư Mai Trân</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 4-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/avatar.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Hồ Dư Mai Trân</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 5-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/avatar.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Hồ Dư Mai Trân</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 6-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/1.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Võ Khánh Duy</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 7-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/2.jpg" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Nguyễn Thái Toàn</h6>
                                    <p class="fs-7 text-secondary">1 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                    <!--Friend 8-->
                    <div class="col-6">
                        <div class="p-3 border border-light d-flex justify-content-between align-items-center">
                            <!--Avatar-->
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="./images/avatar.png" alt="avatar" class="me-2" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;"/>
                                <div class="ms-2 mt-2 text-start">
                                    <h6>Hồ Dư Mai Trân</h6>
                                    <p class="fs-7 text-secondary">12 bạn chung</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <strong type="button" 
                                data-bs-custom-class="chat-box"
                                data-bs-container="body"
                                data-bs-toggle="popover"
                                data-bs-placement="right"
                                data-bs-content='
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fa-solid fa-user-xmark"></p>
                                        <p class="ms-2">Hủy kết bạn</p>
                                    </div>
                                    '
                                data-bs-html="true">
                                    ...
                                </strong>

                            </div>
                            
                        </div>
                    </div>
                      
                    </div>
                </div>
            </div>
        </div>
        
    </div>