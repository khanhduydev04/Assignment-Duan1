// profile
function resetModal(modal) {
  const previewAreas = modal.querySelector(".preview");
  const imagePreview = modal.querySelector("#imagePreview");
  const textareas = modal.querySelector(".modal-desc");
  const textareaInput = modal.querySelector("#description");
  const imageInput = modal.querySelector(".image-input");
  const labelUpload = modal.querySelector("#labelUpload");
  const modalFooter = modal.querySelector(".modal-change-footer");

  // Ẩn textarea và reset ảnh preview
  textareas.style.display = "none";
  previewAreas.style.display = "none";
  modalFooter.style.display = "none";
  labelUpload.style.display = "block";
  imagePreview.src = "";
  imageInput.value = "";
  textareaInput.value = "";
}

// Xóa ảnh và ẩn textarea khi đóng modal
$(".modal").on("hidden.bs.modal", function (e) {
  const modal = e.target;
  const previewAreas = modal.querySelector(".preview");
  const imagePreview = modal.querySelector("#imagePreview");
  const imageInput = modal.querySelector(".image-input");
  const labelUpload = modal.querySelector("#labelUpload");
  const textareas = modal.querySelector(".modal-desc");
  const textareaInput = modal.querySelector("#description");
  const modalFooter = modal.querySelector(".modal-change-footer");

  if (textareas) {
    textareas.style.display = "none";
  }
  if (previewAreas) {
    previewAreas.style.display = "none";
  }
  if (labelUpload) {
    labelUpload.style.display = "block";
  }
  if (modalFooter) {
    modalFooter.style.display = "none";
  }
  if (imagePreview) {
    imagePreview.src = "";
  }
  if (imageInput) {
    imageInput.value = "";
  }
  if (textareaInput) {
    textareaInput.value = "";
  }
});

// Hiển thị ảnh và textarea khi chọn ảnh
function showDetailModal(modal) {
  const previewAreas = modal.querySelector(".preview");
  const imagePreview = modal.querySelector("#imagePreview");
  const textareas = modal.querySelector(".modal-desc");
  const imageInput = modal.querySelector(".image-input");
  const labelUpload = modal.querySelector("#labelUpload");
  const modalFooter = modal.querySelector(".modal-footer");

  if (imageInput.files && imageInput.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      imagePreview.src = e.target.result;
      textareas.style.display = "block";
      previewAreas.style.display = "block";
      labelUpload.style.display = "none";
      modalFooter.style.display = "flex";
    };
    reader.readAsDataURL(imageInput.files[0]);
  }
  console.log(imageInput.value);
}

function showDetailModalWrapper(id) {
  var modal = document.getElementById(id); // Lấy ra phần tử modal cụ thể
  showDetailModal(modal); // Gọi hàm showDetailModal với tham số modal
}

function resetDetailModalWrapper(id) {
  var modal = document.getElementById(id); // Lấy ra phần tử modal cụ thể
  resetModal(modal);
}
//popover
const popoverTriggerList = document.querySelectorAll(
  '[data-bs-toggle="popover"]'
);
const popoverList = [...popoverTriggerList].map(
  (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
);

//gender seclect
if (window.location.pathname === "/login.html") {
  const radioBtn1 = document.querySelector("#flexRadioDefault1");
  const radioBtn2 = document.querySelector("#flexRadioDefault2");
  const radioBtn3 = document.querySelector("#flexRadioDefault3");
  const genderSelect = document.querySelector("#genderSelect");

  radioBtn1.addEventListener("change", () => {
    genderSelect.classList.add("d-none");
  });
  radioBtn2.addEventListener("change", () => {
    genderSelect.classList.add("d-none");
  });
  radioBtn3.addEventListener("change", () => {
    genderSelect.classList.remove("d-none");
  });
}

//Friend and follow
function showFriend() {
  document.getElementById("friend").style.display = "block";
  document.getElementById("follow").style.display = "none";

  document.getElementById("friend_hr").style.display = "block";
  document.getElementById("follow_hr").style.display = "none";
}

function showFollow() {
  document.getElementById("friend").style.display = "none";
  document.getElementById("follow").style.display = "block";

  document.getElementById("friend_hr").style.display = "none";
  document.getElementById("follow_hr").style.display = "block";
}

//Picture
function showPicture() {
  document.getElementById("Picture").style.display = "block";
  document.getElementById("Avatar").style.display = "none";
  document.getElementById("Cover").style.display = "none";

  document.getElementById("Picture_hr").style.display = "block";
  document.getElementById("Avatar_hr").style.display = "none";
  document.getElementById("Cover_hr").style.display = "none";
}

function showAvatar() {
  document.getElementById("Picture").style.display = "none";
  document.getElementById("Avatar").style.display = "block";
  document.getElementById("Cover").style.display = "none";

  document.getElementById("Picture_hr").style.display = "none";
  document.getElementById("Avatar_hr").style.display = "block";
  document.getElementById("Cover_hr").style.display = "none";
}

function showCover() {
  document.getElementById("Picture").style.display = "none";
  document.getElementById("Avatar").style.display = "none";
  document.getElementById("Cover").style.display = "block";

  document.getElementById("Picture_hr").style.display = "none";
  document.getElementById("Avatar_hr").style.display = "none";
  document.getElementById("Cover_hr").style.display = "block";
}

//modal picture
var myModal = new bootstrap.Modal(document.getElementById("imageModal"));

document.querySelectorAll(".img-thumbnail").forEach((item) => {
  item.addEventListener("click", (event) => {
    myModal.show();
  });
});

//Check creat post
function toggleSubmitButton() {
  // textarea và input file
  let contentTextarea = document.getElementById("content-post");
  let photoInput = document.getElementById("postImage");

  // button post
  let submitButton = document.getElementById("submitPost");
  let contentValue = contentTextarea.value.trim();
  let photoValue = photoInput.files.length;

  // Nếu một trong hai có dữ liệu, kích hoạt nút "Đăng" và thêm class "btn-primary"
  if (contentValue !== "" || photoValue > 0) {
    submitButton.disabled = false;
    submitButton.classList.remove("btn-secondary");
    submitButton.classList.add("btn-primary");
  } else {
    submitButton.disabled = true;
    submitButton.classList.remove("btn-primary");
    submitButton.classList.add("btn-secondary");
  }
}

function checkFilePostAvatar(fileInputId, submitButtonId) {
  // input file
  let photoInput = document.getElementById(fileInputId);
  let photoValue = photoInput.files.length;
  // button post
  let submitButton = document.getElementById(submitButtonId);
  // Nếu một trong hai có dữ liệu, kích hoạt nút "Đăng" và thêm class "btn-primary"
  if (photoValue > 0) {
    submitButton.disabled = false;
    submitButton.classList.remove("btn-secondary");
    submitButton.classList.add("btn-primary");
  } else {
    submitButton.disabled = true;
    submitButton.classList.remove("btn-primary");
    submitButton.classList.add("btn-secondary");
  }
}

//show preview post image
function showPreviewPostImage() {
  // Kiểm tra và cập nhật trạng thái nút đăng
  toggleSubmitButton();

  let postImageInput = document.getElementById("postImage");
  let postPreview = document.querySelector(".post-preview");

  // Xóa tất cả các thẻ img hiện tại trong post-preview
  postPreview.innerHTML = "";

  // Hiển thị ảnh và thêm nút xóa chung
  let row; // Khởi tạo biến row ở đây
  let deleteAllButtonAdded = false; // Biến kiểm tra xem nút xóa chung đã được thêm vào hay chưa

  if (postImageInput.files && postImageInput.files.length > 0) {
    for (let i = 0; i < postImageInput.files.length; i++) {
      // Tạo một dòng mới cho ảnh đầu tiên của mỗi cặp ảnh
      if (i % 2 === 0) {
        row = document.createElement("div");
        row.classList.add("row", "mb-2");
        postPreview.appendChild(row);
      }

      createImage(postImageInput.files[i], i, postImageInput.files);

      // Thêm nút xóa chung nếu chưa thêm
      if (!deleteAllButtonAdded) {
        addDeleteAllButton();
        deleteAllButtonAdded = true;
      }
    }
  }

  function createImage(file, index, filesArray) {
    let imgContainer = document.createElement("div");
    if (index === 0 && postImageInput.files.length === 1) {
      imgContainer.classList.add("col-md-12");
    } else {
      imgContainer.classList.add("col-md-6");
    }
    imgContainer.classList.add("position-relative");

    let img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    img.classList.add("img-fluid", "rounded", "mb-2");
    img.style.aspectRatio = "1/1";
    img.style.width = "100%";
    img.style.objectFit = "cover";
    imgContainer.appendChild(img);

    row.appendChild(imgContainer);
  }

  function addDeleteAllButton() {
    let deleteAllButton = document.createElement("button");
    deleteAllButton.type = "button";
    deleteAllButton.classList.add(
      "btn",
      "btn-danger",
      "btn-sm",
      "position-absolute",
      "top-0",
      "end-0",
      "btn-close-image"
    );
    deleteAllButton.innerHTML = '<i class="fas fa-times"></i>';
    deleteAllButton.addEventListener("click", function () {
      // Xóa tất cả ảnh và reset input file
      postPreview.innerHTML = "";
      postImageInput.value = ""; // Reset input file
      console.log(postImageInput);
      // Kiểm tra và cập nhật trạng thái nút đăng
      toggleSubmitButton();
    });

    // Thêm nút xóa chung vào postPreview
    postPreview.appendChild(deleteAllButton);
  }
}

// story upload
function previewImage(input) {
  const preview = document.getElementById("preview");
  const previewContainer = document.querySelector(".preview-container");
  const form = document.querySelector(".image-form");
  const imageNameInput = document.getElementById("imageName"); // Thẻ input để lưu tên file ảnh
  const file = input.files[0];
  const reader = new FileReader();

  // Kiểm tra định dạng tệp
  const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

  reader.onloadend = function () {
    if (file && allowedExtensions.test(file.name)) {
      preview.src = reader.result;
      previewContainer.classList.remove("hidden");
      form.classList.remove("hidden"); // Hiển thị form
      imageNameInput.files = input.files; // Gán dữ liệu ảnh từ input "uploadImage" sang input "imageName"
    } else {
      preview.src = "";
      previewContainer.classList.add("hidden");
      form.classList.add("hidden"); // Ẩn form nếu không có ảnh hợp lệ
      imageNameInput.value = ""; // Xóa tên file nếu không hợp lệ
      alert("Hãy chọn một tệp ảnh có định dạng jpg, jpeg hoặc png.");
    }
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
    previewContainer.classList.add("hidden");
    form.classList.add("hidden"); // Ẩn form nếu không có tệp nào được chọn
    imageNameInput.value = ""; // Xóa tên file nếu không có tệp nào được chọn
  }
}









//Check creat post
function toggleSubmitButtonUpdate() {
  // textarea và input file
  let contentTextarea = document.getElementById("content-post-update");
  let photoInputUpdate = document.getElementById("postImageUpdate");

  // button post
  let submitButton = document.getElementById("submitPostUpdate");
  let contentValue = contentTextarea.value.trim();
  let photoValue = photoInputUpdate.files.length;

  // Nếu một trong hai có dữ liệu, kích hoạt nút "Đăng" và thêm class "btn-primary"
  if (contentValue !== "" || photoValue > 0) {
    submitButton.disabled = false;
    submitButton.classList.remove("btn-secondary");
    submitButton.classList.add("btn-primary");
  } else {
    submitButton.disabled = true;
    submitButton.classList.remove("btn-primary");
    submitButton.classList.add("btn-secondary");
  }
}

function checkFilePostAvatar(fileInputId, submitButtonId) {
  // input file
  let photoInputUpdate = document.getElementById(fileInputId);
  let photoValue = photoInputUpdate.files.length;
  // button post
  let submitButton = document.getElementById(submitButtonId);
  // Nếu một trong hai có dữ liệu, kích hoạt nút "Đăng" và thêm class "btn-primary"
  if (photoValue > 0) {
    submitButton.disabled = false;
    submitButton.classList.remove("btn-secondary");
    submitButton.classList.add("btn-primary");
  } else {
    submitButton.disabled = true;
    submitButton.classList.remove("btn-primary");
    submitButton.classList.add("btn-secondary");
  }
}

//show preview post image
function showPreviewPostImageUpdate() {
  // Kiểm tra và cập nhật trạng thái nút đăng
  toggleSubmitButtonUpdate();

  let postImageInputUpdate = document.getElementById("postImageUpdate");
  let postPreviewUpdate = document.querySelector(".post-preview-update");

  // Xóa tất cả các thẻ img hiện tại trong post-preview
  postPreviewUpdate.innerHTML = "";

  // Hiển thị ảnh và thêm nút xóa chung
  let row; // Khởi tạo biến row ở đây
  let deleteAllButtonAdded = false; // Biến kiểm tra xem nút xóa chung đã được thêm vào hay chưa

  if (postImageInputUpdate.files && postImageInputUpdate.files.length > 0) {
    for (let i = 0; i < postImageInputUpdate.files.length; i++) {
      // Tạo một dòng mới cho ảnh đầu tiên của mỗi cặp ảnh
      if (i % 2 === 0) {
        row = document.createElement("div");
        row.classList.add("row", "mb-2");
        postPreviewUpdate.appendChild(row);
      }

      createImageUpdate(postImageInputUpdate.files[i], i, postImageInputUpdate.files);

      // Thêm nút xóa chung nếu chưa thêm
      if (!deleteAllButtonAdded) {
        addDeleteAllButton();
        deleteAllButtonAdded = true;
      }
    }
  }

  function createImageUpdate(file, index, filesArray) {
    let imgContainer = document.createElement("div");
    if (index === 0 && postImageInputUpdate.files.length === 1) {
      imgContainer.classList.add("col-md-12");
    } else {
      imgContainer.classList.add("col-md-6");
    }
    imgContainer.classList.add("position-relative");

    let img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    img.classList.add("img-fluid", "rounded", "mb-2");
    img.style.aspectRatio = "1/1";
    img.style.width = "100%";
    img.style.objectFit = "cover";
    imgContainer.appendChild(img);

    row.appendChild(imgContainer);
  }

  function addDeleteAllButton() {
    let deleteAllButton = document.createElement("button");
    deleteAllButton.type = "button";
    deleteAllButton.classList.add(
      "btn",
      "btn-danger",
      "btn-sm",
      "position-absolute",
      "top-0",
      "end-0",
      "btn-close-image"
    );
    deleteAllButton.innerHTML = '<i class="fas fa-times"></i>';
    deleteAllButton.addEventListener("click", function () {
      // Xóa tất cả ảnh và reset input file
      postPreviewUpdate.innerHTML = "";
      postImageInputUpdate.value = ""; // Reset input file
      console.log(postImageInputUpdate);
      // Kiểm tra và cập nhật trạng thái nút đăng
      toggleSubmitButtonUpdate();
    });

    // Thêm nút xóa chung vào postPreviewUpdate
    postPreviewUpdate.appendChild(deleteAllButton);
  }
}

