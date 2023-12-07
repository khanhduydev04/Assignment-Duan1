function isEmailValid(email) {
  // Sử dụng một biểu thức chính quy để kiểm tra định dạng email
  const emailPattern =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return emailPattern.test(email);
}

function isPhoneNumberValid(phone) {
  // Biểu thức chính quy kiểm tra số điện thoại có chứa tối đa 11 số, không có chữ cái và không có ký tự đặc biệt
  const phonePattern = /^[0-9]{1,11}$/;
  return phonePattern.test(phone);
}

function isPasswordValid(pass) {
  // Kiểm tra xem mật khẩu có ít nhất 8 ký tự không
  ///^(?=.*[A-Za-z])(?=.*\d)[^\w\s][A-Za-z\d]{8,}$/
  const passPattern = /^(?=[A-Za-z0-9])(?=.*[^\w\s])(?!.*\s).{1,8}$/;
  return passPattern.test(pass);
}

function isFormValid() {
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const password = document.getElementById("password").value;
  const lastname = document.getElementById("lastname").value;
  const firstname = document.getElementById("firstname").value;
  const gender = document.querySelectorAll('input[name="gender"]:checked');

  const lastSpan = document.getElementById("lastSpan");
  const firstSpan = document.getElementById("firstSpan");
  const emailText = document.getElementById("emailText");
  const phoneText = document.getElementById("phoneText");
  const passText = document.getElementById("passText");
  const genderSpan = document.getElementById("genderSpan");

  let isValid = true;

  if (gender.length === 0) {
    genderSpan.innerText = "Vui lòng chọn giới tính";
    isValid = false;
  } else {
    genderSpan.innerText = "";
  }

  if (email.trim() === "") {
    emailText.innerText = "Vui lòng nhập địa chỉ email";
    isValid = false;
  } else if (!isEmailValid(email)) {
    emailText.innerText = "Email không đúng định dạng";
    isValid = false;
  } else {
    emailText.innerText = "";
  }

  if (phone.trim() === "") {
    phoneText.innerText = "Vui lòng nhập số điện thoại";
    isValid = false;
  } else if (!isPhoneNumberValid(phone)) {
    phoneText.innerText = "Số điện thoại không đúng định dạng";
    isValid = false;
  } else {
    phoneText.innerText = "";
  }

  if (password.trim() === "") {
    passText.innerText = "Vui lòng nhập mật khẩu";
    isValid = false;
  } else if (!isPasswordValid(password)) {
    passText.innerText =
      "Mật khẩu tối thiểu 8 ký tự bao gồm chữ số và ký tự đặc biệt";
    isValid = false;
  } else {
    passText.innerText = "";
  }

  if (lastname.trim() === "") {
    lastSpan.innerText = "Vui lòng nhập Họ";
    isValid = false;
  } else {
    lastSpan.innerText = "";
  }

  if (firstname.trim() === "") {
    firstSpan.innerText = "Vui lòng nhập Tên";
    isValid = false;
  } else {
    firstSpan.innerText = "";
  }

  return isValid;
}

function handleFormSubmit(e) {
  if (!isFormValid()) {
    e.preventDefault(); // Ngăn form được gửi đi nếu thông tin không hợp lệ
  }
}

// login
function isLoginValid() {
  const email = document.getElementById("email1").value;
  const password = document.getElementById("password1").value;

  const email_Span = document.getElementById("email_Span");
  const pass_Span = document.getElementById("password_Span");

  let isValid = true;

  if (email.trim() === "") {
    email_Span.innerText = "Vui lòng nhập địa chỉ email";
    isValid = false;
  } else {
    email_Span.innerText = "";
  }

  if (password.trim() === "") {
    pass_Span.innerText = "Vui lòng nhập mật khẩu";
    isValid = false;
  } else {
    pass_Span.innerText = "";
  }

  return isValid;
}

function LoginFormSubmit(e) {
  if (!isLoginValid()) {
    e.preventDefault(); // Ngăn form được gửi đi nếu thông tin không hợp lệ
  }
}
//update setting
function isFormUpdate() {
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const lastname = document.getElementById("lastname").value;
  const firstname = document.getElementById("firstname").value;

  const lastSpan = document.getElementById("lastSpan");
  const firstSpan = document.getElementById("firstSpan");
  const emailText = document.getElementById("emailText");
  const phoneText = document.getElementById("phoneText");

  let isValid = true;

  if (email.trim() === "") {
    emailText.innerText = "Vui lòng nhập địa chỉ email";
    isValid = false;
  } else if (!isEmailValid(email)) {
    emailText.innerText = "Email không đúng định dạng";
    isValid = false;
  } else {
    emailText.innerText = "";
  }

  if (phone.trim() === "") {
    phoneText.innerText = "Vui lòng nhập số điện thoại";
    isValid = false;
  } else if (!isPhoneNumberValid(phone)) {
    phoneText.innerText = "Số điện thoại không đúng định dạng";
    isValid = false;
  } else {
    phoneText.innerText = "";
  }

  if (lastname.trim() === "") {
    lastSpan.innerText = "Vui lòng nhập Họ";
    isValid = false;
  } else {
    lastSpan.innerText = "";
  }

  if (firstname.trim() === "") {
    firstSpan.innerText = "Vui lòng nhập Tên";
    isValid = false;
  } else {
    firstSpan.innerText = "";
  }

  return isValid;
}

function UpdateFormSubmit(e) {
  if (!isFormUpdate()) {
    e.preventDefault(); // Ngăn form được gửi đi nếu thông tin không hợp lệ
  }
}

function validateForm() {
  let password = document.getElementById("password").value.trim();
  let newPassword = document.getElementById("newpassword").value.trim();
  let rePassword = document.getElementById("repassword").value.trim();

  let passwordError = document.getElementById("passwordError");
  let newPasswordError = document.getElementById("newpasswordError");
  let rePasswordError = document.getElementById("repasswordError");

  let isValid = true;

  // Kiểm tra mật khẩu hiện tại không được để trống
  if (password === "") {
    passwordError.style.display = "block";
    isValid = false;
  } else {
    passwordError.style.display = "none";
  }

  // Kiểm tra mật khẩu mới không được để trống
  if (newPassword === "") {
    newPasswordError.style.display = "block";
    isValid = false;
  } else {
    newPasswordError.style.display = "none";
  }

  // Kiểm tra mật khẩu nhập lại không được để trống và phải trùng với mật khẩu mới
  if (rePassword === "") {
    rePasswordError.style.display = "block";
    isValid = false;
  } else if (rePassword !== newPassword) {
    rePasswordError.innerHTML =
      "Mật khẩu nhập lại không khớp với mật khẩu mới.";
    rePasswordError.style.display = "block";
    isValid = false;
  } else {
    rePasswordError.style.display = "none";
  }

  return isValid;
}
