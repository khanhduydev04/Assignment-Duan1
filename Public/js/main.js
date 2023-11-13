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
