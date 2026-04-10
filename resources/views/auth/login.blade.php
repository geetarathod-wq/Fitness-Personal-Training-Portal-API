<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4" style="width:350px;">
        
        <div class="text-center mb-3">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" width="120">
        </div>

        <form method="POST" action="/login">
          @csrf

          <!-- Email -->
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <!-- Password with Show/Hide -->
          <div class="mb-3 position-relative">
            <label>Password</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <!-- 👁 Show/Hide Button -->
            <span onclick="togglePassword()" 
                  style="position:absolute; right:10px; top:38px; cursor:pointer;">
              👁
            </span>
          </div>

          <!-- Remember + Forgot -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            
            <!-- Remember Me -->
            <div>
              <input type="checkbox" name="remember" id="remember">
              <label for="remember">Remember me</label>
            </div>

            <!-- Forgot Password -->
            <a href="{{ route('password.request') }}">Forgot Password?</a>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>

        <div class="text-center mt-3">
          <span>New user?</span>
          <a href="/register">Create account</a>
        </div>

      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      let password = document.getElementById("password");

      if (password.type === "password") {
        password.type = "text";
      } else {
        password.type = "password";
      }
    }
  </script>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>