<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
>
  <title>Forgot Password </title>

  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logos/logo.svg') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4" style="width:350px;">
        
        <!-- Logo -->
        <div class="text-center mb-3">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" width="120">
        </div>

        <!-- Title -->
        <h5 class="text-center mb-3">Forgot Password</h5>

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <!-- Success Message -->
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          <!-- Error -->
          @error('email')
            <div class="text-danger mb-2">{{ $message }}</div>
          @enderror

          <!-- Button -->
          <button type="submit" class="btn btn-primary w-100">
            Send Reset Link
          </button>
        </form>

        <!-- Back to Login -->
        <div class="text-center mt-3">
          <a href="{{ route('login') }}">Back to Login</a>
        </div>

      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>