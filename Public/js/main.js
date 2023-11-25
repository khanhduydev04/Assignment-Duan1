// profile
function resetModal(modal) {
  const previewAreas = modal.querySelector(".preview");
  const imagePreview = modal.querySelector("#imagePreview");
  const textareas = modal.querySelector(".modal-desc");
  const textareaInput = modal.querySelector("#description");
  const imageInput = modal.querySelector(".image-input");
  const labelUpload = modal.querySelector("#labelUpload");
  const modalFooter = modal.querySelector(".modal-footer");

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

  textareas.style.display = "none";
  previewAreas.style.display = "none";
  labelUpload.style.display = "block";
  imagePreview.src = "";
  imageInput.value = "";
  textareaInput.value = "";
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
var myModal = new bootstrap.Modal(document.getElementById('imageModal'));

  document.querySelectorAll('.img-thumbnail').forEach(item => {
      item.addEventListener('click', event => {
          myModal.show();
      });
  });


  
//Rep comment 
function showComment(commentNumber) {
  // Lặp qua các comment để ẩn hiện dựa trên commentNumber được truyền vào
  for (let i = 1; i <= 3; i++) {
    const comment = document.getElementById(`repcomment${i}`);
    comment.style.display = i === commentNumber ? "block" : "none";
  }
}

function toggleReplyForm(commentNumber) {
  const form = document.getElementById(`repcomment${commentNumber}`);
  form.style.display = form.style.display === "none" ? "block" : "none";
}


function showComment1(commentNumber) {
  // Lặp qua các comment để ẩn hiện dựa trên commentNumber được truyền vào
  for (let i = 1; i <= 3; i++) {
    const comment = document.getElementById(`repcomment1${i}`);
    comment.style.display = i === commentNumber ? "block" : "none";
  }
}

function toggleReplyForm1(commentNumber) {
  const form = document.getElementById(`repcomment1${commentNumber}`);
  form.style.display = form.style.display === "none" ? "block" : "none";
}


function showComment2(commentNumber) {
  // Lặp qua các comment để ẩn hiện dựa trên commentNumber được truyền vào
  for (let i = 1; i <= 3; i++) {
    const comment = document.getElementById(`repcomment2${i}`);
    comment.style.display = i === commentNumber ? "block" : "none";
  }
}

function toggleReplyForm2(commentNumber) {
  const form = document.getElementById(`repcomment2${commentNumber}`);
  form.style.display = form.style.display === "none" ? "block" : "none";
}

function showComment3(commentNumber) {
  // Lặp qua các comment để ẩn hiện dựa trên commentNumber được truyền vào
  for (let i = 1; i <= 3; i++) {
    const comment = document.getElementById(`repcomment3${i}`);
    comment.style.display = i === commentNumber ? "block" : "none";
  }
}

function toggleReplyForm3(commentNumber) {
  const form = document.getElementById(`repcomment3${commentNumber}`);
  form.style.display = form.style.display === "none" ? "block" : "none";
}

function showComment4(commentNumber) {
  // Lặp qua các comment để ẩn hiện dựa trên commentNumber được truyền vào
  for (let i = 1; i <= 3; i++) {
    const comment = document.getElementById(`repcomment4${i}`);
    comment.style.display = i === commentNumber ? "block" : "none";
  }
}

function toggleReplyForm4(commentNumber) {
  const form = document.getElementById(`repcomment4${commentNumber}`);
  form.style.display = form.style.display === "none" ? "block" : "none";
}


function showComment5(commentNumber) {
  // Lặp qua các comment để ẩn hiện dựa trên commentNumber được truyền vào
  for (let i = 1; i <= 3; i++) {
    const comment = document.getElementById(`repcomment5${i}`);
    comment.style.display = i === commentNumber ? "block" : "none";
  }
}

function toggleReplyForm5(commentNumber) {
  const form = document.getElementById(`repcomment5${commentNumber}`);
  form.style.display = form.style.display === "none" ? "block" : "none";
}