<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4">

        <div class="text-center mb-3">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" width="120">
        </div>

      <form method="POST" action="{{ route('register.store') }}">
      @csrf

          <!-- NAME -->
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <!-- EMAIL -->
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <!-- PASSWORD -->
          <div class="mb-3 position-relative">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" required>

            <span onclick="togglePassword('password')"
                  style="position:absolute; right:15px; top:38px; cursor:pointer;">
              
            </span>
          </div>

          <!-- CONFIRM PASSWORD -->
          <div class="mb-3 position-relative">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" id="confirm_password" class="form-control" required>

            <span onclick="togglePassword('confirm_password')"
                  style="position:absolute; right:15px; top:38px; cursor:pointer;">
              
            </span>

            <small id="msg"></small>
          </div>

          <!-- SUBMIT -->
          <button type="submit" class="btn btn-primary w-100">Sign Up</button>

        </form>

        <div class="text-center mt-3">
          <span>Already have account?</span>
          <a href="/login">Login</a>
        </div>

      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    // TOGGLE PASSWORD VISIBILITY
    function togglePassword(id) {
        let input = document.getElementById(id);
        input.type = (input.type === "password") ? "text" : "password";
    }

    // PASSWORD MATCH CHECK
    const password = document.getElementById("password");
    const confirm_password = document.getElementById("confirm_password");
    const msg = document.getElementById("msg");

    function checkMatch() {
        if (!password.value || !confirm_password.value) {
            msg.innerHTML = "";
            return;
        }

        if (password.value === confirm_password.value) {
            msg.innerHTML = "✔ Password matched";
            msg.style.color = "green";
        } else {
            msg.innerHTML = "❌ Password not matched";
            msg.style.color = "red";
        }
    }

    password.addEventListener("input", checkMatch);
    confirm_password.addEventListener("input", checkMatch);
  </script>

</body>
</html>