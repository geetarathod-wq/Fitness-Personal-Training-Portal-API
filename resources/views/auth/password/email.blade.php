<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password · Fitness Portal</title>

  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logos/logo.svg') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    html,body{height:100%;}
    body{
      font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;
      background:var(--bg);
      color:var(--ink);
      margin:0;
    }
    .auth-shell{
      display:grid;
      grid-template-columns:1fr 1fr;
      min-height:100vh;
    }

    /* LEFT HERO (same as login) */
    .auth-hero{
      position:relative;
      overflow:hidden;
      color:#fff;
      padding:48px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      background:
        radial-gradient(1200px 600px at 110% 10%, rgba(255,255,255,.18), transparent 60%),
        radial-gradient(800px 500px at -10% 110%, rgba(0,0,0,.25), transparent 60%),
        linear-gradient(135deg,var(--brand-1) 0%, var(--brand-2) 100%);
    }
    .auth-hero::after{
      content:"";
      position:absolute; inset:0;
      background-image:
        linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px);
      background-size:40px 40px;
      mask-image:radial-gradient(80% 60% at 50% 50%, black, transparent);
      pointer-events:none;
    }

    .hero-brand{
      display:flex; align-items:center; gap:12px;
      font-weight:700;
    }
    .hero-brand .mark{
      width:40px;height:40px;border-radius:10px;
      background:rgba(255,255,255,.15);
      display:grid;place-items:center;
    }

    .hero-copy h1{
      font-size:44px;
      font-weight:800;
      margin-bottom:16px;
    }

    .hero-copy p{
      font-size:16px;
      opacity:.9;
      max-width:400px;
    }

    /* RIGHT FORM */
    .auth-panel{
      display:flex;
      align-items:center;
      justify-content:center;
      padding:48px 24px;
    }

    .auth-card{
      width:100%;
      max-width:420px;
    }

    .auth-card h2{
      font-size:28px;
      font-weight:700;
      margin-bottom:6px;
    }

    .auth-card .sub{
      color:var(--muted);
      margin-bottom:25px;
    }

    .form-label{
      font-size:13.5px;
      font-weight:500;
    }

    .input-wrap{
      position:relative;
    }

    .input-wrap iconify-icon{
      position:absolute;
      left:14px;
      top:50%;
      transform:translateY(-50%);
      color:#94a3b8;
    }

    .form-control.auth-input{
      height:48px;
      padding-left:42px;
      border:1px solid var(--line);
      border-radius:12px;
    }

    .btn-auth{
      height:48px;
      border-radius:12px;
      font-weight:600;
      background:linear-gradient(135deg,var(--brand-1),var(--brand-2));
      border:0;
      color:#fff;
      width:100%;
    }

    .alert-modern{
      background:#fff1f0;
      border:1px solid #ffd1cf;
      color:#9b1c1c;
      border-radius:10px;
      padding:10px;
      margin-bottom:15px;
    }

    .success-modern{
      background:#ecfdf5;
      border:1px solid #10b981;
      color:#065f46;
      border-radius:10px;
      padding:10px;
      margin-bottom:15px;
    }

    .foot{
      text-align:center;
      margin-top:20px;
      color:var(--muted);
    }

    .foot a{
      color:var(--brand-2);
      text-decoration:none;
      font-weight:600;
    }

    @media (max-width: 900px){
      .auth-shell{grid-template-columns:1fr;}
      .auth-hero{display:none;}
    }
  </style>
</head>

<body>

<div class="auth-shell">
<aside class="auth-hero">

  <div class="hero-brand">
    <div class="mark">
      <iconify-icon icon="solar:dumbbell-large-minimalistic-bold" style="font-size:22px;"></iconify-icon>
    </div>
    <span>Fitness Portal</span>
  </div>

  <div class="hero-copy">

    <h1>
      Can’t access<br>your account?
    </h1>

    <p>
      Reset your password and continue tracking your fitness journey without losing progress.
    </p>

    <ul class="hero-bullets">
      <li>
        <iconify-icon icon="solar:lock-password-bold"></iconify-icon>
        Secure password recovery system
      </li>

      <li>
        <iconify-icon icon="solar:letter-bold"></iconify-icon>
        Instant reset link sent to your email
      </li>

      <li>
        <iconify-icon icon="solar:shield-check-bold"></iconify-icon>
        Your data stays fully protected
      </li>
    </ul>

  </div>

  <div class="hero-footer">
    © {{ date('Y') }} Fitness Portal. All rights reserved.
  </div>

</aside>

  <!-- RIGHT FORM -->
  <main class="auth-panel">
    <div class="auth-card">

      <h2>Forgot Password</h2>
      <p class="sub">Enter your registered email to receive a reset link.</p>

      @if(session('success'))
        <div class="success-modern">
          {{ session('success') }}
        </div>
      @endif

      @error('email')
        <div class="alert-modern">
          {{ $message }}
        </div>
      @enderror

      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-wrap">
            <iconify-icon icon="solar:letter-linear"></iconify-icon>
            <input type="email" name="email"
                   class="form-control auth-input"
                   placeholder="you@example.com"
                   required>
          </div>
        </div>

        <button type="submit" class="btn-auth">
          Send Reset Link
        </button>
      </form>

      <div class="foot">
        Back to <a href="{{ route('login') }}">Login</a>
      </div>

    </div>
  </main>

</div>

</body>
</html>