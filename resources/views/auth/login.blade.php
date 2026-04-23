

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign in · Fitness Portal</title>

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
    /* LEFT — gradient hero */
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
      font-weight:700; letter-spacing:.3px;
      position:relative; z-index:1;
    }
    .hero-brand .mark{
      width:40px;height:40px;border-radius:10px;
      background:rgba(255,255,255,.15);
      display:grid;place-items:center;
      backdrop-filter:blur(8px);
    }
    .hero-copy{position:relative;z-index:1;}
    .hero-copy h1{
      font-size:44px; line-height:1.1; font-weight:800; margin:0 0 16px;
      letter-spacing:-.02em;
    }
    .hero-copy p{
      font-size:17px; opacity:.9; max-width:440px; margin:0 0 28px;
    }
    .hero-bullets{list-style:none; padding:0; margin:0; display:grid; gap:12px;}
    .hero-bullets li{
      display:flex; align-items:center; gap:10px; font-size:15px; opacity:.95;
    }
    .hero-bullets iconify-icon{font-size:20px;}
    .hero-footer{
      position:relative; z-index:1;
      font-size:13px; opacity:.75;
    }

    /* RIGHT — form */
    .auth-panel{
      display:flex; align-items:center; justify-content:center;
      padding:48px 24px;
    }
    .auth-card{
      width:100%; max-width:420px;
    }
    .auth-card h2{
      font-size:28px; font-weight:700; margin:0 0 6px; letter-spacing:-.01em;
    }
    .auth-card .sub{
      color:var(--muted); margin-bottom:28px; font-size:15px;
    }
    .form-label{font-weight:500; font-size:13.5px; margin-bottom:6px; color:#334155;}
    .input-wrap{position:relative;}
    .input-wrap iconify-icon{
      position:absolute; left:14px; top:50%; transform:translateY(-50%);
      color:#94a3b8; font-size:18px; pointer-events:none;
    }
    .form-control.auth-input{
      height:48px;
      padding-left:42px;
      padding-right:42px;
      border:1px solid var(--line);
      border-radius:12px;
      background:#fff;
      font-size:14.5px;
      transition:border-color .15s, box-shadow .15s;
    }
    .form-control.auth-input:focus{
      border-color:var(--brand-1);
      box-shadow:0 0 0 4px rgba(255,106,61,.15);
    }
    .pw-toggle{
      position:absolute;
      right:12px;
      top:50%;
      transform:translateY(-50%);
      background:none;
      border:0;
      color:#94a3b8;
      padding:4px;
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
      height:24px;
      width:24px;
    }
  
    .pw-toggle:hover{color:var(--ink);}
    .btn-auth{
      height:48px; border-radius:12px; font-weight:600; font-size:15px;
      background:linear-gradient(135deg,var(--brand-1),var(--brand-2));
      border:0; color:#fff; width:100%;
      box-shadow:0 8px 24px -8px rgba(255,46,99,.5);
      transition:transform .08s, box-shadow .15s;
    }
    .btn-auth:hover{transform:translateY(-1px); box-shadow:0 10px 28px -8px rgba(255,46,99,.6); color:#fff;}
    .btn-auth:active{transform:translateY(0);}
    .auth-meta{
      display:flex; align-items:center; justify-content:space-between;
      margin:8px 0 20px;
      font-size:13.5px;
    }
    .auth-meta a{color:var(--brand-2); text-decoration:none; font-weight:500;}
    .auth-meta a:hover{text-decoration:underline;}
    .divider{
      display:flex; align-items:center; gap:12px; margin:22px 0;
      color:#94a3b8; font-size:12px; text-transform:uppercase; letter-spacing:.12em;
    }
    .divider::before,.divider::after{content:""; flex:1; height:1px; background:var(--line);}
    .foot{
      text-align:center; color:var(--muted); font-size:14px;
    }
    .foot a{color:var(--brand-2); font-weight:600; text-decoration:none;}
    .foot a:hover{text-decoration:underline;}
    .alert-modern{
      background:#fff1f0; border:1px solid #ffd1cf; color:#9b1c1c;
      border-radius:10px; padding:10px 14px; font-size:13.5px; margin-bottom:16px;
      display:flex; align-items:flex-start; gap:8px;
    }

    @media (max-width: 900px){
      .auth-shell{grid-template-columns:1fr;}
      .auth-hero{display:none;}
      .auth-panel{padding:32px 20px;}
    }
  </style>
</head>

<body>
  <div class="auth-shell">

    <!-- LEFT: HERO -->
    <aside class="auth-hero">
      <div class="hero-brand">
        <div class="mark"><iconify-icon icon="solar:dumbbell-large-minimalistic-bold" style="font-size:22px;"></iconify-icon></div>
        <span>Fitness Portal</span>
      </div>

      <div class="hero-copy">
        <h1>Push harder.<br>Track smarter.</h1>
        <p>One workspace for trainers and clients — build plans, log progress, and watch results compound.</p>
        <ul class="hero-bullets">
          <li><iconify-icon icon="solar:check-circle-bold"></iconify-icon> Custom training plans per client</li>
          <li><iconify-icon icon="solar:check-circle-bold"></iconify-icon> Daily weight &amp; calorie logs with charts</li>
          <li><iconify-icon icon="solar:check-circle-bold"></iconify-icon> Exercise library &amp; reusable templates</li>
        </ul>
      </div>

      <div class="hero-footer">© {{ date('Y') }} Fitness Portal. All rights reserved.</div>
    </aside>

    <!-- RIGHT: FORM -->
    <main class="auth-panel">
      <div class="auth-card">
        <h2>Welcome back</h2>
        <p class="sub">Sign in to continue to your dashboard.</p>

        @if ($errors->any())
          <div class="alert-modern">
            <iconify-icon icon="solar:shield-warning-bold"></iconify-icon>
            <div>{{ $errors->first() }}</div>
          </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" novalidate>
          @csrf

          <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <div class="input-wrap">
              <iconify-icon icon="solar:letter-linear"></iconify-icon>
              <input type="email" id="email" name="email" value="{{ old('email') }}"
                     class="form-control auth-input" placeholder="you@example.com" required autofocus>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
              <iconify-icon icon="solar:lock-password-linear"></iconify-icon>
              <input type="password" id="password" name="password"
                     class="form-control auth-input" placeholder="••••••••" required>
              <button type="button" class="pw-toggle" onclick="togglePassword('password', this)" aria-label="Show password">
                <iconify-icon icon="solar:eye-linear" style="font-size:18px;"></iconify-icon>
              </button>
            </div>
          </div>

          <div class="auth-meta">
            <label class="d-flex align-items-center gap-2 mb-0" style="font-size:13.5px; color:#475569;">
              <input type="checkbox" name="remember" style="accent-color:var(--brand-2);"> Remember me
            </label>
            <a href="{{ route('password.request') }}">Forgot password?</a>
          </div>

          <button type="submit" class="btn-auth">Sign in</button>
        </form>

        <div class="divider">or</div>

        <div class="foot">
          New here? <a href="{{ route('register') }}">Create an account</a>
        </div>
      </div>
    </main>
  </div>

  <script>
    function togglePassword(id, btn){
      const el = document.getElementById(id);
      const show = el.type === 'password';
      el.type = show ? 'text' : 'password';
      btn.querySelector('iconify-icon').setAttribute('icon', show ? 'solar:eye-closed-linear' : 'solar:eye-linear');
    }
  </script>
</body>
</html>
