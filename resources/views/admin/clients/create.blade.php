@extends('layouts.admin')

@section('content')

<h4>Add Client</h4>

@if($errors->any())
<div class="alert alert-danger">
    {{ implode('', $errors->all(':message ')) }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.clients.store') }}"
              autocomplete="off">
            @csrf

            <!-- NAME -->
            <div class="mb-3">
                <label>Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       autocomplete="off"
                       value="{{ old('name') }}">
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label>Email</label>

                <input type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    autocomplete="new-email"
                    value="{{ old('email') }}">

                <small id="emailError" class="text-danger"></small>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label>Password</label>

                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           autocomplete="new-password"
                           placeholder="Enter password">

                    <button type="button"
                            id="eyeBtn"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword('password', this)">
                        👁️
                    </button>
                </div>

                <!-- PASSWORD STRENGTH -->
                <div class="mt-2">
                    <div style="height:5px;background:#e9ecef;border-radius:10px;">
                        <div id="pwBar"
                             style="height:5px;width:0%;border-radius:10px;transition:0.3s;">
                        </div>
                    </div>

                    <small id="pwText" class="text-muted">
                        Use 8+ characters with uppercase, number & symbol
                    </small>
                </div>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-3">
                <label>Confirm Password</label>

                <div class="input-group">
                    <input type="password"
                           name="password_confirmation"
                           id="confirm_password"
                           class="form-control"
                           autocomplete="new-password"
                           placeholder="Confirm password">

                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword('confirm_password', this)">
                        👁️
                    </button>
                </div>
                <small id="matchMsg"></small>
            </div>
            
            <div class="d-flex justify-content-between">
                <button class="btn btn-success">
                    Save
                </button>
                <a href="{{ route('admin.clients.index') }}"
                class="btn btn-secondary">
                    ⬅ Back
                </a>
            </div>
        </form>
    </div>
</div>

<style>
#pwBar{
    background:red;
}
.match-success{
    color:green;
}
.match-error{
    color:red;
}
.is-invalid{
    border:1px solid red !important;
}
</style>

<script>

function togglePassword(id, btn) {
    let input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        btn.innerText = "🙈";
    } else {
        input.type = "password";
        btn.innerText = "👁️";
    }
}

const pw = document.getElementById('password');
const cf = document.getElementById('confirm_password');
const pwBar = document.getElementById('pwBar');
const pwText = document.getElementById('pwText');
const matchMsg = document.getElementById('matchMsg');

function checkStrength(password) {
    let score = 0;
    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    let width = 0;
    let color = 'red';
    let text = 'Weak password';

    if (score === 1) {
        width = 25;
        color = 'red';
    }
    else if (score === 2) {
        width = 50;
        color = 'orange';
        text = 'Medium password';
    }
    else if (score === 3) {
        width = 75;
        color = '#0d6efd';
        text = 'Strong password';
    }
    else if (score === 4) {
        width = 100;
        color = 'green';
        text = 'Very strong password';
    }
    pwBar.style.width = width + '%';
    pwBar.style.background = color;
    pwText.innerText = text;
}

function checkMatch() {
    if (!pw.value || !cf.value) {
        matchMsg.innerHTML = '';
        return;
    }
    if (pw.value === cf.value) {
        matchMsg.innerHTML = '✓ Passwords match';
        matchMsg.className = 'match-success';
    } else {
        matchMsg.innerHTML = '✗ Passwords do not match';
        matchMsg.className = 'match-error';
    }
}
pw.addEventListener('input', function () {
    checkStrength(this.value);
    checkMatch();
});
cf.addEventListener('input', checkMatch);
const email = document.getElementById('email');
const form = document.querySelector('form');
const emailError = document.getElementById('emailError');
function validateEmail(emailValue) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(emailValue);
}

email.addEventListener('input', function () {

    if (!this.value.trim()) {
        emailError.innerHTML = '';
        this.classList.remove('is-invalid');
        return;
    }
    if (!validateEmail(this.value)) {
        emailError.innerHTML = 'Enter valid email';
        this.classList.add('is-invalid');
    } else {
        emailError.innerHTML = '';
        this.classList.remove('is-invalid');
    }
});

form.addEventListener('submit', function(e) {
    if (!validateEmail(email.value)) {
        e.preventDefault();
        emailError.innerHTML = 'Enter valid email';
        email.classList.add('is-invalid');
        email.focus();
    }
});
</script>
@endsection