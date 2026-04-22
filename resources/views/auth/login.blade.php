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
      margin:0 0 6px;
    }

    .sub{
      color:var(--muted);
      margin-bottom:28px;
      font-size:15px;
    }

    .form-label{
      font-weight:500;
      font-size:13.5px;
      margin-bottom:6px;
      color:#334155;
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
      font-size:18px;
      pointer-events:none;
    }

    .form-control.auth-input{
      height:48px;
      padding-left:42px;
      padding-right:44px; /* ✅ FIX for eye icon */
      border:1px solid var(--line);
      border-radius:12px;
      background:#fff;
      font-size:14.5px;
    }

    .form-control.auth-input:focus{
      border-color:var(--brand-1);
      box-shadow:0 0 0 4px rgba(255,106,61,.15);
    }

    /* ✅ FIXED TOGGLE POSITION */
    .pw-toggle{
      position:absolute;
      right:12px;
      top:50%;
      transform:translateY(-50%);
      height:100%;
      display:flex;
      align-items:center;
      justify-content:center;
      background:none;
      border:0;
      color:#94a3b8;
      cursor:pointer;
      padding:0;
    }

    .pw-toggle:hover{
      color:#0f172a;
    }

    .btn-auth{
      height:48px;
      border-radius:12px;
      font-weight:600;
      font-size:15px;
      background:linear-gradient(135deg,var(--brand-1),var(--brand-2));
      border:0;
      color:#fff;
      width:100%;
    }

    .btn-auth:hover{
      transform:translateY(-1px);
    }

    .auth-meta{
      display:flex;
      justify-content:space-between;
      margin:8px 0 20px;
      font-size:13.5px;
    }

    .auth-meta a{
      color:var(--brand-2);
      text-decoration:none;
    }

    .divider{
      display:flex;
      align-items:center;
      gap:12px;
      margin:22px 0;
      color:#94a3b8;
      font-size:12px;
    }

    .divider::before,
    .divider::after{
      content:"";
      flex:1;
      height:1px;
      background:var(--line);
    }

    .foot{
      text-align:center;
      color:var(--muted);
      font-size:14px;
    }

    .foot a{
      color:var(--brand-2);
      font-weight:600;
      text-decoration:none;
    }

    @media (max-width: 900px){
      .auth-shell{grid-template-columns:1fr;}
    }
  </style>
</head>

<body>

<div class="auth-shell">

  <main class="auth-panel">
    <div class="auth-card">

      <h2>Welcome back</h2>
      <p class="sub">Sign in to continue to your dashboard.</p>

      @if ($errors->any())
        <div style="background:#fff1f0;padding:10px;border-radius:10px;margin-bottom:16px;">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <!-- EMAIL -->
        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-wrap">
            <iconify-icon icon="solar:letter-linear"></iconify-icon>
            <input type="email" name="email"
                   class="form-control auth-input"
                   value="{{ old('email') }}"
                   placeholder="you@example.com" required>
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="mb-2">
          <label class="form-label">Password</label>

          <div class="input-wrap">
            <iconify-icon icon="solar:lock-password-linear"></iconify-icon>

            <input type="password" id="password"
                   name="password"
                   class="form-control auth-input"
                   placeholder="••••••••"
                   required>

            <button type="button"
                    class="pw-toggle"
                    onclick="togglePassword('password', this)">
              <iconify-icon icon="solar:eye-linear"></iconify-icon>
            </button>
          </div>
        </div>

        <!-- META -->
        <div class="auth-meta">
          <label>
            <input type="checkbox" name="remember"> Remember me
          </label>

          <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit" class="btn-auth">Sign in</button>
      </form>

      <div class="divider">or</div>

      <div class="foot">
        New here? <a href="{{ route('register') }}">Create account</a>
      </div>

    </div>
  </main>

</div>

<script>
function togglePassword(id, btn){
  const el = document.getElementById(id);
  const show = el.type === 'password';

  el.type = show ? 'text' : 'password';

  btn.querySelector('iconify-icon')
     .setAttribute('icon', show ? 'solar:eye-closed-linear' : 'solar:eye-linear');
}
</script>

</body>
</html>