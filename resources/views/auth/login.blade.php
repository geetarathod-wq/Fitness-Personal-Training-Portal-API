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
      <div class="card p-4">
        
        <div class="text-center mb-3">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" width="120">
        </div>

        <form>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control">
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control">
          </div>

          <!-- ✅ FIXED BUTTON -->
          <a href="/dashboard" class="btn btn-primary w-100">Sign In</a>
        </form>

        <div class="text-center mt-3">
          <span>New user?</span>
          <a href="/register">Create account</a>
        </div>

      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>