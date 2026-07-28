//======================================
// SHOW PASSWORD
//======================================

const password = document.getElementById("password");

const confirmPassword = document.getElementById("confirmPassword");

const togglePassword = document.getElementById("togglePassword");

togglePassword.addEventListener("click", () => {
  const type = password.type === "password" ? "text" : "password";

  password.type = type;

  confirmPassword.type = type;

  togglePassword.classList.toggle("bi-eye");

  togglePassword.classList.toggle("bi-eye-slash");
});

//======================================
// PASSWORD STRENGTH
//======================================

const strengthBar = document.getElementById("strengthBar");

const strengthText = document.getElementById("strengthText");

password.addEventListener("keyup", () => {
  const value = password.value;

  let score = 0;

  if (value.length >= 8) score++;

  if (/[A-Z]/.test(value)) score++;

  if (/[0-9]/.test(value)) score++;

  if (/[^A-Za-z0-9]/.test(value)) score++;

  switch (score) {
    case 0:
      strengthBar.style.width = "0%";

      strengthText.innerHTML = "Password Strength";

      break;

    case 1:
      strengthBar.style.width = "25%";

      strengthBar.style.background = "#EF4444";

      strengthText.innerHTML = "Weak Password";

      break;

    case 2:
      strengthBar.style.width = "50%";

      strengthBar.style.background = "#F59E0B";

      strengthText.innerHTML = "Medium Password";

      break;

    case 3:
      strengthBar.style.width = "75%";

      strengthBar.style.background = "#3B82F6";

      strengthText.innerHTML = "Good Password";

      break;

    case 4:
      strengthBar.style.width = "100%";

      strengthBar.style.background = "#10B981";

      strengthText.innerHTML = "Strong Password";

      break;
  }
});

//======================================
// FORM VALIDATION
//======================================

const form = document.getElementById("registerForm");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  if (password.value !== confirmPassword.value) {
    Swal.fire({
      icon: "error",

      title: "Password Tidak Sama",

      text: "Password dan konfirmasi password harus sama.",
    });

    return;
  }

  const btn = document.querySelector(".register-btn");

  btn.disabled = true;

  btn.innerHTML = `

        <span class="spinner-border spinner-border-sm"></span>

        Creating Account...

    `;

  setTimeout(() => {
    btn.disabled = false;

    btn.innerHTML = `

        <i class="bi bi-person-plus-fill"></i>

        Create Account

        `;

    Swal.fire({
      icon: "success",

      title: "Register Berhasil",

      text: "Silahkan login menggunakan akun Anda.",

      confirmButtonColor: "#2563EB",
    }).then(() => {
      window.location = "login.html";
    });
  }, 2500);
});

//======================================
// RIPPLE BUTTON
//======================================

document.querySelector(".register-btn").addEventListener("click", function (e) {
  const circle = document.createElement("span");

  const diameter = Math.max(this.clientWidth, this.clientHeight);

  circle.style.width = circle.style.height = diameter + "px";

  circle.style.left = e.offsetX - diameter / 2 + "px";

  circle.style.top = e.offsetY - diameter / 2 + "px";

  circle.classList.add("ripple");

  this.appendChild(circle);

  setTimeout(() => {
    circle.remove();
  }, 600);
});
