@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">👤 Admin Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" id="password"
                       class="form-control"
                       placeholder="Leave blank if not changing"
                       minlength="6"
                       autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control"
                       placeholder="Re-enter new password"
                       autocomplete="new-password">
                <small id="pwMatchMsg" class="form-text"></small>
            </div>

            <button class="btn btn-primary">
                Update Profile
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
  (function () {
    const pw = document.getElementById('password');
    const cf = document.getElementById('password_confirmation');
    const msg = document.getElementById('pwMatchMsg');
    const form = pw.closest('form');

    function syncConfirmRequired() { cf.required = pw.value.length > 0; }
    function showMatch() {
      if (!pw.value && !cf.value) { msg.textContent = ''; msg.className = 'form-text'; return; }
      if (pw.value && !cf.value)  { msg.textContent = 'Please confirm your new password.'; msg.className = 'form-text text-danger'; return; }
      if (pw.value === cf.value)  { msg.textContent = '✓ Passwords match'; msg.className = 'form-text text-success'; }
      else                        { msg.textContent = '✗ Passwords do not match'; msg.className = 'form-text text-danger'; }
    }
    pw.addEventListener('input', () => { syncConfirmRequired(); showMatch(); });
    cf.addEventListener('input', showMatch);
    form.addEventListener('submit', (e) => {
      if (pw.value && pw.value !== cf.value) { e.preventDefault(); showMatch(); cf.focus(); }
    });
    syncConfirmRequired();
  })();
</script>
@endpush
@endsection