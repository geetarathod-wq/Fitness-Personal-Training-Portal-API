<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password · Fitness Portal</title>

  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logos/logo.svg') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <style>
    :root{
      --brand-1:#ff6a3d;
      --brand-2:#ff2e63;
      --ink:#0f172a;
      --muted:#64748b;
      --line:#e5e7eb;
      --bg:#f7f8fb;
    }

    body{
      font-family:'Inter',sans-serif;
      background:var(--bg);
      margin:0;
    }

    /* MAIN WRAPPER */
    .auth-wrapper{
      display:flex;
      min-height:100vh;
    }

    /* LEFT HERO (UPDATED SAME AS LOGIN STYLE) */
    .auth-hero{
      position:relative;
      overflow:hidden;
      color:#fff;
      padding:48px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      width:45%;
      background:
        radial-gradient(1200px 600px at 110% 10%, rgba(255,255,255,.18), transparent 60%),
        radial-gradient(800px 500px at -10% 110%, rgba(0,0,0,.25), transparent 60%),
        linear-gradient(135deg,var(--brand-1) 0%, var(--brand-2) 100%);
    }

    .hero-brand{
      display:flex;
      align-items:center;
      gap:12px;
      font-weight:700;
    }

    .hero-brand .mark{
      width:40px;
      height:40px;
      border-radius:10px;
      background:rgba(255,255,255,.15);
      display:grid;
      place-items:center;
      backdrop-filter:blur(8px);
    }

    .hero-copy h1{
      font-size:44px;
      line-height:1.1;
      font-weight:800;
      margin:0 0 16px;
      letter-spacing:-.02em;
    }

    .hero-copy p{
      font-size:17px;
      opacity:.9;
      max-width:440px;
      margin:0 0 28px;
    }

    .hero-bullets{
      list-style:none;
      padding:0;
      margin:0;
      display:grid;
      gap:12px;
    }

    .hero-bullets li{
      display:flex;
      align-items:center;
      gap:10px;
      font-size:15px;
      opacity:.95;
    }

    .hero-footer{
      font-size:13px;
      opacity:.75;
    }

    /* RIGHT FORM */
    .auth-form{
      width:55%;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:20px;
    }

    .auth-card{
      width:100%;
      max-width:420px;
    }

    .form-control{
      height:45px;
      border-radius:10px;
      margin-bottom:15px;
      width:100%;
      padding:10px;
      border:1px solid #ddd;
    }

    .btn-auth{
      height:45px;
      border-radius:10px;
      background:linear-gradient(135deg,var(--brand-1),var(--brand-2));
      border:none;
      color:#fff;
      width:100%;
      cursor:pointer;
    }

    .text-center{text-align:center;}
    .mt-2{margin-top:10px;}
    .mt-3{margin-top:15px;}
    .mb-2{margin-bottom:10px;}
    .mb-4{margin-bottom:20px;}
    .text-muted{color:var(--muted);}

    .alert{
      padding:10px;
      background:#fee2e2;
      color:#991b1b;
      border-radius:8px;
      margin-bottom:15px;
    }

    @media (max-width: 900px){
      .auth-wrapper{flex-direction:column;}
      .auth-hero{display:none;}
      .auth-form{width:100%;}
    }
  </style>
</head>

<body>

<div class="auth-wrapper">

  <!-- LEFT HERO (FIXED EXACTLY AS LOGIN STYLE) -->
  <aside class="auth-hero">

    <div class="hero-brand">
      <div class="mark">
        <iconify-icon icon="solar:dumbbell-large-minimalistic-bold" style="font-size:22px;"></iconify-icon>
      </div>
      <span>Fitness Portal</span>
    </div>

    <div class="hero-copy">
      <h1>Push harder.<br>Track smarter.</h1>
      <p>One workspace for trainers and clients — build plans, log progress, and watch results compound.</p>

      <ul class="hero-bullets">
        <li>
          <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
          Custom training plans per client
        </li>
        <li>
          <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
          Daily weight &amp; calorie logs with charts
        </li>
        <li>
          <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
          Exercise library &amp; reusable templates
        </li>
      </ul>
    </div>

    <div class="hero-footer">
      © {{ date('Y') }} Fitness Portal. All rights reserved.
    </div>

  </aside>

  <!-- RIGHT FORM -->
  <main class="auth-form">
    <div class="auth-card">

      <h2 class="mb-2">Reset Password</h2>
      <p class="text-muted mb-4">Enter your new password</p>

      @if ($errors->any())
        <div class="alert">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <input type="email" name="email" value="{{ request()->email }}" class="form-control" required>

        <input type="password" name="password" placeholder="New Password" class="form-control" required>

        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>

        <button type="submit" class="btn-auth mt-2">
          Reset Password
        </button>
      </form>

      <div class="text-center mt-3">
        <a href="{{ route('login') }}">Back to Login</a>
      </div>

    </div>
  </main>

</div>

</body>
</html>