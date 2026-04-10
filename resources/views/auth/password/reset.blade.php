<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
      
      <div class="card p-4" style="width:350px;">

        <!-- Logo -->
        <div class="text-center mb-3">
          <img src="{{ asset('assets/images/logos/fitness_logo.svg') }}" width="120">
        </div>

        <!-- Title -->
        <h5 class="text-center mb-2">Reset Password</h5>

        <!-- Subtitle -->
        <p class="text-center text-muted" style="font-size: 13px;">
          Enter your new password
        </p>

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}">
          @csrf

          <!-- Token -->
          <input type="hidden" name="token" value="{{ $token }}">

          <!-- Email -->
          <div class="mb-3">
            <label>Email</label>
            <input type="email" 
                   name="email" 
                   value="{{ request()->email }}" 
                   class="form-control" 
                   required>
          </div>

          <!-- Password -->
          <div class="mb-3 position-relative">
            <label>New Password</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <!-- 👁 Toggle -->
            <span onclick="togglePassword('password')" 
                  style="position:absolute; right:10px; top:38px; cursor:pointer;">
              👁
            </span>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3 position-relative">
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="password_confirmation" class="form-control" required>

            <!-- 👁 Toggle -->
            <span onclick="togglePassword('confirm_password')" 
                  style="position:absolute; right:10px; top:38px; cursor:pointer;">
              👁
            </span>
          </div>

          <!-- Errors -->
          @error('email')
            <div class="text-danger mb-2">{{ $message }}</div>
          @enderror

          @error('password')
            <div class="text-danger mb-2">{{ $message }}</div>
          @enderror

          <!-- Button -->
          <button type="submit" class="btn btn-primary w-100">
            Reset Password
          </button>
        </form>

        <!-- Back to login -->
        <div class="text-center mt-3">
          <a href="{{ route('login') }}">Back to Login</a>
        </div>

      </div>

    </div>
  </div>

  <!-- Toggle Script -->
  <script>
    function togglePassword(id) {
      let input = document.getElementById(id);
      input.type = input.type === "password" ? "text" : "password";
    }
  </script>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>