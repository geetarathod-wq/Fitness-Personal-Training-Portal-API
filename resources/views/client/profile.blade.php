@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container mt-4">

    <div class="card p-4 shadow-sm">

        <h4 class="mb-4">👤 My Profile</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <form method="POST" action="{{ route('client.profile.update') }}" id="profileForm">
            @csrf

            <!-- NAME -->
            <div class="mb-3">
                <label>Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="form-control">

                <small class="text-danger d-none" id="nameError">Please enter name</small>
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label>Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="form-control">

                <small class="text-danger d-none" id="emailError">Please enter valid email</small>
            </div>

            <!-- CURRENT PASSWORD -->
            <div class="mb-3">
                <label>Current Password</label>

                <div class="input-group">
                    <input type="password" id="current_password" name="current_password" class="form-control">

                    <button type="button" class="btn btn-light border toggle-password"
                            data-target="current_password">
                        <i class="fa-solid fa-eye text-muted"></i>
                    </button>
                </div>
            </div>

            <!-- NEW PASSWORD -->
            <div class="mb-3">
                <label>New Password</label>

                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control">

                    <button type="button" class="btn btn-light border toggle-password"
                            data-target="password">
                        <i class="fa-solid fa-eye text-muted"></i>
                    </button>
                </div>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-3">
                <label>Confirm Password</label>

                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">

                    <button type="button" class="btn btn-light border toggle-password"
                            data-target="password_confirmation">
                        <i class="fa-solid fa-eye text-muted"></i>
                    </button>
                </div>

                <small id="pwMsg" class="form-text"></small>
            </div>

            <button class="btn btn-primary w-100">
                Update Profile
            </button>

        </form>
    </div>
</div>

<style>
/* INPUT CLEAN STYLE */
.input-group .form-control:focus {
    box-shadow: none;
}

/* TOGGLE BUTTON FIX */
.toggle-password {
    border-left: 0 !important;
    background: #fff;
    border-color: #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.toggle-password:hover {
    background: #f8f9fa;
}

/* ICON DEFAULT */
.toggle-password i {
    font-size: 14px;
    color: #6c757d;
    transition: 0.2s ease;
}

/* ACTIVE STATE (IMPORTANT FIX) */
.toggle-password.active i {
    color: #0d6efd;
}

/* ERROR BORDER */
.is-invalid {
    border: 2px solid #dc3545 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('profileForm');

    const name = document.getElementById('name');
    const email = document.getElementById('email');

    const pw = document.getElementById('password');
    const cf = document.getElementById('password_confirmation');

    const msg = document.getElementById('pwMsg');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');

    // ✅ PROFESSIONAL TOGGLE FIX
    document.querySelectorAll('.toggle-password').forEach(btn => {

        btn.addEventListener('click', function () {

            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

                this.classList.add('active'); // 🔥 color fix
            } else {
                input.type = 'password';

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

                this.classList.remove('active'); // 🔥 reset color
            }

        });

    });

    // ✅ PASSWORD MATCH
    function checkPassword() {

        if (!pw.value && !cf.value) {
            msg.textContent = '';
            return;
        }

        if (pw.value !== cf.value) {
            msg.textContent = "✗ Passwords do not match";
            msg.className = "form-text text-danger";
        } else {
            msg.textContent = "✓ Passwords match";
            msg.className = "form-text text-success";
        }
    }

    pw.addEventListener('input', checkPassword);
    cf.addEventListener('input', checkPassword);

    // ✅ VALIDATION
    function scrollError(el) {
        el.classList.add('is-invalid');
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        el.focus();
    }

    form.addEventListener('submit', function (e) {

        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        nameError.classList.add('d-none');
        emailError.classList.add('d-none');

        if (!name.value.trim()) {
            e.preventDefault();
            nameError.classList.remove('d-none');
            scrollError(name);
            return;
        }

        if (!email.value.trim()) {
            e.preventDefault();
            emailError.classList.remove('d-none');
            scrollError(email);
            return;
        }

        if (pw.value && pw.value !== cf.value) {
            e.preventDefault();
            scrollError(cf);
            return;
        }

    });

});
</script>

@endsection